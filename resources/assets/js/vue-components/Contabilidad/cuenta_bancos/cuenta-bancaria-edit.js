Vue.component('cuenta-bancaria-edit', {
    props: ['cuenta', 'tipos','cuenta_store_url','cuentas_asociadas', 'datos_contables'],

    data: function () {
        return {
            'asociadas': this.cuentas_asociadas,
            'form': {
                'id_tipo_cuenta_contable':'',
                'cuenta': ''
            },
            'cuenta_descripcion': '',
            'cuenta_edit_id': 0,
            'guardando': false,
            'nuevo_registro': false
        }
    },
    methods: {
        close_modal: function (modal) {
            $('#' + modal).modal('hide');
            this.form.id_tipo_cuenta_contable = '';
            this.form.cuenta = '';
        },
        confirm_elimina_cuenta: function (cuenta) {
            var self = this;
            this.cuenta_edit_id = cuenta.id_cuenta_contable_bancaria;
            this.form.id_tipo_cuenta_contable = cuenta.id_tipo_cuenta_contable;
            this.form.cuenta = cuenta.cuenta;

            swal({
                title: "Eliminar Cuenta Contable",
                html: "¿Estás seguro que desea eliminar la cuenta "+ cuenta.cuenta +"?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {

                self.elimina_cuenta();
            }).catch(swal.noop);

        },
        confirm_cuenta_update: function () {
            var self = this;
            swal({
                title: "Actualizar Cuenta Contable",
                text: "¿Estás seguro que desea actualizar la Cuenta Contable?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {

                self.update_cuenta_bancaria();
            }).catch(swal.noop);

        },
        confirm_cuenta_create: function () {
            var self = this;
            swal({
                title: "Registrar Cuenta Contable",
                text: "¿Estás seguro que desea registrar la Cuenta Contable?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
              self.save_cuenta_bancaria();
            }).catch(swal.noop);

        },
        elimina_cuenta: function () {
            var self = this;
            var data = self.form;
            var url = App.host + '/sistema_contable/cuentas_contables_bancarias/' + this.cuenta_edit_id;
            var toRemove = this.cuenta_edit_id;
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    data: data,
                    _method: 'DELETE'
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    $.each(self.asociadas, function (index, tipo_cuenta) {
                        if (toRemove == tipo_cuenta.id_cuenta_contable_bancaria) {
                            self.asociadas.splice(index, 1);
                        }
                    });

                    $('#add_movimiento_modal').modal('hide');
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta: fué eliminada correctamente',
                    });

                },
                complete: function () {
                    self.guardando = false;
                    this.cuenta_descripcion = '';
                    this.cuenta_edit_id = 0;
                    this.form.id_tipo_cuenta_contable = '';
                    this.form.cuenta = '';
                }
            });
        },
        create_cuenta_bancaria: function () {
            this.form.id_tipo_cuenta_contable = '';
            this.form.cuenta = '';
            this.nuevo_registro = true;
            this.obtener_tipos_disponibles();

            this.validation_errors.clear('form_create_cuenta');
            $('#add_movimiento_modal').modal('show');
            this.validation_errors.clear('form_create_cuenta');
        },
        edit_cuenta_bancaria: function (cuenta) {
            this.nuevo_registro = false;
            this.form.id_tipo_cuenta_contable = cuenta.id_tipo_cuenta_contable;
            this.form.cuenta = cuenta.cuenta;
            this.cuenta_descripcion = cuenta.tipo_cuenta_contable.descripcion;
            this.cuenta_edit_id = cuenta.id_cuenta_contable_bancaria;

            this.validation_errors.clear('form_update_cuenta');
            $('#edit_movimiento_modal').modal('show');
            this.validation_errors.clear('form_update_cuenta');
        },
        update_cuenta_bancaria: function () {
            var self = this;
            var data = self.form;
            var url = App.host + '/sistema_contable/cuentas_contables_bancarias/' + this.cuenta_edit_id;
            var toRemove = this.cuenta_edit_id;

            data.id_cuenta = self.cuenta.id_cuenta;
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    data: data,
                    _method: 'PATCH'
                },
                beforeSend: function () {
                    self.validation_errors.clear('form_update_cuenta');
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    $.each(self.asociadas, function (index, tipo_cuenta) {
                        if (toRemove == tipo_cuenta.id_cuenta_contable_bancaria) {
                            self.asociadas.splice(index, 1, data.data);
                        }
                    });

                    $('#edit_movimiento_modal').modal('hide');
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta:' + data.data.cuenta + '</b> fué actualizada correctamente',
                    });
                },
                complete: function () {
                    self.guardando = false;
                    this.cuenta_descripcion = '';
                    this.cuenta_edit_id = 0;
                    this.form.id_tipo_cuenta_contable = '';
                    this.form.cuenta = '';
                }
            });
        },
        save_cuenta_bancaria: function () {
            var self = this;
            var url = self.cuenta_store_url;
            var data = self.form;

            data.id_cuenta = self.cuenta.id_cuenta;
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function () {
                    self.validation_errors.clear('form_create_cuenta');
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.asociadas.push(data.data);
                    self.close_modal('add_movimiento_modal');
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta: <b>'+ data.data.cuenta +'</b> fue registrada correctamente',
                    });
                },
                complete: function () {
                    self.guardando = false;
                    this.form.id_tipo_cuenta_contable = '';
                    this.form.cuenta = '';
                }
            });
        },

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if (funcion == 'confirm_edit_cuenta') {
                    this.confirm_cuenta_update();
                }
                else if (funcion == 'confirm_create_cuenta') {
                    this.confirm_cuenta_create();
                }
            }).catch(() => {
                swal({
                     type: 'warning',
                     title: 'Advertencia',
                     text: 'Por favor corrija los errores del formulario'
                 });
            });
        },
        tipo_info: function (id) {
            var self = this,
                info = {};

            $.each(self.tipos, function (index, tipo_cuenta) {
                if (id == tipo_cuenta.id_tipo_cuenta_contable)
                    info = tipo_cuenta;
            });

            return info;
        },
        uniq: function (a) {
            var prims = {"boolean":{}, "number":{}, "string":{}}, objs = [];

            return a.filter(function(item) {
                var type = typeof item;
                if(type in prims)
                    return prims[type].hasOwnProperty(item) ? false : (prims[type][item] = true);
                else
                    return objs.indexOf(item) >= 0 ? false : objs.push(item);
            });
        },
        obtener_tipos_disponibles: function () {
            var self = this,
                tipos = [],
                tipos_temp = [],
                asociadas_tipos = [],
                tipos_disponibles = [];

            // No existen cuentas asociadas
            if (self.asociadas.length == 0) {
                return self.tipos;
            }

            $.each(self.asociadas, function (index, aso) {
                asociadas_tipos.push(parseInt(aso.id_tipo_cuenta_contable));
            });

            $.each(self.tipos, function (indexTipo, tipo) {
                tipos.push(tipo.id_tipo_cuenta_contable);
            });

            tipos_temp = tipos.filter(function(v) {
                return !asociadas_tipos.includes(v);
            });

            tipos_temp = self.uniq(tipos_temp);

            $.each(tipos_temp, function (index, tipo) {
                tipos_disponibles.push(self.tipo_info(tipo));
            });

            return tipos_disponibles;
        }
    }
});
