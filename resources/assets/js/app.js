/**
 * Created by JFEsquivel on 08/06/2017.
 */

window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');
require('admin-lte');
require('select2');
require('datatables');
require('datatables.net-bs');
require('sweetalert2');

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