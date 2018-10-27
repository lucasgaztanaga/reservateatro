@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-block">
        <div class="row">
          <div class="col-lg-12 title-page form-group"> 
              <h3 class="card-title">Crear Evento</h3>
          </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <a href="{{ url('/reservations') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                <br />

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                {!! Form::open(['url' => '/reservations/store', 'class' => 'form-horizontal', 'files' => true]) !!}

                @include ('reservations.form')

                {!! Form::close() !!}
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') }}" type="text/javascript"></script>
    <script>
        $( document ).ready(function() {
            $('.datepicker').datepicker({ 
                    format: "dd/mm/yyyy",
                    autoclose:false,
                    language: 'es',
                });
            $('#menu-reservations').addClass('active');
        });
    </script>
@endsection
