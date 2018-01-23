Vue.component('cambio-presupuesto-create', {
    data : function () {
        return {
            form : {
                id_tipo_cobrabilidad : ''
            },
            tipos_cobrabilidad : [],
            cargando : false
        }
    },

    mounted : function () {
        this.fetchTiposCobrabilidad();
    },

    methods : {
        fetchTiposCobrabilidad: function () {
            var self = this;
            $.ajax({
                url : App.host + '/control_presupuesto/tipo_cobrabilidad/',
                type : 'GET',
                beforeSend : function () {
                    self.cargando = true
                },
                sucess : function (response) {
                    self.tipos_cobrabilidad = response;
                },
                complete : function () {
                    self.cargando = false;
                }
            });
        }
    }
});