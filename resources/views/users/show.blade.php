@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-block">
        <h3 class="card-title">Usuario</h3>
        <div class="row">
          <div class="col-lg-12">
            <a href="{{ url('/users') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
            <br>
            <div class="table-responsive-sm">
              <table class="table">
                <tbody>
                  <tr>
                    <td style="width:20%"> Nombre: </td>
                    <td style="font-weight: bold;">{{ $data['row']->name }}</td>
                  </tr>
                  <tr>
                    <td style="width:20%"> Apellido: </td>
                    <td style="font-weight: bold;">{{ $data['row']->lastname }}</td>
                  </tr>
                  <tr>
                    <td style="width:20%"> Email: </td>
                    <td style="font-weight: bold;">{{ $data['row']->email }}</td>
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
        $('#menu-users').addClass('active');
    </script>
@endsection
