Vue.component('cambio-presupuesto-create', {
    data : function () {
        return {
            form : {
                id_tipo_cobrabilidad : '',
                id_tipo_orden : ''
            },
            tipos_cobrabilidad : [],
            tipos_orden : [],
            cargando : false
        }
    },

    computed: {
        tipos_orden_filtered : function () {
            var self = this;
            return this.tipos_orden.filter(function (tipo_orden) {
                return tipo_orden.id_tipo_cobrabilidad == self.form.id_tipo_cobrabilidad;
            });
        }
    },

    mounted : function () {
        this.fetchTiposCobrabilidad();
        this.fetchTiposOrden();
    },

    methods : {
        fetchTiposCobrabilidad: function () {
            var self = this;
            $.ajax({
                url : App.host + '/control_presupuesto/tipo_cobrabilidad',
                type : 'GET',
                beforeSend : function () {
                    self.cargando = true
                },
                success : function (response) {
                    self.tipos_cobrabilidad = response;
                },
                complete : function () {
                    self.cargando = false;
                }
            });
        },

        fetchTiposOrden: function () {
            var self = this;
            $.ajax({
                url : App.host + '/control_presupuesto/tipo_orden',
                type : 'GET',
                beforeSend : function () {
                    self.cargando = true
                },
                success : function (response) {
                    self.tipos_orden = response;
                },
                complete : function () {
                    self.cargando = false;
                }
            });
        }
    }
});