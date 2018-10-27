@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-block">
        <h3 class="card-title">Evento</h3>
        <div class="row">
          <div class="col-lg-12">
            <a href="{{ url('/reservations') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
            <br>
            <div class="table-responsive-sm">
              <table class="table">
                <tbody>
                  <tr>
                    <td style="width:20%"> Fecha de evento: </td>
                    <td style="font-weight: bold;">{{ date_format(date_create($data['row']->reservation_date), 'd/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width:20%"> Número de puestos: </td>
                    <td style="font-weight: bold;">{{ $data['row']->numbers_people }}</td>
                  </tr>
                  <tr>
                    <td style="width:20%"> Cantidad de columnas: </td>
                    <td style="font-weight: bold;">{{ $data['row']->row }}</td>
                  </tr>
                  <tr>
                    <td style="width:20%"> Cantidad de filas: </td>
                    <td style="font-weight: bold;">{{ $data['row']->column }}</td>
                  </tr>
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
        $('#menu-reservations').addClass('active');
    </script>
@endsection
