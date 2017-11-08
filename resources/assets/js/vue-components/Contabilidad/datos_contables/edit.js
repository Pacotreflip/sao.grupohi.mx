Vue.component('datos-contables-edit', {
    props: [
        'datos_contables',
        'datos_contables_update_url'
    ],
    data: function() {
        return {
            'data': {
                'datos_contables': this.datos_contables
            },
            'guardando': false
        }
    },

     created: function () {
         Vue.set(this.data.datos_contables, 'manejo_almacenes', Boolean(Number(this.data.datos_contables.manejo_almacenes)));
         Vue.set(this.data.datos_contables, 'costo_en_tipo_gasto', Boolean(Number(this.data.datos_contables.costo_en_tipo_gasto)));

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
        }
    }
});