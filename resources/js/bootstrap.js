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
        config.headers.Accept = 'application/json';

        let token = document.cookie.split(';').find(indice => {
            return indice.includes('token=');
        });

        if (token) {
            token = token.split('=')[1];
            config.headers.Authorization = 'Bearer ' + token;
        }

        return config;
    },
    (error) => {
        console.log('Erro na requisição: ', error);
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
            return axios.post('http://laravel.test/api/refresh')
                .then(response => {
                    console.log('Refresh com sucesso: ', response);

                    document.cookie = 'token=' + response.data.token + ';SameSite=Lax';

                    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;

                    error.config.headers['Authorization'] = `Bearer ${response.data.token}`;
                    return axios(error.config);

                })
                .catch(refreshError => {
                    console.error('Erro ao atualizar o token:', refreshError);
                    return Promise.reject(refreshError);
                });
        }
        return Promise.reject(error);
    }
);
