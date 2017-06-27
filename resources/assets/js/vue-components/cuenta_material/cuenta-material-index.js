Vue.component('cuenta_material_index',{
    data:{
        estatus: false,
        items: {}
    },
    method:{
        material: function () {
            var self = this;
            var id = self.material.value;
            var url = App.host + '/sistema_contable/cuenta_contable/findBy';
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    'value' : id
                },

                success: function(response) {
                    if(response.data.cuenta_material != null ) {
                        self.items = response;
                        self.estatus = true;
                    }
                }
            });


            
        }
    }
});
