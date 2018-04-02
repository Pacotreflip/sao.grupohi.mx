@extends('configuracion.layout')
@section('title', 'Configuración del Presupuesto')
@section('contentheader_title', 'CONFIGURACIÓN DE LA OBRA')
@section('breadcrumb')
    {!! Breadcrumbs::render('configuracion.presupuesto.index') !!}
@endsection
@section('main-content')
    <configuracion-obra-index inline-template v-cloak>
        <section>
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Configuración de Logotipo de la obra
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="thumbnail" v-if="logotipo_original">
                                        <img :src="logotipo_original" alt="" class="img-thumbnail"
                                             >
                                    </div>
                                </div>
                                <div class="col-md-5" v-if="logotipo_reportes" >
                                    <div class="thumbnail" v-if="logotipo_reportes" >
                                        <img :src="logotipo_reportes" alt="" class="img-thumbnail"
                                              >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button @click="removeThisFile" class="btn btn-danger" v-if="logotipo_reportes" >
                                        <i class="fa fa-trash-o" ></i>
                                    </button >
                                </div>
                            </div>
                        </div>
                        <form action="#" enctype="multipart/form-data">
                            <div class="box-body">
                                <input type="hidden" :name="'id_config'" id="id_config" v-model="id_config">
                                <dropzone :options="dropzoneOptions" ref="myVueDropzone"
                                          v-on:vdropzone-success="showSuccess"
                                          :use-custom-dropzone-options=true id="fileDropZone"></dropzone>
                                <!--v-on:vdropzone-removed-file="removeThisFile"-->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </configuracion-obra-index>
@endsection