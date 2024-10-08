/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

/** Importando o Vuex store */
import store from './store'; // Certifique-se de que o caminho para o store está correto

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import LoginComponent from './components/LoginComponent.vue';
import HomeComponent from './components/HomeComponent.vue';
import MarcasComponent from './components/MarcasComponent.vue';
import InputContainerComponent from "./components/InputContainerComponent.vue";
import TableComponent from "./components/TableComponent.vue";
import CardComponent from "./components/CardComponent.vue";
import ModalComponent from "./components/ModalComponent.vue";
import AlertComponent from "./components/AlertComponent.vue"
import PaginateComponent from "./components/PaginateComponent.vue";

app.component('example-component', ExampleComponent);
app.component('home-component', HomeComponent);
app.component('marcas-component', MarcasComponent);
app.component('login-component', LoginComponent);
app.component('input-container-component', InputContainerComponent);
app.component('table-component', TableComponent);
app.component('card-component', CardComponent);
app.component('modal-component', ModalComponent);
app.component('alert-component', AlertComponent);
app.component('paginate-component', PaginateComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

/**
 * Registrando o Vuex store na instância do Vue
 */
app.use(store); // Registrando o Vuex store

app.config.globalProperties.$formatDate = function(date) {
    if (!date) return 'Data não disponível';
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(date).toLocaleDateString('pt-BR', options);
};

app.mount('#app');
