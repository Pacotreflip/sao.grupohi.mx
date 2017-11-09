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
                substring = "si";

            var id = elem.attr('id');
            var reference = (name === 'manejo' ? 'manejo_almacenes' : 'costo_en_tipo_gasto');
            var contraparte = "#"+ (id.indexOf(substring) !== -1 ? name + "_no" : name + "_si");
            var parent_elem = elem.parent();
            var parent_contraparte = $(contraparte).parent();

            parent_elem.addClass('iradio_line-green').removeClass('iradio_line-grey');
            parent_contraparte.addClass('iradio_line-grey').removeClass('iradio_line-green');
            elem.iCheck('check');
            $(contraparte).iCheck('uncheck');
            Vue.set(self.data.datos_contables, reference, value);
        });

        // Cambia el estilo a los elementos previamente seleccionados
        $('.checkboxes').each(function( index ) {
            var elem = $(this);
            var parent = elem.parent();

            if(elem.is(':checked')) {
                parent.addClass('iradio_line-green').removeClass('iradio_line-grey');console.log(parent);
            }
        });


        $("label.control-label").css({
            'font-size': '1.5em'
        });
        $("div.box-body > .alert-danger").css({
            'font-size': '1.3em'
        });
        $("div.iradio_line-grey").css({
            'margin': '4px'
        });
    },
     created: function () {
         // Convierte "0" y "1" en false y true respectivamente
         Vue.set(this.data.datos_contables, 'manejo_almacenes', this.toBoolean(this.data.datos_contables.manejo_almacenes));
         Vue.set(this.data.datos_contables, 'costo_en_tipo_gasto', this.toBoolean(this.data.datos_contables.costo_en_tipo_gasto));
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
                    checkboxClass: 'icheckbox_line-grey',
                    radioClass: 'iradio_line-grey',
                    insert: '<div class="icheck_line-icon"></div>' + label_text
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
            }).then(function () {
                self.save_datos_obra();
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
                    manejo_almacenes : self.data.datos_contables.manejo_almacenes,
                    _method : 'PATCH'
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.data.datos_contables = data.data.datos_contables;
                    var  costo_en_tipo_gasto = Vue.set(self.data.datos_contables, 'costo_en_tipo_gasto', data.data.datos_contables.costo_en_tipo_gasto == 'true' ? true : false);
                    var  manejo_almacenes = Vue.set(self.data.datos_contables, 'manejo_almacenes', data.data.datos_contables.manejo_almacenes == 'true' ? true : false);
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Datos Contables de la Obra actualizados correctamente'
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