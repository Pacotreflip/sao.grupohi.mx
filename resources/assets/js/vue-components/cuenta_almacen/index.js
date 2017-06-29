Vue.component('cuenta-almacen-index', {
    props: ['url_cuenta_almacen', 'url_cuenta_almacen_store', 'almacenes']
    data: function() {
        return {
            'data' : {
                'almacenes' : this.almacenes
            },
            'form': {
                'cuenta_almacen': {
                    'id_almacen': '',
                    'cuenta' : ''
                }
            },
            'guardando' : false
        }
    },
    methods:{
        editar:function (almacen){
            Vue.set(this.form.cuenta_almacen, 'id_almacen', almacen.id_almacen);
            Vue.set(this.form.cuenta_almacen, 'cuenta', almacen.cuenta_almacen.cuenta);

        }
    }
});
