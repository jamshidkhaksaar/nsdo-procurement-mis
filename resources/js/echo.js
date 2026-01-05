import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Only initialize Echo if we are on localhost (dev) 
// or if we have a valid WebSocket environment.
// Shared hosting often blocks port 8080, so we fallback to Polling.
if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: window.location.hostname,
        wsPort: 8080,
        wssPort: 8080,
        forceTLS: false,
        enabledTransports: ['ws', 'wss'],
    });
} else {
    console.log('Production Environment: Real-time via Livewire Polling enabled.');
}