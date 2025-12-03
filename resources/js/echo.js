import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

// Sprawdzamy czy zmienne środowiskowe są dostępne przed utworzeniem Echo
if (import.meta.env.VITE_REVERB_APP_KEY) {
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
} else {
    console.warn('Echo configuration is missing. Real-time features will be disabled.');
    window.Echo = {
        channel: () => ({ listen: () => {} }),
        private: () => ({ listen: () => {} }),
        join: () => ({ here: () => {}, joining: () => {}, leaving: () => {}, listen: () => {} })
    };
}
