import Vue from 'vue'
import App from './App.vue'

Vue.config.productionTip = false

import Axios from 'axios';
window.axios = Axios.create({baseURL: 'http://localhost:8000/api'});

new Vue({
  render: function (h) { return h(App) },
}).$mount('#app')

