#!/usr/bin/env bash
set -euo pipefail

# SkyReel Reverb start script
# Uruchamia Laravel Reverb jako proces w tle i zapisuje logi do storage/logs/reverb.log

APP_DIR="$(cd "$(dirname "$0")"/.. && pwd)"
cd "$APP_DIR"

# Ustalona ścieżka do php; w razie innej lokalizacji zmień poniżej
PHP_BIN="/usr/bin/php"

# Parametry Reverb (można nadpisać przez zmienne środowiskowe)
REVERB_HOST="${REVERB_HOST:-127.0.0.1}"
REVERB_PORT="${REVERB_PORT:-8080}"

LOG_DIR="$APP_DIR/storage/logs"
mkdir -p "$LOG_DIR"

echo "[start-reverb] Starting Reverb on ${REVERB_HOST}:${REVERB_PORT} in $APP_DIR" | tee -a "$LOG_DIR/reverb-supervisor.log"

# Uruchom Reverb w tle z przekierowaniem logów
nohup "$PHP_BIN" artisan reverb:start --host="$REVERB_HOST" --port="$REVERB_PORT" \
  > "$LOG_DIR/reverb.log" 2>&1 &

REVERB_PID=$!
echo "$REVERB_PID" > "$LOG_DIR/reverb.pid"
echo "[start-reverb] Reverb started with PID $REVERB_PID" | tee -a "$LOG_DIR/reverb-supervisor.log"

exit 0