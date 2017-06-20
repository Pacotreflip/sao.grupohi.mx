/**
 * Created by JFEsquivel on 08/06/2017.
 */

window.$ = window.jQuery = require('jquery');
require('bootstrap');
require('admin-lte');
require('admin-lte/plugins/select2/select2');
require('admin-lte/plugins/select2/i18n/es');
require('admin-lte/plugins/datepicker/bootstrap-datepicker');
require('admin-lte/plugins/datepicker/locales/bootstrap-datepicker.es');
window.swal = require('sweetalert2');
require('admin-lte/plugins/iCheck/icheck');

require('./scripts/generales');
/**
 * Development
 */
// Vue Dev
window.Vue = require('vue/dist/vue.js');

// Vue Prod
//window.Vue = require('vue/dist/vue.min');

if ($('#app').length) {
    new Vue({
        el: '#app',
        components: require('./vue-components')
    });
}