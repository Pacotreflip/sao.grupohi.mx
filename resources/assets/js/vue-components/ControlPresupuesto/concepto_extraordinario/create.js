Vue.component('concepto-extraordinario-create', {
    props : ['unidades', 'tipos_extraordinarios', 'tarjetas', 'catalogo', 'id_tipo_orden'],
    data:function () {
        return {
            form:{
                id_origen_extraordinario:'',

                extraordinario: {}
            },
            tipos_costos:[
                {id:'1', descripcion:'Costo Directo'},
                {id:'2', descripcion:'Costo Indirecto'}
            ],
            id_opcion:'',
            cargando:false,
            mostrar_tabla:false
        }
    },

    watch : {
        id_opcion : function () {
            this.validacion_opciones(2);
        }
    },
    methods: {
        getExtraordinario: function () {
            var self = this;
            $.ajax({
                type: 'GET',
                url: App.host + '/control_presupuesto/conceptos_extraordinarios/' + self.form.id_origen_extraordinario + '/extraordinario/' + self.id_opcion,
                beforeSend: function () {
                    self.cargando = true;
                    self.mostrar_tabla = false;
                },
                success: function (data, textStatus, xhr) {
                    if (self.form.id_origen_extraordinario == 1) {
                        console.log('Pandita');
                        self.rendimiento_tarjeta(data.data)
                    } else {
                        console.log(self.form.id_origen_extraordinario);
                        self.reformato_rendimientos(data.data);
                    }
                },
                complete: function () {
                    self.cargando = false;
                    self.mostrar_tabla = true;
                }
            });
        },

        rendimiento_tarjeta:function (data) {
            var self = this;
            $.each(data.MATERIALES.insumos, function (index, partida) {
                data.MATERIALES.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada / data.cantidad_presupuestada).formatMoney(6,'.','');
                data.MATERIALES.insumos[index].monto_presupuestado =   partida.precio_unitario * data.MATERIALES.insumos[index].cantidad_presupuestada;
            });
            $.each(data.MANOOBRA.insumos, function (index, partida) {
                data.MANOOBRA.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada / data.cantidad_presupuestada).formatMoney(6,'.','');
                data.MANOOBRA.insumos[index].monto_presupuestado =   partida.precio_unitario * data.MANOOBRA.insumos[index].cantidad_presupuestada;
            });
            $.each(data.HERRAMIENTAYEQUIPO.insumos, function (index, partida) {
                data.HERRAMIENTAYEQUIPO.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada / data.cantidad_presupuestada).formatMoney(6,'.','');
                data.HERRAMIENTAYEQUIPO.insumos[index].monto_presupuestado =   partida.precio_unitario * data.HERRAMIENTAYEQUIPO.insumos[index].cantidad_presupuestada;
            });
            $.each(data.MAQUINARIA.insumos, function (index, partida) {
                data.MAQUINARIA.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada / data.cantidad_presupuestada).formatMoney(6,'.','');
                data.MAQUINARIA.insumos[index].monto_presupuestado =   partida.precio_unitario * data.MAQUINARIA.insumos[index].cantidad_presupuestada;
            });
            $.each(data.SUBCONTRATOS.insumos, function (index, partida) {
                data.SUBCONTRATOS.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada / data.cantidad_presupuestada).formatMoney(6,'.','');
                data.SUBCONTRATOS.insumos[index].monto_presupuestado =   partida.precio_unitario * data.SUBCONTRATOS.insumos[index].cantidad_presupuestada;
            });
            $.each(data.GASTOS.insumos, function (index, partida) {
                data.GASTOS.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada / data.cantidad_presupuestada).formatMoney(6,'.','');
                data.GASTOS.insumos[index].monto_presupuestado =   partida.precio_unitario * data.GASTOS.insumos[index].cantidad_presupuestada;
            });
            self.form.extraordinario = data;
        },

        reformato_rendimientos:function (data) {
            var self = this;
            $.each(data.MATERIALES.insumos, function (index, partida) {
                data.MATERIALES.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada).formatMoney(6,'.','');
            });
            $.each(data.MANOOBRA.insumos, function (index, partida) {
                data.MANOOBRA.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada).formatMoney(6,'.','');
            });
            $.each(data.HERRAMIENTAYEQUIPO.insumos, function (index, partida) {
                data.HERRAMIENTAYEQUIPO.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada).formatMoney(6,'.','');
            });
            $.each(data.MAQUINARIA.insumos, function (index, partida) {
                data.MAQUINARIA.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada).formatMoney(6,'.',',');
            });
            $.each(data.SUBCONTRATOS.insumos, function (index, partida) {
                data.SUBCONTRATOS.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada).formatMoney(6,'.','');
            });
            $.each(data.GASTOS.insumos, function (index, partida) {
                data.GASTOS.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada).formatMoney(6,'.','');
            });
            self.form.extraordinario = data;
        },

        validacion_opciones:function (tipo) {
            var self = this;
            if(self.mostrar_tabla){
                swal({
                    title: 'Cambiar Opciones',
                    text: "¿Desea cambiar de extraordinario, puede perder la información modificada?",
                    type: 'warning',
                    showCancelButton: true,

                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Cambiar',
                    cancelButtonText: 'No, Cancelar'
                }).then(function(result) {
                    if(result.value){
                        self.id_opcion = '';
                        self.mostrar_tabla = false;
                    }

                });
            }else if(tipo == 1) {
                self.id_opcion = '';
            }
        }

    }
});