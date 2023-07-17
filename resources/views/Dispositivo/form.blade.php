<div class="form-group">
    {!! Form::label('nombre','Nombre') !!}
    {!! Form::text('nombre',null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('ip','Dirección IP') !!}
    <div class="input-group">
        {!! Form::text('ip',null,['class'=>'form-control']) !!}
        <span class ='input-group-btn'> <button type="button" id="ping" class ="btn btn-primary">PING</button> </span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('mac','Dirección MAC') !!}
    {!! Form::text('mac',null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('grupo', 'Grupo') !!}
    {!! Form::select('id_grupo',$grupos, null,['class' => 'form-control' , 'required' => 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('sistema', 'Sistema Operativo') !!}
    {!! Form::select('id_sistema',$sistemas, null,['class' => 'form-control' , 'required' => 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('ubicacion', 'Ubicación') !!}
    {!! Form::select('id_ubicacion',$ubicaciones,null, ['class' => 'form-control' , 'required' => 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('categoria','Categoria') !!}
    {!! Form::select('id_categoria',$categorias, null,['class' => 'form-control' , 'required' => 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('periodo','Periodo') !!}
    {!! Form::select('id_periodo',$periodos,null, ['class' => 'form-control' , 'required' => 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('consulta','Consulta(Lo puede ver el rol de consulta)') !!}
    @if(@isset($dispositivo))
        {!! Form::checkbox('consulta',$dispositivo->consulta, ['class' => 'form-control' , 'required' => 'required']) !!}
    @else
        {!! Form::checkbox('consulta',null, ['class' => 'form-control' , 'required' => 'required']) !!}
    @endif
</div>
