@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-block">
        <div class="row">
          <div class="col-lg-12 title-page form-group"> 
              <h3 class="card-title">Editar Usuario</h3>
          </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <a href="{{ url('/users') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                <br />
                <br />

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                {!! Form::model($user, [
                    'method' => 'PUT',
                    'url' => ['/users/update', $user->id],
                    'class' => 'form-horizontal',
                    'files' => true
                ]) !!}

                @include ('users.form')

                {!! Form::close() !!}
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
