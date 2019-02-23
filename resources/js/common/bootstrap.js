window.Vue = require('vue');

window.Bus = new Vue();


window.$ = window.jQuery = require('jquery');
// require('bootstrap-sass');

window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': Laravel.csrfToken
};

Laravel.router = require('./backend-router-generator')(require('../route'));
