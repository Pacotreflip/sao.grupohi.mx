@extends('sistema_contable.layout')
@section('title', 'Plantillas de Póliza')
@section('contentheader_title', 'TIPO CUENTA CONTABLE')
@section('contentheader_description', '(NUEVA)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.tipo_cuenta_contable.create') !!}

    <global-errors></global-errors>
    <tipo-cuenta-contable-create
                v-cloak
                inline-template>
            <section>
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Información del Tipo Cuenta Contable </h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descripcion" class="control-label">Descripción Tipo Cuenta Contable</label>
                                <input type="text" name="descripcion" class="form-control" id="descripcion" v-model="form.tipo_cuenta_contable.descripcion">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descripcion" class="control-label">Naturaleza de Cuenta</label>
                                <select class="form-control" v-model="form.tipo_cuenta_contable.id_naturaleza_poliza">
                                    <option value="">[--Seleccione--]</option>
                                    <option value="1">Deudora</option>
                                    <option value="2">Acreedora</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- /.box-body-->
                    <div class="box-footer">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-info pull-right" @click="confirm_save"  :disabled="form.tipo_cuenta_contable.descripcion == ''||form.tipo_cuenta_contable.id_naturaleza_poliza == ''">
                                    <span v-if="guardando">
                                        <i class="fa fa-spinner fa-spin"></i> Guardando
                                    </span>
                                <span v-else>
                                        <i class="fa fa-save"></i> Guardar
                                    </span>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-footer -->

                </div>

            </section>
        </tipo-cuenta-contable-create>
@endsection
