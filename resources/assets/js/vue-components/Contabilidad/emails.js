Vue.component('emails', {
    props: ['user', 'emails', 'notificacion_url','db','id_obra'],
    data: function () {
        return {
            data : {
                emails: this.emails
            }
        }
    },

    created: function () {
        var socket = io(App.socket_host);

        socket.on('emails-channel:Ghi\\Events\\NewEmail', function (data) {
            if (data.email.id_usuario == this.user.idusuario&&data.db==this.db&&data.email.id_obra==this.id_obra) {
                this.data.emails.push(data.email);
                $.notify({
                    // options
                    icon: 'fa fa-envelope-o fa-2x ',
                    title: data.email.titulo,
                    message: (new Date(data.email.created_at)).dateFormat(),
                    url: App.host + '/sistema_contable/notificacion/' + data.email.id
                },{
                    // settings
                    type: 'warning',
                    newest_on_top: true,
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                });
            }
        }.bind(this));
    }
});