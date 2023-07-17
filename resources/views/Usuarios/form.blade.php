<div class="form-group">
    {!! Form::label('nombre','Nombre') !!}
    {!! Form::text('nombre',null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('a_paterno','Apellido Paterno') !!}
    {!! Form::text('a_paterno',null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('a_materno','Apellido Materno') !!}
    {!! Form::text('a_materno',null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('curp','CURP') !!}
    {!! Form::text('curp',null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('rfc','RFC') !!}
    {!! Form::text('rfc',null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('correo','Correo') !!}
    {!! Form::text('correo',null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('telefono','Telefono') !!}
    {!! Form::text('telefono',null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('domicilio','Domicilio') !!}
    {!! Form::text('domicilio',null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('contrasena','Contraseña') !!}
    {!! Form::password('contrasena',array('class'=>'form-control')) !!}
</div>
<div class="form-group">
    {!! Form::label('contrasena_confirmar','Confirmar Contraseña') !!}
    {!! Form::password('contrasena_confirmar',array('class'=>'form-control')) !!}
</div>
