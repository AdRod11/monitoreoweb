<div class="form-group row">
    <label for="staticEmail" class="col-sm-3 col-form-label">
        {!! Form::label('nombre','Nombre') !!}
    </label>
    <div class="col-sm-9">
        {!! Form::text('nombre',null,['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group row">
    <label for="staticEmail" class="col-sm-3 col-form-label">
        {!! Form::label('a_paterno','Apellido Paterno') !!}
    </label>
    <div class="col-sm-9">
        {!! Form::text('a_paterno',null,['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group row">
    <label for="staticEmail" class="col-sm-3 col-form-label">
        {!! Form::label('a_materno','Apellido Materno') !!}
    </label>
    <div class="col-sm-9">
        {!! Form::text('a_materno',null,['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group row">
    <label for="staticEmail" class="col-sm-3 col-form-label">
        {!! Form::label('curp','Curp') !!}
    </label>
    <div class="col-sm-9">
        {!! Form::text('curp',null,['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group row">
    <label for="staticEmail" class="col-sm-3 col-form-label">
        {!! Form::label('rfc','RFC') !!}
    </label>
    <div class="col-sm-9">
        {!! Form::text('rfc',null,['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group row">
    <label for="staticEmail" class="col-sm-3 col-form-label">
        {!! Form::label('correo','Correo') !!}
    </label>
    <div class="col-sm-9">
        {!! Form::text('correo',null,['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group row">
    <label for="staticEmail" class="col-sm-3 col-form-label">
        {!! Form::label('telefono','Telefono') !!}
    </label>
    <div class="col-sm-9">
        {!! Form::text('telefono',null,['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group row">
    <label for="staticEmail" class="col-sm-3 col-form-label">
        {!! Form::label('domicilio','Domicilio') !!}
    </label>
    <div class="col-sm-9">
        {!! Form::text('domicilio',null,['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group row">
    <label for="staticEmail" class="col-sm-3 col-form-label">
        {!! Form::label('contrasena','Contraseña') !!}
    </label>
    <div class="col-sm-9">
        {!! Form::password('contrasena',array('class'=>'form-control')) !!}
    </div>
</div>
<div class="form-group row">
    <label for="staticEmail" class="col-sm-3 col-form-label">
        {!! Form::label('contrasena_confirmar','Confirmar Contraseña') !!}
    </label>
    <div class="col-sm-9">
        {!! Form::password('contrasena_confirmar',array('class'=>'form-control')) !!}
    </div>
</div>

