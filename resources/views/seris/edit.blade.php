@extends('template.pages.main')

@section('title')
    Editar Serie
@endsection


@section('name_aplication')
    <h1>
        Editar Serie 
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
	{!! Form::open(['route' => 'seris.actualizar' , 'method' => 'POST'])!!}


	<div class='form-group'>
		{!! Form::label('cod_seri2', 'Código')!!}
		{!! Form::text('cod_seri', $seri->cod_seri, ['class' => 'form-control' , 'placeholder' => '', 'required', 'disabled'])!!}
	</div>

	<input type="text" name="cod_enti" value="{{$seri->cod_enti}}" style="display:none"> 
	<input type="text" name="cod_seri" value="{{$seri->cod_seri}}" style="display:none"> 


	<div class='form-group'>
		{!! Form::label('nom_seri', 'Nombre')!!}
		{!! Form::text('nom_seri', $seri->nom_seri, ['class' => 'form-control' , 'placeholder' => '', 'required', 
		'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 
		'title'=>'El campo no puede estar en blanco'])!!}

		
	</div>



	<div id="cursos" class='form-group' >
		{!! Form::label('ind_esta', 'Estado')!!}
		{!! Form::select('ind_esta', ['A'=>'Activado', 'D'=>'Desactivado'] , $seri->ind_esta, ['class' => 'form-control', 'placeholder' => 'Seleccione una opcion', 'required'])!!}
	</div>	

	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection
