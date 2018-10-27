@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-block">
        <div class="row">
          <div class="col-lg-12 title-page form-group"> 
              <h3 class="card-title">Usuarios</h3>
              <a href="{{ url('/users/create') }}" class="btn btn-primary">Agregar usuario</a>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            @include('layouts.alerts')
            <div class="list-count pull-right font-blue-madison"> 
                {!! Form::open([
                    'method'=>'POST',
                    'url' => ['/users'],
                    'class' => 'form-inline',
                    'role' => 'form'
                    ]) !!}
                    <div class="form-group">
                        <input id="form-search-search-value" type="text" name="UserController_search" class="form-control" value="{{ $data['UserController_search'] }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary search">Buscar</button>
                    </div>
                    <input type="hidden" name="UserController_field" value="{{ $data['UserController_field'] }}">                               
                    <input type="hidden" name="UserController_orderby" value="{{ $data['UserController_orderby'] }}"> 
                {!! Form::close() !!}
            </div>     
            <div class="table-responsive">
              <table class="table m-t-30 table-hover no-wrap contact-list">
                <thead>
                  <tr class="trtitle" style="font-size: 15px">
                    <th> Nombre </th>
                    <th> Apellido </th>
                    <th> Correo </th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @if(sizeof($data['rows']) > 0)
                    @foreach($data['rows'] as $r)
                        <tr>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->lastname }}</td>
                            <td>{{ $r->email }}</td>
                            <td>
                                {!! Form::open([
                                    'method'=>'DELETE',
                                    'url' => ['/users/destroy', $r->id],
                                    'style' => 'display:inline',
                                    'id' => 'form-destroy-'.$r->id,
                                ]) !!}
                                <div class="pull-right btn-group-vertical" role="group">
                                    <a href="{{ url('/users/show/' . $r->id) }}" title="Ver"  class="btn btn-primary btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> Ver</a>
                                    <a href="{{ url('/users/edit/' . $r->id) }}" title="Editar" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a>
                                    {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Borrar', array(
                                            'type' => 'submit',
                                            'class' => 'btn btn-danger btn-xs',
                                            'title' => 'Delete User',
                                            'onclick'=>'return confirm("Confirm delete?")'
                                    )) !!}
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                  @else
                    <tr>
                        <td colspan="4" align="center">No se encontraron registros</td>
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
        $('#menu-users').addClass('active')
    </script>
@endsection