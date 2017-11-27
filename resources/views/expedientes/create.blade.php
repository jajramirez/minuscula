@extends('template.pages.main')

@section('title')
    Nuevo 
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
	<link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Crear Expediente
        <small> </small>
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

	{!! Form::open(['route' => 'expedientes.store' , 'method' => 'POST'])!!}
	
	<div class="form-group">
     	<label>Tipo Documento</label>
        <select name='tip_docu' class="form-control select2" style="width: 100%;" required>
            <option value="">Seleccione una opcion</option>
          	<option value="CC">Cédula de Ciudadanía</option>
			<option value="CE">Cédula de Extranjería</option>
			<option value="RC">Registro civil</option>
			<option value="TI">Tarjeta de identidad</option>
			<option value="NIT">NIT para personas jurídicas</option> 
        </select>
    </div>



	<div class='form-group'>
		{!! Form::label('num_docu', 'Numero Documento')!!}
		{!! Form::text('num_docu', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

	<div class='form-group' >
		{!! Form::label('pri_nomb', 'Primer Nombre')!!}
		{!! Form::text('pri_nomb', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>	
	<div class='form-group' >
		{!! Form::label('seg_nomb', 'Segundo Nombre')!!}
		{!! Form::text('seg_nomb', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>	
	<div class='form-group' >
		{!! Form::label('pri_apel', 'Primer Apellido')!!}
		{!! Form::text('pri_apel', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>	
	<div class='form-group' >
		{!! Form::label('seg_apel', 'Segundo Apellido')!!}
		{!! Form::text('seg_apel', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>	

	<div class='form-group'> 
		{!! Form::submit('Registrar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection


@section('js')
	<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
	<script type="text/javascript">
		  $(".select2").select2();
	</script>
@endsection