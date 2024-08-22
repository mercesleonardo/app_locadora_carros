import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });

/** Interceptar os requests da aplicação */

axios.interceptors.request.use(
    (config) => {
        // Adicionando o token de autenticação ao cabeçalho da requisição
        let token = document.cookie.split(';').find(indice => indice.trim().startsWith('token='));

        if (!token) {
            console.error('Token não encontrado');
            return Promise.reject(new Error('Token não encontrado'));
        }

        config.headers.Authorization = 'Bearer ' + token.split('=')[1].trim();

        // Adicionando o tipo de conteúdo ao cabeçalho da requisição
        config.headers.Accept = 'application/json'

        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);


/** Interceptar os responses da aplicação */

axios.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        if (error.response.status === 401 && error.response.data.message === 'Token has expired') {
            axios.post('http://localhost:80/api/refresh')
                .then(response => {
                    document.cookie = 'token='+response.data.token+';SameSite=Lax'
                    window.location.reload()
                })
                .catch(refreshError => {
                    console.error('Erro ao atualizar o token:', refreshError);
                });
        }
        return Promise.reject(error);
    }
);
