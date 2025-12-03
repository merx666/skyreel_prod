# Zasady Projektu SkyReel

## Serwer Produkcyjny

### Nowy serwer produkcyjny (od 2025-10-24)
- Alias Host: `skyreel-new`
- IP: `46.247.109.247`
- Użytkownik: `root`
- Logowanie: zawsze kluczem SSH (lokalny klucz: `~/.ssh/skyreel-new`)
- Ścieżka projektu: `/var/www/skyreel.art/`

Przykłady komend:
```bash
# Logowanie
ssh skyreel-new

# Wykonanie komendy na serwerze
ssh skyreel-new "cd /var/www/skyreel.art && php artisan cache:clear"

# Synchronizacja kodu aplikacji
rsync -avz --delete --exclude "storage/app/private" --exclude "storage/logs" \
  /Users/merx/skyreelv2/ skyreel-new:/var/www/skyreel.art/
```

Instalacja klucza publicznego (pierwsze logowanie):
- Dodaj poniższy klucz publiczny do `/root/.ssh/authorized_keys` na serwerze (panel dostawcy/konsole web lub jednorazowo przez hasło):
```
ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIP5znbObZsAKZtSUFU27UM3ttLl/NZnjq5/5GcAMxS/1 skyreel-new-2025-10-24
```
- Następnie przetestuj: `ssh skyreel-new`.
- Po potwierdzeniu działania klucza wyłącz logowanie hasłem w `/etc/ssh/sshd_config` (`PasswordAuthentication no`) i zrestartuj SSH.

Standardowe komendy po wdrożeniu:
```bash
ssh skyreel-new "cd /var/www/skyreel.art && php artisan cache:clear && php artisan config:clear && rm -rf storage/framework/views/*"
ssh skyreel-new "rm -rf /var/cache/nginx/fastcgi/* && systemctl reload nginx"
```

TLS i DNS (Cloudflare):
- Certbot: na czas wydania certyfikatu ustaw rekord A `skyreel.art` na "DNS only" (szara chmura), wydaj certyfikat, po wszystkim przełącz z powrotem na "Proxied".
- Po zmianach DNS zrób "Purge Everything".


### Logowanie do serwera
**ZAWSZE** używaj komendy `ssh skyreel-new` do logowania się na serwer produkcyjny (logowanie wyłącznie kluczem SSH).

**NIE UŻYWAJ** bezpośrednich adresów IP ani innych metod logowania.

### Ścieżka projektu na serwerze
Projekt znajduje się w: `/var/www/skyreel.art/`

### Przykłady komend
```bash
# Logowanie na serwer
ssh skyreel-production

# Wykonywanie komend na serwerze z lokalnej maszyny
ssh skyreel-production "cd /var/www/skyreel.art && php artisan cache:clear"

# Synchronizacja plików na serwer
rsync -avz plik.php skyreel-production:/var/www/skyreel.art/ścieżka/
```

## Architektura Projektu

### Backend
- Laravel 11 (PHP 8.3)
- MySQL 8.0
- Nginx z PHP-FPM

### Frontend
- Vue.js 3 (Composition API) z Vite
- Tailwind CSS
- Alpine.js

### Motyw "Liquid Glass"
- Motyw ciemny (domyślny): tło #131314, akcent #8ab4f8
- Motyw jasny: tło #f8f9fa, akcent #1a73e8
- Klasa CSS `.liquid-glass` z backdrop-filter: blur(24px)

## Bezpieczeństwo i Wydajność

### Najlepsze praktyki
- Ochrona przed XSS, CSRF, SQL Injection
- Optymalizacja wydajności (lazy loading, buforowanie)
- Kod zgodny z PSR-12
- SEO-friendly URLs i meta tagi

### Wdrażanie
- Zawsze czyść cache po wdrożeniu: `php artisan cache:clear`
- Usuń skompilowane widoki: `rm -rf storage/framework/views/*`
- **KLUCZOWE**: Wyczyść cache Nginx FastCGI: `rm -rf /var/cache/nginx/fastcgi/* && systemctl reload nginx`
- Testuj stronę po każdym wdrożeniu

## Rozwiązywanie Problemów

### Problem: Google Analytics nie renderuje się poprawnie (używa placeholder zamiast rzeczywistego ID)

#### Objawy:
- Google Analytics używa `GA_MEASUREMENT_ID` zamiast rzeczywistego ID (np. `G-9FMYJYCRTP`)
- Konfiguracja w `.env` i plikach Blade jest poprawna
- Lokalne pliki zawierają poprawne kod z `config('services.google_analytics.id')`

#### Przyczyna:
**Cache Nginx FastCGI** - serwer cachuje starą wersję strony z placeholderem

#### Rozwiązanie (krok po kroku):

1. **Sprawdź konfigurację lokalną**:
   ```bash
   # Upewnij się, że lokalne pliki są poprawne
   grep -n "config('services.google_analytics.id')" resources/views/components/cookie-consent.blade.php
   ```

2. **Synchronizuj pliki na serwer**:
   ```bash
   rsync -avz resources/views/components/cookie-consent.blade.php skyreel-production:/var/www/skyreel.art/resources/views/components/
   ```

3. **Wyczyść cache Laravel**:
   ```bash
   ssh skyreel-production "cd /var/www/skyreel.art && php artisan cache:clear && php artisan config:clear && rm -rf storage/framework/views/*"
   ```

4. **KLUCZOWE: Wyczyść cache Nginx FastCGI**:
   ```bash
   ssh skyreel-production "rm -rf /var/cache/nginx/fastcgi/* && systemctl reload nginx"
   ```

5. **Weryfikuj rozwiązanie**:
   ```bash
   ssh skyreel-production "curl -s https://skyreel.art/ | grep -o 'G-[A-Z0-9]*'"
   ```

#### Ważne uwagi:
- **Zawsze czyść cache Nginx** po wdrożeniu zmian w plikach Blade
- Nginx FastCGI cache może cachować strony na 60 minut
- Problem może wystąpić przy każdej zmianie w plikach zawierających dynamiczne dane z konfiguracji Laravel

#### Komendy diagnostyczne:
```bash
# Sprawdź czy Nginx ma włączony cache
ssh skyreel-production "nginx -T 2>/dev/null | grep -i cache"

# Sprawdź czy placeholder jest nadal używany
ssh skyreel-production "curl -s https://skyreel.art/ | grep 'GA_MEASUREMENT_ID'"

# Sprawdź czy Google Analytics jest poprawnie renderowany
ssh skyreel-production "curl -s https://skyreel.art/ | grep -o 'G-[A-Z0-9]*'"
```

#### Zapobieganie:
- Po każdym wdrożeniu zmian w plikach Blade, automatycznie czyść cache Nginx
- Rozważ dodanie skryptu wdrożeniowego, który automatycznie czyści wszystkie cache

### Problem: Błąd 500 podczas logowania (RuntimeException: No application encryption key has been specified)

#### Objawy:
- Błąd 500 podczas próby logowania
- W logach Laravel: `RuntimeException: No application encryption key has been specified`
- Strona logowania ładuje się poprawnie, ale POST do `/login` zwraca błąd 500

#### Przyczyna:
**Nieprawidłowy lub brakujący APP_KEY** w pliku `.env` na serwerze produkcyjnym

#### Rozwiązanie (krok po kroku):

1. **Sprawdź aktualny APP_KEY**:
   ```bash
   ssh skyreel-production "cd /var/www/skyreel.art && grep APP_KEY .env"
   ```

2. **Wygeneruj nowy klucz aplikacji**:
   ```bash
   ssh skyreel-production "cd /var/www/skyreel.art && php artisan key:generate"
   ```

3. **Wyczyść cache konfiguracji**:
   ```bash
   ssh skyreel-production "cd /var/www/skyreel.art && php artisan config:clear && php artisan cache:clear"
   ```

4. **Testuj logowanie**:
   ```bash
   ssh skyreel-production "cd /var/www/skyreel.art && curl -s -o /dev/null -w '%{http_code}' https://skyreel.art/login"
   ```

#### Ważne uwagi:
- **Generowanie nowego APP_KEY wyloguje wszystkich użytkowników** (sesje staną się nieważne)
- Po zmianie APP_KEY należy wyczyścić wszystkie cache
- Problem może wystąpić po nieprawidłowym kopiowaniu pliku `.env`

#### Komendy diagnostyczne:
```bash
# Sprawdź czy APP_KEY jest ustawiony
ssh skyreel-production "cd /var/www/skyreel.art && php artisan tinker --execute='echo config(\"app.key\") ? \"APP_KEY OK\" : \"APP_KEY MISSING\";'"

# Sprawdź logi Laravel
ssh skyreel-production "cd /var/www/skyreel.art && tail -n 20 storage/logs/laravel.log"
```

### Standardowe komendy po wdrożeniu:
```bash
# Wyczyść wszystkie cache Laravel
ssh skyreel-production "cd /var/www/skyreel.art && php artisan cache:clear && php artisan config:clear && rm -rf storage/framework/views/*"

# Wyczyść cache Nginx
ssh skyreel-production "rm -rf /var/cache/nginx/fastcgi/* && systemctl reload nginx"
```

## Reverb / WebSockets

### Konfiguracja produkcyjna
- Serwer Reverb uruchamiamy jako `www-data` na `127.0.0.1:7001`.
- Nginx proxy dla ścieżki `/app` wskazuje na `http://127.0.0.1:7001` z poprawnymi nagłówkami Upgrade.
- Frontend/Echo używa ścieżki `wsPath='/app'` oraz domeny `skyreel.art`.

#### Fragment Nginx (lokacja `/app`)
```nginx
location /app {
    proxy_http_version 1.1;
    proxy_set_header Upgrade $http_upgrade;
    proxy_set_header Connection "Upgrade";
    proxy_set_header Host $host;
    proxy_set_header X-Forwarded-Proto $scheme;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Host $host;
    proxy_set_header X-Forwarded-Port $server_port;

    proxy_read_timeout 3600s;
    proxy_send_timeout 3600s;

    proxy_pass http://127.0.0.1:7001;
}
```

#### Zmienne `.env` (produkcyjnie)
```env
REVERB_APP_KEY=reverb-key
REVERB_HOST=skyreel.art
REVERB_PORT=443
REVERB_SCHEME=https
REVERB_SERVER_PATH=
REVERB_WS_PATH=/app
```

#### Zmienne Vite (frontend)
```env
VITE_REVERB_APP_KEY=${REVERB_APP_KEY}
VITE_REVERB_HOST=${REVERB_HOST}
VITE_REVERB_PORT=${REVERB_PORT}
VITE_REVERB_SCHEME=${REVERB_SCHEME}
VITE_REVERB_WS_PATH=${REVERB_WS_PATH}
```

#### Echo (resources/js/echo.js)
Używamy:
```js
window.Echo = new Echo({
  broadcaster: 'reverb',
  key: import.meta.env.VITE_REVERB_APP_KEY,
  wsHost: import.meta.env.VITE_REVERB_HOST,
  wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
  wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
  wsPath: import.meta.env.VITE_REVERB_WS_PATH ?? '/app',
  forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
  enabledTransports: ['ws', 'wss'],
});
```

### Uruchamianie Reverb
Prosty skrypt startowy (na serwerze):
```bash
/var/www/skyreel.art/scripts/start-reverb.sh
```
Zawartość przykładowa:
```bash
#!/usr/bin/env bash
set -euo pipefail
cd /var/www/skyreel.art
mkdir -p storage/logs
php artisan reverb:start \
  --host=127.0.0.1 \
  --port=7001 \
  --scheme=http \
  --no-interaction \
  --debug \
  --force \
  >> storage/logs/reverb-7001.log 2>&1 &
echo $! > storage/logs/reverb-7001.pid
```
Autostart (jedna z opcji):
- Cron `@reboot` użytkownika: `crontab -e` i wpis: `@reboot /var/www/skyreel.art/scripts/start-reverb.sh`
- Lub jednostka `systemd` uruchamiająca Reverb jako `www-data` (zalecane w przyszłości).

### Diagnostyka i testy
- Sprawdzenie nasłuchu portu:
```bash
ssh skyreel-production "lsof -iTCP -sTCP:LISTEN -n -P | awk '/127.0.0.1:7001/ {print $1,$2,$3,$9}'"
```
- Test ręcznego WebSocket przez domenę:
```bash
wscat -c wss://skyreel.art/app/reverb-key
```
- Test subprotocol `pusher` (jeśli narzędzie wspiera):
```bash
wscat -c wss://skyreel.art/app/reverb-key -H "Sec-WebSocket-Protocol: pusher"
```
- Sprawdzenie logów Nginx po upgrade (HTTP 101):
```bash
ssh skyreel-production "grep 'GET /app/reverb-key' -n /var/log/nginx/access.log | tail -n 10"
```

### Playbook rozwiązywania problemów

#### 400 Bad Request / błędny handshake
- Upewnij się, że `wsPath='/app'` po obu stronach (Echo i Nginx).
- Sprawdź, czy Reverb działa na `127.0.0.1:7001` i czy Nginx proxy wskazuje na właściwy port.
- Zweryfikuj `.env` oraz zmienne Vite po buildzie.

#### 502 Bad Gateway
- Reverb nie działa lub firewall blokuje połączenie lokalne.
- Sprawdź proces: `lsof -iTCP -sTCP:LISTEN -n -P | grep 7001`.
- Sprawdź błędy Nginx: `tail -n 100 /var/log/nginx/error.log`.

#### Konflikt portu 6001
- Jeśli port 6001 zajęty przez inny proces (np. `php` uruchomione jako root), uruchom Reverb na 7001 jako `www-data`.
- Zaktualizuj proxy Nginx dla `/app` do `127.0.0.1:7001`.

#### Brak subprotocol / `Sec-WebSocket-Protocol`
- Reverb akceptuje połączenia bez subprotocol; dla narzędzi wymagających, dodaj `Sec-WebSocket-Protocol: pusher`.

#### Cache FastCGI wpływa na widoki/JS
- Po każdym wdrożeniu czyść cache Laravel i FastCGI (sekcja wyżej).

### Dobre praktyki operacyjne
- Nie uruchamiać Reverb jako `root`.
- Utrzymywać spójność konfiguracji `.env` i `VITE_*` między backendem i frontendem.
- Automatyzować restart po deployu (cron lub systemd) i monitorować logi `storage/logs/reverb-7001.log`.

### Szybkie checklisty
- [ ] Reverb: `127.0.0.1:7001` działa, proces jako `www-data`.
- [ ] Nginx: `/app` proxied, nagłówki Upgrade/Connection ustawione, 101 w access.log.
- [ ] Echo: `wsPath='/app'`, domena, `enabledTransports=['ws','wss']`, TLS wg schematu.
- [ ] Cache: wyczyszczone Laravel i FastCGI po deployu.