import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});



const currentUserId = window.currentUserId;
const chatUserId = window.chatUserId;
// console.log(currentUserId, chatUserId);

window.Echo.channel(`messages.${currentUserId}.${chatUserId}`)
    .listen('MessageSent', (e) => {
        // console.log(e.text);

        const messageElement = document.createElement('li');
        messageElement.classList.add('list-group-item');

        messageElement.innerHTML = `
    <p>
        <strong>${e.text.from.name}:</strong> 
        ${e.text.text}
        <span class="badge rounded-pill text-bg-success">${e.text.created_at}</span>
    </p>`;

        const messagesContainer = document.getElementById('messages');
        messagesContainer.prepend(messageElement);
    });


