import axios from 'axios';
window.axios = axios;
window.axios.defaults.withCredentials = true;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token=document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('content');
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const userApiToken = document.head.querySelector('meta[name="user-api-token"]');

if (userApiToken) {
    window.axios.defaults.headers.common.Authorization = `Bearer ${userApiToken.getAttribute('content')}`;
} else {
    console.error('User API token not found in a meta tag.');
}
//Echo