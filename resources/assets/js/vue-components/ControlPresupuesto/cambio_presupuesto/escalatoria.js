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

    mounted: function () {

    },

    methods : {

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
                    self.cargando = true;
                },
                success : function (response) {

                    var lista = [];

                    // Ya existen solicitudes con las partidas seleccionadas
                    if (typeof response.repetidas != 'undefined') {

                        $.each(response.repetidas, function( key, value ) {
                            lista.push('<li class="list-group-item "><a href="'+ App.host + '/control_presupuesto/cambio_presupuesto" onclick="swal.close();">#'+ value.solicitud.numero_folio +' ' + (value.solicitud.motivo.length >= 20 ? (value.solicitud.motivo.substring(0, 30) + '...') : value.solicitud.motivo) + '</a></li>');
                        });

                        var texto = response.repetidas.length > 1 ? 'Ya existen solicitudes' : 'Ya existe una solicitud';

                        swal({
                            title: texto + " con los items seleccionados",
                            html: '<ul class="list-group">' + lista.join(' ') +'</ul>',
                            type: "warning",
                            showCancelButton: true,
                            showConfirmButton: true,
                            cancelButtonText: "Cancelar"
                        });

                        return;
                    }

                    swal({
                        type : 'success',
                        title : '¡Correcto!',
                        html : 'Solicitud Guardada con Número de Folio <b>' + response.numero_folio + '</b>'
                    }).then(function () {
                        window.location.href = App.host + '/control_presupuesto/cambio_presupuesto/' +response.id
                    });
                },
                complete : function () {
                    self.cargando = false;
                }
            })
        },

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'add_partida') {

                this.addPartida();
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