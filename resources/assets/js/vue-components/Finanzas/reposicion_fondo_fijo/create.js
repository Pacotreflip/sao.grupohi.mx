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
                observaciones: '',
                monto: ''

            },
            fondos: {},
            cargando : true
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
        setTimeout(function () {
            self.getFondos();
        }, 500);

        $('#cumplimiento').datepicker().on("changeDate", function() {
            self.form.cumplimiento = $('#cumplimiento').val();
            //Vue.set(self.form, 'cumplimiento',$('#cumplimiento').val());
        });

        $('#fecha').datepicker().on("changeDate", function() {
            self.form.fecha = $('#fecha').val();
            //Vue.set(self.form, 'cumplimiento',$('#cumplimiento').val());
        });

        $('#vencimiento').datepicker().on("changeDate", function() {
            self.form.vencimiento = $('#vencimiento').val()
            // Vue.set(self.form, 'vencimiento', $('#vencimiento').val())
        });

        $('#id_antecedente').select2({
            width: '100%',
            ajax: {
                url: 'http://172.20.73.87/api/finanzas/comprobante_fondo_fijo/search',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        q: params.term,
                        limit: 10
                    }
                    return query;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            var text = '# ' + item.numero_folio + " - " + item.referencia.trim() + ' (' + item.observaciones.trim() + ')';
                            return {
                                text:text,
                                id: item.id_transaccion
                            }
                        })

                    };
                },
                error: function (error) {

                },
                cache: true
            },
            delay: 500,
            escapeMarkup: function (markup) {
                return markup;
            },
            placeholder: '[--BUSCAR--]',
            minimumInputLength: 1
        }).on('select2:select', function (e) {
            var data = e.params.data;
            self.form.id_antecedente = data.id;
            var textSplit = data.text.split('-');
            self.idtransaccion = {id:data.id,name:textSplit[1],numero_folio:textSplit[0]};
        });
        
    },

    methods: {

        getFondos: function() {
            var self = this;
            $.ajax({
                url: App.host + '/api/fondo/lists',
                type: 'GET',
                success: function(data) {
                    self.fondos = data;
                },
                complete: function () {
                    self.cargando = false;
                }
            });
        },
        test: function () {
            alert('test');
        }
    }
});