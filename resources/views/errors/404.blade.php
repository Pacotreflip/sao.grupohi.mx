@extends('layouts.app')

@section('htmlheader_title')
    Página no encontrada
@endsection

@section('contentheader_title')
    Página de error 404
@endsection

@section('$contentheader_description')
@endsection

@section('main-content')

<div class="error-page">
    <h2 class="headline text-yellow"> 404</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> Oops! Página no encontrada.</h3>
        <p>
            No hemos podido encontrar la página que estabas buscando.
            Mientras tanto, es posible <a href='{{ url('/') }}'>volver al inicio</a>
        </p>
    </div><!-- /.error-content -->
</div><!-- /.error-page -->
@endsection