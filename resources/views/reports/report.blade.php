@extends('layouts.app')

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
                    <td style="font-weight: bold;">{{ ($data['row']->numbers_people - $data['row']->reservas) }}</td>
                  </tr>
                  <tr>
                    <td style="width:20%"> Número de puestos ocupados: </td>
                    <td style="font-weight: bold;">{{ $data['row']->reservas }}</td>
                  </tr>
                  <tr>
                    <td style="width:20%"> Estado de evento: </td>
                    @if($data['row']->reservation_date > now()->toDateString())
                        <td style="font-weight: bold;">Evento disponible</td>
                    @else
                        <td style="font-weight: bold;">Evento finalizado / Reserva no disponible</td>
                    @endif
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                <table class="table m-t-30 table-hover no-wrap contact-list">
                    <thead>
                    <tr class="trtitle" style="font-size: 15px">
                        <th> Fila</th>
                        <th> Columna </th>
                        <th> Usuario </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(sizeof($puestos) > 0)
                        @foreach($puestos as $r)
                            <tr>
                                <td>{{ $r['row'] }}</td>
                                <td>{{ $r['column'] }}</td>
                                <td>{{ $r['user'] }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" align="center">No se encontraron registros</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
    <script>
        $('#menu-reports').addClass('active');
    </script>
@endsection
