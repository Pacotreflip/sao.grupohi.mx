var comp = Vue.component('concepto-cuenta-edit', {
    props: ['conceptos','url_concepto_get_by', 'datos_contables', 'url_store_cuenta'],
    data: function () {
        return {
            'data': {
                'conceptos' : this.conceptos
            },
            'form': {
                'cuenta' : '',
                'concepto' : '',
                'id' : ''
            },
            'cargando': false
        }
    },
    directives: {
        treegrid: {
            inserted: function (el) {
                $(el).treegrid({
                    saveState: true,
                    initialState: 'collapsed'
                });
            },
            componentUpdated:function (el) {
                console.log('cambio');
                $(el).treegrid({
                    saveState: true,
                    initialState: 'collapsed'
                });
                console.log('fin cambio')
            }
        }
    },

    computed: {
        conceptos_ordenados: function () {
            return this.data.conceptos.sort(function(a,b) {return (a.nivel > b.nivel) ? 1 : ((b.nivel > a.nivel) ? -1 : 0);} );

        }
    },

    methods: {
        tr_class: function(concepto) {

            var treegrid = "treegrid-" + concepto.id_concepto;
            var treegrid_parent = concepto.id_padre != null ?  " treegrid-parent-" + concepto.id_padre : "";
            return treegrid + treegrid_parent;
        },

        tr_id: function (concepto) {
            return concepto.id_padre == null || concepto.tiene_hijos > 0 ? "tnode-" + concepto.id_concepto : "";
        },

        get_hijos: function(concepto) {

            var self=this;
            $.ajax({
                type:'GET',
                url: self.url_concepto_get_by,
                data:{
                    attribute: 'nivel',
                    operator: 'like',
                    value: concepto.nivel_hijos,
                    with : 'cuentaConcepto'
                },
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (data, textStatus, xhr) {
                    console.log('inicio de push');
                    var i = 0;
                    data.data.conceptos.forEach(function (concepto) {
                        self.data.conceptos.push(concepto);
                        console.log('push ' + i);
                    });
                    console.log('fin de push');

                    $('#tnode-' + concepto.id_concepto).treegrid('expand');
                    console.log('expandir arbol en success');
                },
                complete: function() {
                    self.cargando = false;
                    concepto.cargado = true;
                    console.log('condicion');
                    console.log($('#tnode-' + concepto.id_concepto).treegrid('isCollapsed'));

                    if ($('#tnode-' + concepto.id_concepto).treegrid('isCollapsed')){
                        console.log('cerrado');
                        //$('#tnode-' + concepto.id_concepto + ' .treegrid-expander').click();
                        $('#tnode-' + concepto.id_concepto).treegrid('expand');
                        console.log('expandir arbol en complete');
                    } else {
                        console.log('abierto');
                    };
                }
            });
        },

        edit_cuenta: function (concepto) {
            Vue.set(this.form, 'concepto', concepto.descripcion);
            if (concepto.cuenta_concepto != null) {
                Vue.set(this.form, 'cuenta', concepto.cuenta_concepto.cuenta);
                Vue.set(this.form, 'id', concepto.cuenta_concepto.id);
            } else {
                Vue.set(this.form, 'cuenta', '');
                Vue.set(this.form, 'id', '');
            }
            this.validation_errors.clear('form_edit_cuenta');
            $('#edit_cuenta_modal').modal('show');
        },

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'confirm_save_cuenta') {
                    this.confirm_save_cuenta();
                } else if (funcion == 'confirm_update_cuenta') {
                   this.confirm_update_cuenta();
                }
            }).catch(() => {
                swal({
                     type: 'warning',
                     title: 'Advertencia',
                     text: 'Por favor corrija los errores del formulario'
                });
            });
        },

        confirm_update_cuenta: function () {
            var self = this;
            swal({
                title: "Actualizar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.update_cuenta();
            }).catch(swal.noop);
        },

        update_cuenta: function () {
            var self = this;
            var url = this.url_store_cuenta + this.form.id;
            
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method: 'PATCH',
                    cuenta: self.form.cuenta
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function () {
                    
                }
            });
        },

        confirm_save_cuenta: function () {
            var self = this;
            swal({
                title: "Registrar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.save_cuenta();
            }).catch(swal.noop);
        },

        save_cuenta: function () {
            var url = this.url_store_cuenta;
        },

        close_edit_cuenta: function () {
            $('#edit_cuenta_modal').modal('hide');
            Vue.set(this.form, 'cuenta', '');
            Vue.set(this.form, 'concepto', '');
            Vue.set(this.form, 'id', '');
        },
    }
});
