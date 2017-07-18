Vue.component('emails', {
    props: ['user', 'emails', 'notificacion_url'],
    data: function () {
        return {
            data : {
                emails: this.emails
            }
        }
    },

    created: function () {
        var socket = io('http://' + App.ip + ':3000');

        socket.on('emails-channel:Ghi\\Events\\NewEmail', function (data) {
            if (data.email.id_usuario == this.user.idusuario) {
                this.data.emails.push(data.email);
                $.notify({
                    // options
                    icon: 'fa fa-envelope-o fa-2x ',
                    title: data.email.titulo,
                    message: (new Date(data.email.created_at)).dateFormat(),
                    url: App.host + '/notificacion/' + data.email.id
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