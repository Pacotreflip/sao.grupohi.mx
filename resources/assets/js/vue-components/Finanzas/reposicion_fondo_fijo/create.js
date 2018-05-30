Vue.component('reposicion-fondo-fijo-create', {
    data: function () {
        return {
            form: {
                cumplimiento: '',
                vencimiento: '',
                destino: '',
                fecha: '',
                id_referente: '',
                id_antecedente: '',
                observaciones: ''
            },
            fondos: {},
            cargando : false
        }
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
        }
    },

    mounted: function () {
        var self = this;
        self.getFondos();

        /*$.ajax({
            url: App.host + 'http://172.20.73.87/api/fondo/lists',
            type: 'GET',
            beforeSend: function () {
                self.cargando = true;
            },
            success: function (data, textStatus, jqXHR) {
                self.fondos = data;
                alert('success')
            },
            complete: function (jqXHR, textStatus) {
                self.cargando = false;
            }
        })*/
        /*$('#id_antecedente').select2({
            width: '100%',
            ajax: {
                url: 'http://172.20.73.87/api/finanzas/comprobante_fondo_fijo/search',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term
                    }
                    return query;
                }
            },
            delay: 250,
            placeholder: '[--BUSCAR--]',
            minimumInputLength: 1
        });*/
        
    },

    methods: {
        getFondos: function () {
            var self = this;

            var url = App.host + '/control_presupuesto/variacion_volumen/getBasesAfectadas';
            $.ajax({
                type: 'GET',
                url: url,
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.bases_afectadas = data;
                },
                complete: function () {
                    self.cargando = false;
                }
            });
        }
    }
});