<div class="form-group @if($errors->has('reservation_date')) has-error @endif">
    {!! Form::label('reservation_date', 'Fecha Evento', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <div class="input-group date">
        @if(isset($reservation))
            {!! Form::text('reservation_date', date_format(date_create($reservation->reservation_date), 'd/m/Y'), ['class' => 'form-control', 'required' => 'required', 'readonly' => 'true']) !!}        
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>        
        @else 
            {!! Form::text('reservation_date', null, ['class' => 'form-control datepicker', 'required' => 'required', 'readonly' => 'true' ]) !!}
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
        @endif
        </div>
        @if ($errors->has('reservation_date'))
            @foreach ($errors->get('reservation_date') as $error)
                <span id="reservation_date" class="help-block">{{ $error }}</span>
            @endforeach
        @endif
    </div>
</div>

<div class="form-group {{ $errors->has('numbers_people') ? 'has-error' : ''}}">
    {!! Form::label('numbers_people', 'Número de puestos', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        @if(isset($reservation))
            {!! Form::number('numbers_people', $reservation->numbers_people, ['class' => 'form-control', 'required' => 'required']) !!}        
        @else        
            {!! Form::number('numbers_people', null, ['class' => 'form-control', 'required' => 'required']) !!}
        @endif
        {!! $errors->first('numbers_people', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('row') ? 'has-error' : ''}}">
    {!! Form::label('row', 'Cantidad de filas', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        @if(isset($reservation))
            {!! Form::number('row', $reservation->row, ['class' => 'form-control', 'required' => 'required']) !!}        
        @else        
            {!! Form::number('row', null, ['class' => 'form-control', 'required' => 'required']) !!}
        @endif
        {!! $errors->first('row', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('column') ? 'has-error' : ''}}">
    {!! Form::label('column', 'Cantidad de columnas', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        @if(isset($reservation))
            {!! Form::number('column', $reservation->column, ['class' => 'form-control', 'required' => 'required']) !!}        
        @else        
            {!! Form::number('column', null, ['class' => 'form-control', 'required' => 'required']) !!}
        @endif
        {!! $errors->first('column', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Crear', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
