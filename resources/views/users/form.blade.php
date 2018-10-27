<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Nombre', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        @if(isset($user))
            {!! Form::text('name', $user->name, ['class' => 'form-control', 'required' => 'required']) !!}        
        @else        
            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
        @endif
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('lastname') ? 'has-error' : ''}}">
    {!! Form::label('lastname', 'Apellido', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        @if(isset($user))
            {!! Form::text('lastname', $user->lastname, ['class' => 'form-control', 'required' => 'required']) !!}        
        @else        
            {!! Form::text('lastname', null, ['class' => 'form-control', 'required' => 'required']) !!}
        @endif
        {!! $errors->first('lastname', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', 'Correo', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        @if(isset($user))
            {!! Form::email('email', $user->email, ['class' => 'form-control', 'required' => 'required']) !!}        
        @else        
            {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
        @endif
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Crear', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
