Vue.component('dropzone', Dropzone);
Vue.component('configuracion-obra-index', {
    data: function () {
        return {
            id_config: 0,
            logotipo_original: false,
            logotipo_reportes: false,
            dropzoneOptions: {
                url: App.host + '/configuracion/imagen/insert',
                thumbnailWidth: 250,
                maxFilesize: 16.00,
                maxFiles:1,
                headers: {'X-CSRF-TOKEN': App.csrfToken},
                addRemoveLinks: true,
                dictRemoveFile: 'Remove file',
                dictFileTooBig: 'Image is larger than 16MB',
                timeout: 10000,
                dictMaxFilesExceeded: "You can only upload upto 5 images",
                dictCancelUploadConfirmation: "Are you sure to cancel upload?",
                accept: function (file, done) {
                    if ((file.type).toLowerCase() != "image/png"
                    ) {
                        done("Invalid file");
                    }
                    else {
                        done();
                    }
                },
                init: function () {
                    this.on("success", function (file) {
                        var _this = this;
                        setTimeout(function(){
                            _this.removeAllFiles();
                        }, 2000);
                    });
                }
            }
        }
    },
    mounted : function () {
        var self = this;
        self.showSuccess();
    },
    methods : {
        showSuccess: function () {
            var self = this;
            $.ajax({
                url: App.host + '/configuracion/imagen/show',
                type: 'GET',
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (response) {
                    if(response.length>0) {
                        self.id_config = response[0].id;
                        self.logotipo_original = "data:image/png;base64,"+response[0].logotipo_original;
                        self.logotipo_reportes = "data:image/png;base64,"+response[0].logotipo_reportes;
                    }
                },
                complete: function () {
                    self.cargando = false;
                }
            });
        },
        removeThisFile: function () {
            var self = this;
            self.id_config;
            $.ajax({
                url: App.host + '/configuracion/imagen/delete/'+self.id_config,
                type: 'DELETE',
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (response) {
                    self.id_config = 0;
                    self.logotipo_original = false;
                    self.logotipo_reportes = false;
                },
                complete: function () {
                    self.cargando = false;
                }
            })
        }
    }
});