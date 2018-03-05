/**
 * Created by JFEsquivel on 08/06/2017.
 */
window.$ = window.jQuery = require('jquery');
require('typeahead.js/dist/typeahead.jquery');
window.Bloodhound = require('typeahead.js/dist/bloodhound');
require('bootstrap');
require('admin-lte');
require('admin-lte/plugins/select2/select2');
require('admin-lte/plugins/select2/i18n/es');
require('admin-lte/plugins/datepicker/bootstrap-datepicker');
require('admin-lte/plugins/datepicker/locales/bootstrap-datepicker.es');
window.moment = require('moment');
require('moment/locale/es');
moment.locale('es');
require('admin-lte/plugins/daterangepicker/daterangepicker');
window.swal = require('sweetalert2');
require('admin-lte/plugins/iCheck/icheck');
require('jquery-treegrid/js/jquery.treegrid.js');
require('jquery-treegrid/js/jquery.treegrid.bootstrap3.js');
require('jquery-treegrid/js/jquery.cookie.js');
window.Inputmask = require('inputmask');
require('./scripts/generales');
window.io = require('socket.io-client');
require('bootstrap-notify');
window.Chart = require('chart.js');
require('jquery-slimscroll');
require('jstree/dist/jstree.js');
window._ = require('underscore');