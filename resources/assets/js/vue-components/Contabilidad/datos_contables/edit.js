Vue.component('datos-contables-edit', {
    props: [
        'datos_contables',
        'datos_contables_update_url',
        'referencia'
    ],
    data: function() {
        return {
            'data': {
                'datos_contables': this.datos_contables
            },
            'guardando': false
        }
    },
    mounted: function () {
        var self = this;

        // Iniciar evento al dar clic en un radio button
        $('.checkboxes').on('ifClicked', function (e) {
            var elem = $(this),
                value = self.toBoolean(elem.data('value')),
                name = elem.data('name'),
                substring = "si",
                id = elem.attr('id'),
                reference = '';

            switch(name) {
                case 'manejo':
                    reference = 'manejo_almacenes';
                    break;
                case 'gasto':
                    reference = 'costo_en_tipo_gasto';
                    break;
                case 'retencion_antes_iva':
                    reference = 'retencion_antes_iva';
                    break;
                case 'amortizacion_antes_iva':
                    reference = 'amortizacion_antes_iva';
                    break;
                case 'deductiva_antes_iva':
                    reference = 'deductiva_antes_iva';
                    break;
                default:
                    reference = '';
            }

            var contraparte = "#"+ (id.indexOf(substring) !== -1 ? name + "_no" : name + "_si");
            var parent_elem = elem.parent();
            var parent_contraparte = $(contraparte).parent();

            parent_elem.addClass('iradio_square-blue').removeClass('iradio_square-grey');
            parent_contraparte.addClass('iradio_square-grey').removeClass('iradio_square-blue');
            elem.iCheck('check');
            $(contraparte).iCheck('uncheck');
            Vue.set(self.data.datos_contables, reference, value);
        });

        // Cambia el estilo a los elementos previamente seleccionados
        $('.checkboxes').each(function( index ) {
            var elem = $(this);
            var parent = elem.parent();

            if(elem.is(':checked')) {
                parent.addClass('iradio_square-blue').removeClass('iradio_square-grey');
            }
        });

        $("ul.list-unstyled li").css({
            'font-size': '1.3em'
        });
        $("div.box-body > .alert-danger").css({
            'font-size': '1.3em'
        });
        $("div.iradio_square-blue, div.iradio_square-grey").css({
            'padding-left': '20px'
        });
    },
    created: function () {
        // Convierte "0" y "1" en false y true respectivamente
        Vue.set(this.data.datos_contables, 'manejo_almacenes', this.toBoolean(this.data.datos_contables.manejo_almacenes));
        Vue.set(this.data.datos_contables, 'costo_en_tipo_gasto', this.toBoolean(this.data.datos_contables.costo_en_tipo_gasto));
        Vue.set(this.data.datos_contables, 'retencion_antes_iva', this.toBoolean(this.data.datos_contables.retencion_antes_iva));
        Vue.set(this.data.datos_contables, 'amortizacion_antes_iva', this.toBoolean(this.data.datos_contables.amortizacion_antes_iva));
        Vue.set(this.data.datos_contables, 'deductiva_antes_iva', this.toBoolean(this.data.datos_contables.deductiva_antes_iva));
    },
    directives: {
        icheck: {
            inserted: function (el, binding, vnode) {
                var elem = $(el),
                    label = elem.next(),
                    label_text = label.text(),
                    vm = vnode.context;

                label.remove();
                elem.iCheck({
                    checkboxClass: 'icheckbox_square',
                    radioClass: 'iradio_square-blue'
                });
            }
        }
    },
    methods: {
        confirm_datos_obra: function () {
            var self = this;
            swal({
                title: "Guardar Datos Contables de la Obra",
                html: "<div class=\"alert alert-danger\">\n" +
                "  <strong>Atención</strong> Una vez guardados los datos no va a ser posible editarlos" +
                "</div>" +
                "<div class=\"alert alert-warning\">\n" +
                "¿Estás seguro de que la información es correcta? " +
                "</div>",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if(result.value) {
                    self.save_datos_obra();
                }
            }).catch(swal.noop);
        },

        save_datos_obra: function () {
            var self = this;
            $.ajax({
                type: 'POST',
                url: self.datos_contables_update_url,
                data: {
                    BDContPaq : self.data.datos_contables.BDContPaq,
                    FormatoCuenta : self.data.datos_contables.FormatoCuenta,
                    NumobraContPaq : self.data.datos_contables.NumobraContPaq,
                    costo_en_tipo_gasto : self.data.datos_contables.costo_en_tipo_gasto,
                    retencion_antes_iva: self.data.datos_contables.retencion_antes_iva,
                    deductiva_antes_iva: self.data.datos_contables.deductiva_antes_iva,
                    amortizacion_antes_iva: self.data.datos_contables.amortizacion_antes_iva,
                    manejo_almacenes : self.data.datos_contables.manejo_almacenes,
                    _method : 'PATCH'
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.data.datos_contables = data.data.datos_contables;
                    Vue.set(self.data.datos_contables, 'costo_en_tipo_gasto', data.data.datos_contables.costo_en_tipo_gasto == 'true' ? true : false);
                    Vue.set(self.data.datos_contables, 'manejo_almacenes', data.data.datos_contables.manejo_almacenes == 'true' ? true : false);
                    Vue.set(self.data.datos_contables, 'retencion_antes_iva', data.data.datos_contables.retencion_antes_iva == 'true' ? true : false);
                    Vue.set(self.data.datos_contables, 'amortizacion_antes_iva', data.data.datos_contables.amortizacion_antes_iva == 'true' ? true : false);
                    Vue.set(self.data.datos_contables, 'deductiva_antes_iva', data.data.datos_contables.deductiva_antes_iva == 'true' ? true : false);

                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Datos Contables de la Obra actualizados correctamente'
                    });

                    self.referencia = "1";

                    $('.checkboxes').each(function( index ) {
                        var elem = $(this);
                        elem.iCheck('disable');
                    });
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'save_datos_obra') {
                this.confirm_datos_obra();
            }
        }).catch(() => {
                swal({
                         type: 'warning',
                         title: 'Advertencia',
                         text: 'Por favor corrija los errores del formulario'
                     });
        });
        },
        toBoolean: function(sVar)
        {
            return Boolean(Number(sVar));
        },
        checkBox: function (toCheck, bVar) {
            toCheck = toCheck == null ? false : toCheck;

            return toCheck === bVar;
        },
        editando: function () {
            return this.toBoolean(this.referencia);
        },
        mostrar_mensaje: function () {
            return this.editando() ? 'Los datos no pueden ser modificados porque ya han sido guardados previamente' : 'Una vez guardados los datos no va a ser posible editarlos';
        }
    }
});