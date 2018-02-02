Vue.component('escalatoria', {
    props : ['id_tipo_orden'],
    data : function () {
        return {
            form : {
                partidas : [],
                motivo : ''
            },
            escalatoria : {
                monto : '',
                descripcion : ''
            },
            cargando : false,
            guardando : false
        }
    },

    computed : {

        datos : function () {
            var res = {
                id_tipo_orden: this.id_tipo_orden,
                motivo: this.form.motivo,
                partidas: []
            };
            this.form.partidas.forEach(function (value) {
                res.partidas.push({
                    monto_presupuestado : value.importe,
                    descripcion : value.descripcion
                });
            });
            return res;
        }

    },

    methods : {
        removePartida: function (index) {
            Vue.delete(this.form.partidas, index);
        },

        addPartida : function () {
            var partida = _.clone(this.escalatoria);
            this.form.partidas.push(partida);
            this.escalatoria = {
                monto : '',
                descripcion : ''
            }
        },
        confirmSave: function () {
            var self = this;
            swal({
                title: 'Guardar Solicitud de Cambio',
                text: "¿Está seguro de que la información es correcta?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Guardar',
                cancelButtonText: 'No, Cancelar'
            }).then(function(result) {
                if(result.value) {
                    self.save();
                }
            });
        },

        save : function () {
            var self = this;
            $.ajax({
                url : App.host + '/control_presupuesto/cambio_presupuesto',
                type : 'POST',
                data : self.datos,
                beforeSend : function () {
                    self.guardando = true;
                },
                success : function (response) {
                    swal({
                        type : 'success',
                        title : '¡Correcto!',
                        html : 'Solicitud Guardada con Número de Folio <b>' + response.numero_folio + '</b>'
                    }).then(function () {
                        window.location.href = App.host + '/control_presupuesto/cambio_presupuesto/' +response.id
                    });
                },
                complete : function () {
                    self.guardando = false;
                }
            })
        },

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'save_solicitud') {

                this.confirmSave();
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