Vue.component('reclasificacion_costos-index', {
    props: ['url_solicitudes_reclasificacion_index', 'solicitudes'],
    data : function () {
        return {
            'data' : {
                'solicitudes': this.solicitudes
            },
            'guardando' : false
        }
    },
    computed: {},
    mounted: function() {},
    directives: {},
    methods: {}
});
