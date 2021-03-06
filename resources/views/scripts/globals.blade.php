<!-- App Globals -->
<script>
    window.App = {
        // Token CSRF de Laravel
        csrfToken: '{{ csrf_token() }}',
        host: '{{ url("/") }}',
        socket_host: 'http://sao-notificaciones.grupohi.mx:3000',
        formato_cuenta: '{{$currentObra ? $currentObra->datosContables->mask : null }}',
        regex_cuenta: {!! $currentObra ? json_encode($currentObra->datosContables->FormatoCuentaRegExp) : json_encode(null) !!},
        // ID del Usuario Actual
        userId: {!! Auth::check() ? Auth::id() : 'null' !!},
        app_key : '{{ config('app.key') }}',

        // Transformar los errores y asignarlos al formulario
        setErrorsOnForm: function (form, errors) {
            if (typeof errors === 'object') {
                form.errors = _.flatten(_.toArray(errors));
            } else {
                var ind1 = errors.indexOf('<span class="exception_message">');
                var cad1 = errors.substring(ind1);
                var ind2 = cad1.indexOf('</span>');
                var cad2 = cad1.substring(32,ind2);
                if(cad2 != ""){
                    form.errors.push( cad2);
                }else{
                    form.errors.push('Un error grave ocurrió. Por favor intente otra vez.');
                }
            }
        },
        timeStamp: function(type) {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();
            var hh = today.getHours();
            var min = today.getMinutes();

            if(dd < 10) {dd = '0' + dd}
            if(mm < 10) {mm = '0' + mm}
            if(hh < 10) {hh = '0' + hh}
            if(min < 10) {min = '0' + min}

            var date = yyyy + '-' + mm + '-' + dd;
            var time = hh + ":" + min;

            return type == 1 ? date : time;
        }
    }
</script>