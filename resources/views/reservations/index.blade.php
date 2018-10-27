@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-block">
        <div class="row">
          <div class="col-lg-12 title-page form-group"> 
              <h3 class="card-title">Eventos</h3>
              <a href="{{ url('/reservations/create') }}" class="btn btn-primary">Agregar evento</a>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
          @include('layouts.alerts')
            <div class="list-count pull-right font-blue-madison"> 
                {!! Form::open([
                    'method'=>'POST',
                    'url' => ['/reservations'],
                    'class' => 'form-inline',
                    'role' => 'form'
                    ]) !!}
                    <div class="form-group">
                        <input id="form-search-search-value" type="text" name="ReservationController_search" class="form-control" value="{{ $data['ReservationController_search'] }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary search">Buscar</button>
                    </div>
                    <input type="hidden" name="ReservationController_field" value="{{ $data['ReservationController_field'] }}">                               
                    <input type="hidden" name="ReservationController_orderby" value="{{ $data['ReservationController_orderby'] }}"> 
                {!! Form::close() !!}
            </div>     
            <div class="table-responsive">
              <table class="table m-t-30 table-hover no-wrap contact-list">
                <thead>
                  <tr class="trtitle" style="font-size: 15px">
                    <th> Fecha de evento</th>
                    <th> Cantida de puestos </th>
                    <th> Número de filas </th>
                    <th> Número de columnas </th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @if(sizeof($data['rows']) > 0)
                    @foreach($data['rows'] as $r)
                        <tr>
                            <td>{{ date_format(date_create($r->reservation_date), 'd/m/Y') }}</td>
                            <td>{{ $r->numbers_people  }}</td>
                            <td>{{ $r->row }}</td>
                            <td>{{ $r->column }}</td>
                            <td>
                                {!! Form::open([
                                    'method'=>'DELETE',
                                    'url' => ['/reservations/destroy', $r->id],
                                    'style' => 'display:inline',
                                    'id' => 'form-destroy-'.$r->id,
                                ]) !!}
                                <div class="pull-right btn-group-vertical" role="group">
                                    <a href="{{ url('/reservations/show/' . $r->id) }}" title="Ver"  class="btn btn-primary btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> Ver</a>
                                    <a href="{{ url('/reservations/edit/' . $r->id) }}" title="Editar" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a>
                                    {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Borrar', array(
                                            'type' => 'submit',
                                            'class' => 'btn btn-danger btn-xs',
                                            'title' => 'Delete Reservation',
                                            'onclick'=>'return confirm("Confirm delete?")'
                                    )) !!}
                                </div>
                                {!! Form::close() !!}
                            </td>
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
        $('#menu-reservations').addClass('active')
    </script>
@endsection