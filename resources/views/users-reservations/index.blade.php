@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-block">
        <div class="row">
          <div class="col-lg-12 title-page form-group"> 
              <h3 class="card-title">Eventos</h3>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table m-t-30 table-hover no-wrap contact-list">
                <thead>
                  <tr class="trtitle" style="font-size: 15px">
                    <th> Fecha de evento</th>
                    <th> Cantidad de puestos disponibles </th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @if(sizeof($data['rows']) > 0)
                    @foreach($data['rows'] as $r)
                        <tr>
                            <td>{{ date_format(date_create($r->reservation_date), 'd/m/Y') }}</td>
                            @if($r->reservation_date > now()->toDateString())
                              <td>{{ ($r->numbers_people - $r->reservas)  }}</td>
                              <td>
                                <div class="pull-right btn-group-vertical" role="group">
                                    <a href="{{ url('/users-reservations/select/'. $r->id) }}" title="Seleccionar puestos"  class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Reservar puestos</a>
                                </div>
                              </td>
                            @else 
                              <td>Evento finalizado / Reserva no disponible</td>
                              <td>
                                <div class="pull-right btn-group-vertical" role="group">
                                    <a href="{{ url('/users-reservations/select/'. $r->id) }}" title="Seleccionar puestos"  class="btn btn-primary btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> Ver puestos</a>
                                </div>
                              </td>
                            @endif
                        </tr>
                    @endforeach
                  @else
                    <tr>
                        <td colspan="5" align="center">No se encontraron registros</td>
                    </tr>
                  @endif
                </tbody>
              </table>
              {{ $data['rows']->links() }}
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
        $('#menu-users-reservations').addClass('active')
    </script>
@endsection