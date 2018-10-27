@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-block">
        <h3 class="card-title">Evento</h3>
        <div class="row">
          <div class="col-lg-12">
            <a href="{{ url('/users-reservations') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
            <br>
            @include('layouts.alerts')
            <div class="table-responsive-sm">
              <table class="table">
                <tbody>
                  <tr>
                    <td style="width:20%"> Fecha de evento: </td>
                    <td style="font-weight: bold;">{{ date_format(date_create($data['row']->reservation_date), 'd/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width:20%"> Número de puestos disponibles: </td>
                    @if($data['row']->reservation_date > now()->toDateString())
                        <td style="font-weight: bold;">{{ ($data['row']->numbers_people - $data['row']->reservas) }}</td>
                    @else
                        <td style="font-weight: bold;">Evento finalizado / Reserva no disponible</td>
                    @endif
                  </tr>
                  @if(sizeof($data['row-user']) > 0)
                    <tr>
                        <td style="width:20%"> Puestos seleccionados: </td>
                        <td style="font-weight: bold;">
                            @foreach($data['row-user'] as $r)
                                [{{ $r->column }} - {{ $r->row }}], 
                            @endforeach
                        </td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      @if($data['row']->reservation_date > now()->toDateString())
        <div class="card-block">
            <h3 class="card-title">Seleccione Puestos</h3>
                <div class="row">
                    <div class="col-lg-12">
                    {!! Form::open(['url' => '/users-reservations/store', 'class' => 'form-horizontal', 'files' => true]) !!}
                        {{ Form::hidden('reserva', $data['row']->id, ['id' => 'reserva']) }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group @if($errors->has('column')) has-error @endif">
                                    {!! Form::label('column', 'Columna', ['class' => 'col-xs-3 control-label']) !!}
                                    <div class="col-xs-9">
                                        {{ Form::select('column', $columns, null, ['class' => 'form-control select2', 'required' => 'required', 'placeholder' => 'Selecciona...']) }}
                                        @if ($errors->has('column'))
                                            @foreach ($errors->get('column') as $error)
                                                <span id="column" class="help-block">{{ $error }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @if($errors->has('row')) has-error @endif">
                                    {!! Form::label('row', 'Fila', ['class' => 'col-xs-3 control-label']) !!}
                                    <div class="col-xs-9">
                                        <select id="row" name="row" class="form-control select2" style="width: 100%">
                                            <option value="">Selecciona...</option>
                                        </select>
                                        @foreach ($errors->get('row') as $error)
                                            <span id="row" class="help-block">{{ $error }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-4">
                                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Guardar', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endif
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script>
         $( document ).ready(function() {
            $('#column').change(function () {
                var reserva = $("#reserva").val();
                var column = $('#column').val();
                var url = "{{ url('/users-reservations/searchRow') }}";
                $('#row').html('');
                $('#row').append("<option value=''>Selecciona...</option>");
                $.get( url + '/' + reserva + '/' + column, function (response, state) {
                    console.log(response)
                    for(var j = 0; j < response.length; j ++) {
                        $('#row').append("<option value="+response[j]+">"+response[j]+"</option>");
                    }
                });
            });

            $('#menu-users-reservations').addClass('active');
            $('.select2').select2();

        });

        
    </script>
@endsection
