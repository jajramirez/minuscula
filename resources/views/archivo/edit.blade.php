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
        Editar 
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

{!! Form::open(['route' => 'archivo.actualiza' , 'method' => 'POST'])!!}



	<div class='form-group'>
		{!! Form::label('nom_arch', 'Archivo')!!}
		<input type="file" name="nom_arch"  id="nom_arch">
	</div>
	

	<div class='form-group'>
		{!! Form::label('fec_arch', 'Fecha')!!}
		{!! Form::text('fec_arch', $expe->fec_arch, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

		<div class='form-group'>
		{!! Form::label('num_pagi', 'Paginas')!!}
		{!! Form::text('num_pagi', $expe->num_pagi, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

		<div class='form-group'>
		{!! Form::label('num_tama', 'Tamaño (kilobyte)')!!}
		{!! Form::text('num_tama', $expe->num_tama, ['class' => 'form-control' , 'placeholder' => '', 'disabled', 'id'=>'num_tama'])!!}
	</div>


	<div class='form-group'>
		{!! Form::label('nom_soft', 'Software')!!}
		{!! Form::text('nom_soft', $expe->nom_soft, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('nom_vers', 'Versión')!!}
		{!! Form::text('nom_vers', $expe->nom_vers, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('nom_reso', 'Resolución')!!}
		{!! Form::text('nom_reso', $expe->nom_reso, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('nom_idio', 'Idiomas')!!}
		{!! Form::text('nom_idio', $expe->nom_idio, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>
	<input type="text" name="cod_expe" value="{{$expe->cod_expe}}" style="display:none">
	<input type="text" name="num_regi" value="{{$expe->num_regi}}" style="display:none">
	<input type="text" name="num_arch" value="{{$expe->num_arch}}" style="display:none">
	<input type="text" name="nom_arch" value="{{$expe->nom_arch}}" style="display:none">
	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
	</div>


	
	
	{!! Form::close() !!}

@endsection
