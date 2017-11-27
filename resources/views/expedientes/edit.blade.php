@extends('template.pages.main')

@section('title')
    Editar
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
	<link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Editar Expediente
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

	{!! Form::open(['route' => 'expedientes.actualiza' , 'method' => 'POST'])!!}
	
	<div class="form-group">
     	<label>Tipo Documento</label>
        <select name='tip_docu1' class="form-control select2" style="width: 100%;" required disabled>
            <option value="">Seleccione una opcion</option>
          	<option value="CC" {{$data[0]}}>Cédula de Ciudadanía</option>
			<option value="CE" {{$data[1]}}>Cédula de Extranjería</option>
			<option value="RC" {{$data[2]}}>Registro civil</option>
			<option value="TI" {{$data[3]}}>Tarjeta de identidad</option>
			<option value="NIT" {{$data[4]}}>NIT para personas jurídicas</option> 
        </select>
    </div>



	<div class='form-group'>
		{!! Form::label('num_docu1', 'Numero Documento')!!}
		{!! Form::text('num_docu1', $expe->num_docu, ['class' => 'form-control' , 'placeholder' => '', 'disabled'])!!}
	</div>

	<div class='form-group' >
		{!! Form::label('pri_nomb', 'Primer Nombre')!!}
		{!! Form::text('pri_nomb', $expe->pri_nomb, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>	
	<div class='form-group' >
		{!! Form::label('seg_nomb', 'Segundo Nombre')!!}
		{!! Form::text('seg_nomb', $expe->seg_nomb, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>	
	<div class='form-group' >
		{!! Form::label('pri_apel', 'Primer Apellido')!!}
		{!! Form::text('pri_apel', $expe->pri_apel, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>	
	<div class='form-group' >
		{!! Form::label('seg_apel', 'Segundo Apellido')!!}
		{!! Form::text('seg_apel', $expe->seg_apel, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>
	<input type="text" name="cod_expe" value="{{$expe->cod_expe}}" style= "display:none;">
	<input type="text" name="tip_docu" value="{{$expe->tip_docu}}" style= "display:none;">
	<input type="text" name="num_docu" value="{{$expe->num_docu}}" style= "display:none;">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">	

	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection


@section('js')
	<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
	<script type="text/javascript">
		  $(".select2").select2();
	</script>
@endsection