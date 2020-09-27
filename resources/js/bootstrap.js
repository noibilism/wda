window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Vue from 'vue';
import {Transfer, Message } from 'element-ui';
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import 'element-ui/lib/theme-chalk/index.css';
import App from './components/App'

locale.use(lang)
Vue.use(Transfer);

Vue.prototype.$message = Message;

new Vue({
    el: '#app',
    render: h => h(App)
});


