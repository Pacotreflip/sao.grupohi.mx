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
            valor: '0',
            guardando: false

        }
    },
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
        }
    }
});
