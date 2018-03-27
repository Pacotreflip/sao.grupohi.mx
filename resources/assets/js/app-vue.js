// Vue Dev
window.Vue = require('vue/dist/vue.js');
//Vue Prod
//window.Vue = require('vue/dist/vue.min');

window.VeeValidate = require('vee-validate');
VeeValidate.Validator.addLocale({
    'es' : require('vee-validate/dist/locale/es')
});
Vue.use(VeeValidate, { locale: 'es', errorBagName: 'validation_errors'});
window.Dropzone = require('vue2-dropzone');
Vue.use(Dropzone);

if ($('#app').length) {
    new Vue({
        el: '#app',
        components: require('./vue-components')
    });
}