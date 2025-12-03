#!/usr/bin/env bash
set -euo pipefail

# SkyReel new server bootstrap script
# Usage: sudo bash bootstrap-new-server.sh <domain> <letsencrypt_email>
# Example: sudo bash bootstrap-new-server.sh skyreel.art admin@skyreel.art

DOMAIN=${1:?"Domain required"}
LE_EMAIL=${2:?"Let's Encrypt email required"}

export DEBIAN_FRONTEND=noninteractive

log() { echo "[BOOTSTRAP] $*"; }

log "Updating system packages"
apt-get update -y
apt-get upgrade -y
apt-get install -y --no-install-recommends \
  ca-certificates apt-transport-https software-properties-common \
  curl wget git unzip lsof ufw \
  nginx \
  mysql-server \
  php8.3 php8.3-fpm php8.3-cli php8.3-common php8.3-curl php8.3-intl php8.3-mbstring php8.3-xml php8.3-mysql php8.3-gd php8.3-zip php8.3-bcmath \
  certbot python3-certbot-nginx

log "Installing Composer"
if ! command -v composer >/dev/null 2>&1; then
  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi

log "Configuring UFW firewall (22,80,443)"
ufw allow OpenSSH || true
ufw allow 80/tcp || true
ufw allow 443/tcp || true
ufw --force enable || true

log "Setting timezone to Europe/Warsaw"
ln -sf /usr/share/zoneinfo/Europe/Warsaw /etc/localtime

log "PHP-FPM tuning"
sed -i 's/^;?opcache.enable=.*/opcache.enable=1/' /etc/php/8.3/fpm/php.ini
sed -i 's/^;?opcache.enable_cli=.*/opcache.enable_cli=1/' /etc/php/8.3/fpm/php.ini
sed -i 's/^memory_limit = .*/memory_limit = 512M/' /etc/php/8.3/fpm/php.ini
sed -i 's/^upload_max_filesize = .*/upload_max_filesize = 64M/' /etc/php/8.3/fpm/php.ini
sed -i 's/^post_max_size = .*/post_max_size = 64M/' /etc/php/8.3/fpm/php.ini

systemctl restart php8.3-fpm

log "Creating web root /var/www/${DOMAIN}"
mkdir -p /var/www/${DOMAIN}
chown -R www-data:www-data /var/www/${DOMAIN}

log "Configuring Nginx server block"
cat >/etc/nginx/sites-available/${DOMAIN} <<'NGINXCONF'
server {
    listen 80;
    listen [::]:80;
    server_name skyreel.art www.skyreel.art;

    root /var/www/skyreel.art/public;
    index index.php index.html;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;

    # FastCGI cache (optional)
    fastcgi_cache_path /var/cache/nginx/fastcgi levels=1:2 keys_zone=FASTCGI_CACHE:100m inactive=60m;
    fastcgi_cache_key "$scheme$request_method$host$request_uri";

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.(png|jpg|jpeg|gif|svg|ico|css|js|txt|xml|woff|woff2)$ {
        expires max;
        access_log off;
    }

    location ~ \.(php)$ {
        include fastcgi_params;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        fastcgi_index index.php;
        # Cache toggles
        set $no_cache 0;
        if ($request_method = POST) { set $no_cache 1; }
        if ($query_string != "") { set $no_cache 1; }
        fastcgi_cache_bypass $no_cache;
        fastcgi_no_cache $no_cache;
        fastcgi_cache FASTCGI_CACHE;
        fastcgi_cache_valid 200 301 302 10m;
    }

    location ~ /\. { deny all; }
    location ^~ /storage/ { internal; }

    # ACME challenge
    location ^~ /.well-known/acme-challenge/ { allow all; }
}
NGINXCONF

ln -sf /etc/nginx/sites-available/${DOMAIN} /etc/nginx/sites-enabled/${DOMAIN}
rm -f /etc/nginx/sites-enabled/default
nginx -t
systemctl reload nginx

log "Issuing Let's Encrypt certificate via Certbot (ensure DNS is DNS-only temporarily)"
certbot --nginx -d ${DOMAIN} -d www.${DOMAIN} --non-interactive --agree-tos -m ${LE_EMAIL} || true

log "Nginx reloading after TLS (if certificate succeeded)"
nginx -t && systemctl reload nginx || true

log "Done."