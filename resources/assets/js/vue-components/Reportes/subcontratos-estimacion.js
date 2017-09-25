Vue.component('subcontratos-estimacion', {
    props : ['subcontratos_url', 'estimaciones_url'],
    data: function () {
        return {
            'form' : {
                id_empresa : '',
                id_subcontrato : '',
                id_estimacion : ''
            },
            'empresas' : [],
            'subcontratos' : [],
            'estimaciones' : [],
            'cargando' : false
        }
    },

    methods: {
        fetchSubcontratos: function (id_empresa) {
            var self = this;

            $.ajax({
                type: 'GET',
                data: {
                    attribute: 'id_empresa',
                    operator: '=',
                    value: id_empresa
                },
                url: self.subcontratos_url + '/getBy',
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (response) {
                    self.subcontratos = response.data.subcontratos;
                },
                complete: function () {
                    self.cargando = false;
                }
            })
        },

        fetchEstimaciones: function (id_subcontrato) {
            var self = this;

            $.ajax({
                type: 'GET',
                data: {
                    attribute: 'id_antecedente',
                    operator: '=',
                    value: id_subcontrato
                },
                url: self.estimaciones_url + '/getBy',
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (response) {
                    self.estimaciones = response.data.estimaciones;
                },
                complete: function () {
                    self.cargando = false;
                }
            })
        }
    }
});