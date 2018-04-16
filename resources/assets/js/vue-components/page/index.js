Vue.component('obra-index', {
    props: [
        'usuario',
        'app_key',
        'route_obra_search'
    ],
    'data': function(){
        return {}
    },
    mounted: function () {
        var self = this;
        $("#obras_select").select2({
                width: '100%',
                ajax: {
                url: self.route_obra_search,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: '[' + item.databaseName + '] ' + item.nombre,
                                id: item.id_obra,
                                "data-id_obra": item.id_obra,
                                "data-database_name": item.databaseName,
                                url: App.host + '/context/' + item.databaseName + '/' + item.id_obra
                            }
                        })
                    };
                },
                error: function (error) {

                },
                cache: true
            },
            escapeMarkup: function (markup) {
                    return markup;
            },
            minimumInputLength: 1
        });
        $('#context_set').on('click', function() {
            if($('#obras_select option:selected').data()) {
                var data = {
                    "usuario": self.usuario,
                    "database_name": $('#obras_select option:selected').data().database_name,
                    "id_obra": $('#obras_select option:selected').data().id_obra,
                    "app_key": self.app_key
                };
                if (self.obtenerToken(data)) {
                    window.location = $('#obras_select option:selected').data().data.url;
                }
            }
        });
        $('.list-group-item').on('click',function (event) {
            var data = {"usuario": self.usuario,
                "database_name": $(this).data('database_name'),
                "id_obra": $(this).data('id_obra'),
                "app_key": self.app_key
            };
            if (self.obtenerToken(data)) {
                window.location = App.host + '/context/' + data.database_name + '/' + data.id_obra;
            }
            return false;
        });
    },
    methods: {
        obtenerToken: function(data) {
            var self = this;
            $.ajax({
                "async": true,
                "url": App.host+"/api/auth",
                "method": "POST",
                "headers": {
                    "accept": "application/vnd.saoweb.v2+json"
                },
                dataType  : 'json',
                "data": data,
                success: function (response) {
                    console.log(response);
                    localStorage.setItem('token', "bearer "+response.token);
                    self.$session.start();
                    self.$session.set('jwt', 'Bearer ' + response.token);
                }
            });
            return true;
        }
    }
});