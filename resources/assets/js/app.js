/**
 * Created by JFEsquivel on 08/06/2017.
 */
require('./scripts/generales');
/**
 * Development
 */
window.Vue = require('vue/dist/vue.js');

/**
 * Production
 */
//window.Vue = require('vue/dist/vue.min');

if ($('#app').length) {
    new Vue({
        el: '#app',
        components: require('./vue-components')
    });
}