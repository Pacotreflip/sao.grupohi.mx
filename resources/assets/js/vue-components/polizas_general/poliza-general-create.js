Vue.component('poliza-general-create', {
    props: ['polizas'],
    data: function() {
        return {
                   'form' : {
                       'poliza_seleccionada' : {
                        'tipo_poliza':'',
                        'concepto':'',
                        'total':'',
                        'cuadre':'',
                        'estatus':'',
                        'poliza_contpaq':'',
                        'usuario_registro':'',
                        'fecha_registro':''

                       },
                       'errors' : []
                   },
                   'guardando' : false
               }
    }
    ,
   methods: {
     ver_detalle:function(e){
             var self = this;
  console.log(e.tipos_polizas_contpaq.descripcion);
        Vue.set(self.form.poliza_seleccionada, 'tipo_poliza', e.tipos_polizas_contpaq.descripcion);
        Vue.set(self.form.poliza_seleccionada, 'fecha_registro', e.created_at);
        Vue.set(self.form.poliza_seleccionada, 'concepto', e.concepto);


    }}
});
