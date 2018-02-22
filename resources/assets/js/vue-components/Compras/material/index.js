Vue.component('material-index', {
    props: ['material_url'],
    data: function () {
        return {
            'data': {
                'materiales':[],
                'items': [],
                'cuenta_material_edit': {}
            },
            'form': {
                'cuenta_material': {
                    'id': '',
                    'cuenta': '',
                    'id_tipo_cuenta_material': 0,
                    'id_material': ''
                }
            },
            'material':{
                'unidad':'',
                'nivel':'',
                'descripcion':'',
                'tipo_material':'',
                'unidad_compra':''
            },
            valor: '0',
            guardando: false

        }
    },
    template: require('./template/modal_materiales_create.html'),

    mounted: function () {
        var self=this;
        this.$parent.$on('abrirModalMateriales',function (tipoMaterial) {
            self.abrir_modal(tipoMaterial);
            self.material.tipo_material=tipoMaterial;
        });
    }
    ,
    methods: {
        cambio: function () {
            var self = this;
            var id = self.valor;
            if (id != 0) {
                self.guardando = true;
                var urla = App.host + '/compras/material/';
                $.ajax({
                    type: 'GET',
                    url: urla + id + "/tipo",

                    success: function (response) {
                        self.data.items = response;
                    },
                    complete: function () {
                        self.guardando = false;
                    },
                    error: function(error) {
                        alert(error.responseText);
                        self.guardando = false;
                    }
                });
            }
        },
        get_materiales: function(concepto) {
            var self = this;

            $.ajax({
                type:'GET',
                url: self.material_url,
                data:{
                    attribute: 'nivel',
                    operator: 'like',
                    value: concepto.nivel_hijos,
                    with : 'cuentaConcepto'
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.data.materiales = data;
                }
            });
        },
        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'save_material') {
                    this.confirmSave();
            }
        }).catch(() => {
                swal({
                         type: 'warning',
                         title: 'Advertencia',
                         text: 'Por favor corrija los errores del formulario'
                     });
        });
        },

        confirmSave: function () {
            var self = this;
            swal({
                title: 'Guardar Familia',
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
        save: function () {
            var self = this;
            $.each(self.material, function(key, value){
                if ((value === ''|| value === null)&&key!='nivel'){
                    delete self.material[key];
                }
            });

            $.ajax({
                url : App.host + '/material',
                type : 'POST',
                data : self.material,
                beforeSend : function () {
                    self.guardando = true;
                },
                success : function (response) {
                       swal({
                        type : 'success',
                        title : '¡Correcto!',
                        html : 'Material Guardado Exitosamente.'
                    }).then(function () {
                        $('#add_material_modal').modal('hide');

                      });
                    self.guardando = false;

                    self.material.unidad='';
                    self.material.nivel='';
                    self.material.descripcion='';
                    self.material.tipo_material='';
                    self.material.unidad_compra='';


                },
                complete : function () {
                    self.guardando = false;
                    $('#add_material_modal').modal('hide');
                }
            })
        },
        cerrar_modal_material: function () {
            var self=this;
            self.material.unidad='';
            self.material.nivel='';
            self.material.descripcion='';
            self.material.tipo_material='';
            self.material.unidad_compra='';
            $('#add_material_modal').modal("hide");
        },
        abrir_modal: function (tipo) {
            var self = this;
            self.material.unidad='';
            self.material.nivel='';
            self.material.descripcion='';
            self.material.tipo_material='';
            self.material.unidad_compra='';

            $('#sel_material_familias').select2({
                width: '100%',
                ajax: {
                    url: App.host + '/material/getFamiliasByTipoPadres',
                    dataType: 'json',
                    delay: 500,
                    data: function (params) {
                        return {
                            descripcion:  params.term,
                            tipo:tipo
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data.materiales, function (item) {
                                return {
                                    text:item.descripcion,
                                    descripcion: item.descripcion,
                                    id: item.nivel

                                }
                            })
                        };
                    },
                    error: function (error) {

                    },
                    cache: true
                },
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 1
            }).on('select2:select', function (e) {
                var data = e.params.data;
                self.material.nivel=data.id;


            });

            $('#sel_unidades').select2({
                width: '100%',
                ajax: {
                    url: App.host + '/unidad/getUnidadesByDescripcion',
                    dataType: 'json',
                    delay: 500,
                    data: function (params) {
                        return {
                            descripcion:  params.term

                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text:item.descripcion,
                                    descripcion: item.descripcion,
                                    id: item.unidad
                                }
                            })
                        };
                    },
                    error: function (error) {

                    },
                    cache: true
                },
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 1
            }).on('select2:select', function (e) {
                var data = e.params.data;
              self.material.unidad=data.id
              self.material.unidad_compra=data.id

            });
            $('#add_material_modal').modal("show");
        }
    }
});
