Vue.component('cuenta-material-index', {
    data: function() {
        return {
            'data' : {
                'items': [],
            },
            valor: '0',
            guardando : false
        }
    },
    methods:{
        cambio: function () {
            var self = this;
            var id = self.valor;
            if(id != 0){
                var url = App.host + '/sistema_contable/cuenta_material/';
                $.ajax({
                    type: 'GET',
                    url: url + id,

                    success: function(response) {
                        self.data.items = response;
                    }
                });
            }
        }

    }
});
