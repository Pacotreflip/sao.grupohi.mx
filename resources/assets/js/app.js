/**
 * Created by JFEsquivel on 08/06/2017.
 */

//Development
window.Vue = require('vue/dist/vue.js');
require('sweetalert');

//Production
//window.Vue = require('vue/dist/vue.min');
require('vue-resource');
Vue.http.headers.common['X-CSRF-TOKEN'] = App.csrfToken;
$(function ()  {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': App.csrfToken
        }
    });
});

if ($('#app').length) {
    new Vue({
        el: '#app',
        components: require('./vue-components')
    });
}