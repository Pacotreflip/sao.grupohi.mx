/**
 * Created by LERDES2 on 23/06/2017.
 */

Vue.component('tipo-cuenta-contable-create',{
    data: function() {
        return {
            'form' : {
                'tipo_cuenta_contable': {
                    'descripcion': ''
                }
            },
            'guardando' : false
        }
    },

    methods:{
        confirm_save: function() {
            var self = this;
            swal({
                title: "Guardar Plantilla",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.save();
            }).catch(swal.noop);
        },

        save: function () {

            alert("hola");
            var self = this;
            var url = App.host + '/modulo_contable/tipo_cuenta_contable';
            var data = self.form.tipo_cuenta_contable;

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        html: "Se ha creado la plantilla para el Tipo de Cuenta Contable",
                        type: "success",
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location = xhr.getResponseHeader('Location');
                    })  .catch(swal.noop);
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },
    }

});
