<div class="box-solid">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
    </div>
    <div class="box-body">
        @if($material_restante > 0)
        <div class="table-responsive">
            <table class="table small">
                <thead>
                <tr>
                    <th colspan="9"><a href="http://www.google.com" >MATERIALES</a></th>
                </tr>
                <tr>
                    <th class="text-center">Configuradas</th>
                    <th class="text-center">Pendientes</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="text-center"><h4><strong>{{$material_actual}}</strong></h4></td>
                    <td class="text-center"><h4><strong>{{$material_restante}}</strong></h4></td>
                </tr>
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>