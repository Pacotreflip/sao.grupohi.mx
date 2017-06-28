Vue.component('concepto-cuenta-edit', {
    props: ['conceptos','url_concepto_get_by'],
    data: function () {
        return {
            'data': {
                'conceptos' : this.conceptos
            },
            'form': {

            },
            'guardando': false
        }
    },
    directives: {
        treegrid: {
            inserted: function (el) {
                $(el).treegrid({
                    treeColumn: 0
                });
            }
            /*,

            componentUpdated:function (el) {
                $(el).treegrid();

            }*/
        }



    },

    computed: {
        conceptos_ordenados: function () {
            return this.data.conceptos.sort(function(a,b) {return (a.nivel > b.nivel) ? 1 : ((b.nivel > a.nivel) ? -1 : 0);} );

        }
    },
    methods: {
        tr_class: function(concepto) {

            var treegrid = "treegrid-" + concepto.id_concepto;
            var treegrid_parent = concepto.id_padre != null ?  " treegrid-parent-" + concepto.id_padre : "";
            return treegrid + treegrid_parent;
        },

        tr_id: function (concepto) {
            return concepto.id_padre == null ? "tnode-" + concepto.id_concepto : "";
        },

        get_hijos: function(concepto) {

            var self=this;
            $.ajax({
                type:'GET',
                url: self.url_concepto_get_by,
                data:{
                    attribute: 'nivel',
                    operator: 'like',
                    value: concepto.nivel_hijos
                },
                success: function (data, textStatus, xhr) {
                    data.data.conceptos.forEach(function (concepto) {
                        self.data.conceptos.push(concepto);
                    });
                    concepto.cargado = true;

                    $('#concepto_tree').treegrid();
                    $('#tr_id'+concepto.id).treegrid('expand');
                }
            })
        }
    }
});
