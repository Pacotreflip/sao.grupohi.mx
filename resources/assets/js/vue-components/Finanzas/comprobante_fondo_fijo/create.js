Vue.component('comprobante-fondo-fijo-create', {
    data: function () {
        return {
            'form': {
                'comprobante': {
                    'id_referente': '',
                    'referencia': '',
                    'cumplimiento': '',
                    'fecha':'',
                    'id_naturaleza': '',
                    'id_concepto':''
                }
            }
        }
    },
    mounted: function () {
        var self = this;
        $("#cumplimiento").datepicker().on("changeDate", function () {
            Vue.set(self.form.comprobante, 'cumplimiento', $('#cumplimiento').val())
        });

        $("#fecha").datepicker().on("changeDate", function () {
            Vue.set(self.form.comprobante, 'fecha', $('#fecha').val())
        });
    },

    directives: {

        datepicker: {
            inserted: function (el) {
                $(el).datepicker({
                    autoclose: true,
                    language: 'es',
                    todayHighlight: true,
                    clearBtn: true,
                    format: 'yyyy-mm-dd'
                });
            }
        },
        select2: {
            inserted: function (el) {
                $(el).select2({
                    width: '100%',
                    ajax: {
                        url: App.host + '/sistema_contable/concepto/getBy',
                        dataType: 'json',
                        delay: 500,
                        data: function (params) {
                            return {
                                attribute: 'descripcion',
                                operator: 'like',
                                value: '%' + params.term + '%'
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data.data.conceptos, function (item) {
                                    return {
                                        text: item.path,
                                        id: item.id_concepto
                                    }
                                })
                            };
                        },
                        error: function (error) {

                        },
                        cache: true
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    }, // let our custom formatter work
                    minimumInputLength: 1
                }).on('select2:select', function () {
                    $('#id_concepto').val($('#concepto_select option:selected').data().data.id);
                });
            }
        }
    },
    methods: {}
});
