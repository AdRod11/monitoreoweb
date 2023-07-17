<div class="form-group">
    {!! Form::label('name','Nombre') !!}
    {!! Form::text('nombre',null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('description','Descripción') !!}
    {!! Form::text('descripcion',null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('tipo_servicio','Tipo Servicio') !!}
    {!! Form::select('id_tipo_servicio', $tipo_servicio,null,['class'=>'form-control']) !!}
</div>
