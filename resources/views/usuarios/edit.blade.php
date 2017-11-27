@extends('template.pages.main')

@section('title')
    Editar Usuario
@endsection


@section('name_aplication')
    <h1>
        Editar 
        <small> {{$usuario->nom_usua}}</small>
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

	{!! Form::open(['route' => ['usuarios.update', $usuario], 'method' => 'PUT'])!!}

	<div class='form-group'>
		{!! Form::label('nom_usua', 'Nombre')!!}
		{!! Form::text('nom_usua', $usuario->nom_usua, ['class' => 'form-control' , 'placeholder' => 'Nombre Usuario', 'required'])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('con_usua', 'Contraseña')!!}
		{!! Form::password('con_usua', ['class' => 'form-control' , 'placeholder' => '*******', 'required'])!!}
	</div>

	<div id="cursos" class='form-group' >
		{!! Form::label('ind_esta', 'Estado')!!}
		{!! Form::select('ind_esta', ['A'=>'Activado', 'D'=>'Desactivado'] , $usuario->ind_esta, ['class' => 'form-control', 'placeholder' => 'Seleccione una opcion', 'required'])!!}
	</div>

		<div class="form-group">
				{!! Form::label('cod_role', 'ROL')!!}
				{!! Form::select('cod_role', ['1'=>'Administrador', '2'=>'Operario', '3'=>'Consulta'] , $usuario->cod_role, ['class' => 'form-control', 'placeholder' => 'Seleccione un rol', 'required'])!!}
     </div>

	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection
