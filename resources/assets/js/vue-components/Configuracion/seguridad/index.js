Vue.component('configuracion-seguridad-index', {
    data : function () {
        return {
            roles : [],
            permissions : [],
            guardando : false,
            searchQuery : ''
        }
    },

    computed : {
        filteredPermissions : function () {
            var self = this
            return self.permissions.filter(function (permission) {
                return (permission.display_name).toLowerCase().indexOf(self.searchQuery.toLowerCase()) !== -1
            });
        }
    },

    mounted : function () {
        this.fetchRoles();
        this.fetchPermissions();
    },

    methods : {
        fetchRoles: function () {
            var self = this;
            $.ajax({
                url : App.host + '/configuracion/seguridad/role',
                beforeSend : function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.roles = data;
                },
                complete : function () {
                    self.guardando = false;
                }
            });
        },

        fetchPermissions: function () {
            var self = this;
            $.ajax({
                url : App.host + '/configuracion/seguridad/permission',
                beforeSend : function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.permissions = data;
                },
                complete : function () {
                    self.guardando = false;
                }
            });
        }
    }
});