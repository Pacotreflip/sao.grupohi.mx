Vue.component('cuenta-material-index', {
    data: function() {
        return {
            valor: '0',
            items: '',
            guardando : false
        }
    },
    method:{
        material: function () {

        }

    },

    computed:{
        cambio: function () {
            var self = this;
            var id = self.valor;
            if(id != 0){
                var url = App.host + '/sistema_contable/cuenta_material/findBy';
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        'value' : id
                    },

                    success: function(response) {
                        if(response.data.cuenta_material != null ) {
                            self.items = response.data.cuenta_material;
                            self.guardando = true;
                        }
                    }
                });
            }
        }
    }
});
