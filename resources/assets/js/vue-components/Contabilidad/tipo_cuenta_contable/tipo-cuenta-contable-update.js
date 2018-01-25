/**
 * Created by LERDES2 on 23/06/2017.
 */

Vue.component('tipo-cuenta-contable-update',{
    props: ['tipo_cuenta_contable'],
    data: function() {
        return {
            'form' : {
                'tipo_cuenta_contable': {
                    'id_tipo_cuenta_contable':this.tipo_cuenta_contable.id_tipo_cuenta_contable,
                    'descripcion': this.tipo_cuenta_contable.descripcion,
                    'id_naturaleza_poliza':this.tipo_cuenta_contable.id_naturaleza_poliza
                }
            },
            'guardando' : false
        }
    },

    methods:{
        confirm_save: function() {
            var self = this;
            swal({
                title: "Actualizar Tipo Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if(result.value) {
                    self.save();
                }
            });
        },

        save: function () {

            var self = this;
            var url = App.host + '/sistema_contable/tipo_cuenta_contable/'+self.form.tipo_cuenta_contable.id_tipo_cuenta_contable;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method : 'PATCH',
                    id_naturaleza_poliza : self.form.tipo_cuenta_contable.id_naturaleza_poliza
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        html: "Se ha actualizado el Tipo de Cuenta Contable con éxito",
                        type: "success",
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location = App.host + '/sistema_contable/tipo_cuenta_contable/' + data.data.tipo_cuenta_contable.id_tipo_cuenta_contable;
                    });
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },
    }

});
