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
                    self.estimaciones = [];

                    Vue.set(self.form, 'id_subcontrato', '');
                    Vue.set(self.form, 'id_estimacion', '');
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
                    Vue.set(self.form, 'id_estimacion', '');

                },
                complete: function () {
                    self.cargando = false;
                }
            })
        },

        pdf: function (id_estimacion) {
            var url = App.host + '/reportes/subcontratos/estimacion/' + id_estimacion;
            $("#PDFModal .modal-body").html('<iframe src="'+url+'"  frameborder="0" height="100%" width="99.6%">d</iframe>');
            $("#PDFModal").modal("show");
        }
    }
});