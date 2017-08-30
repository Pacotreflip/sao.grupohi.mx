/**
 * Created by JFEsquivel on 13/06/2017.
 */

$(function ()  {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': App.csrfToken
        },
        error: function (jqXHR) {
            swal({
                type: 'error',
                title: '¡Error!',
                text: jqXHR.responseText
            });
        }
    });
});

$(function () {
    $('.index_table').DataTable({
        'language': {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        'ordering': true,
        'info': true
    });
    $('.rango_fechas').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD',
            applyLabel: 'Aplicar',
            cancelLabel: 'Cancelar',
        }
    }).val('');

    Inputmask({ regex: App.regex_cuenta }).mask($('.formato_cuenta'));

    $('.fecha').datepicker({
        autoclose: true,
        language: 'es',
        todayHighlight: true,
        clearBtn: true,
        cleartxt: 'Limpiar',
        format: 'yyyy-mm-dd'
    });
});

Number.prototype.formatMoney = function(c, d, t) {
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

Date.prototype.dateFormat = function() {
    var date = this;
    var sMonth = padValue(date.getMonth() + 1);
    var sDay = padValue(date.getDate());
    var sYear = date.getFullYear();
    var sHour = date.getHours();
    var sMinute = padValue(date.getMinutes());
    var sSecond = padValue(date.getSeconds());

    var sAMPM = "am";

    var iHourCheck = parseInt(sHour);

    if (iHourCheck > 12) {
        sAMPM = "pm";
        sHour = iHourCheck - 12;
    }

    else if (iHourCheck === 0) {
        sHour = "12";
    }

    sHour = padValue(sHour);
    return sYear + "-" + sMonth + "-" + sDay + " " + sHour + ":" + sMinute + ":" + sSecond + " " + sAMPM;
};

Date.prototype.dateShortFormat = function() {
    var date = this;
    var sMonth = padValue(date.getMonth() + 1);
    var sDay = padValue(date.getDate());
    var sYear = date.getFullYear();

    return sYear + "-" + sMonth + "-" + sDay;
};

function padValue(value) {
    return (value < 10) ? "0" + value : value;
};

