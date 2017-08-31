Vue.component('revaluacion-create', {
    props: ['facturas'],
    data : function() {
        return {
            data: {
                facturas: this.facturas
            },
            guardando : false
        }
    },
    directives: {
        icheck: {
            inserted: function (el) {
                $(el).iCheck({
                    checkboxClass: 'icheckbox_minimal-grey'
                });
            }
        }
    }
});