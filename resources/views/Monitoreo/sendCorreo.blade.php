<div class="form-group">
    {!! Form::label('mensaje','Mensaje') !!}
    {!! Form::textarea('mensaje',null,['class'=>'form-control']) !!}
</div>
<input type="hidden" value="{{ $dispositivo[0]->disNombre }}" name="disNombre">
