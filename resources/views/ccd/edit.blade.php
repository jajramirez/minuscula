@extends('template.pages.main')

@section('title')
    Editar CCD
@endsection


@section('name_aplication')
    <h1>
        Editar CCD 
    </h1>
@endsection


@section('content')
@if(count($errors) >0)
	<div class="alert alert-danger" role="alert">
		<ul>
			@foreach($errors->all() as $error)
				<li>
					{{ $error}}
				</li>
			@endforeach
		</ul>
	</div>
@endif
	{!! Form::open(['route' => 'ccd.actualizar' , 'method' => 'POST'])!!}
	
	<div class="form-group">
     	   <label>Código Serie</label>
            <select name='cod_seri' class="form-control select2" style="width: 100%;" required>
              	@foreach($seris as $seri)
              		@if($ccd->cod_seri == $seri->cod_seri)
						<option value="{{$seri->cod_seri}}" selected="selected">{{$seri->nom_seri}}</option>
					@else
						<option value="{{$seri->cod_seri}}">{{$seri->nom_seri}}</option>
              		@endif
					
                @endforeach
            </select>
    </div>

	<input type="text" name="cod_enti" value="{{$ccd->cod_enti}}" style="display:none"> 
	<input type="text" name="num_regi" value="{{$ccd->num_regi}}" style="display:none"> 

	<div class='form-group'>
		{!! Form::label('cod_subs', 'Subserie')!!}
		{!! Form::text('cod_subs', $ccd->cod_subs, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('nom_subs', 'Nombre')!!}
		{!! Form::text('nom_subs', $ccd->nom_subs, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 'title'=>'El campo no puede estar en blanco'])!!}
	</div>

	<div id="cursos" class='form-group' >
		{!! Form::label('ind_esta', 'Estado')!!}
		{!! Form::select('ind_esta', ['A'=>'Activado', 'D'=>'Desactivado'] , $ccd->ind_esta, ['class' => 'form-control', 'placeholder' => 'Seleccione una opcion', 'required'])!!}
	</div>	

	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection
