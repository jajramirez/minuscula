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
        Crear 
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

{!! Form::open(['route' => 'archivo.store' , 'method' => 'POST', 'files'=>true]) !!}

	<div class='form-group'>
		{!! Form::label('nom_arch', 'Archivo')!!}
		<input type="file" name="nom_arch" required id="nom_arch">
	</div>
	

	<div class='form-group'>
		<div class='form-group'>
			<label>Fecha</label>
			<div class="input-group date">
	            <div class="input-group-addon">
	                <i class="fa fa-calendar"></i>
	            </div>
	            <input type="text" class="form-control pull-right" id="datepicker" name="fec_arch">
          	</div>
				
		</div>
	</div>

	<div class='form-group'>
		{!! Form::label('num_pagi', 'Paginas')!!}
		{!! Form::text('num_pagi', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
	</div>

		<div class='form-group'>
		{!! Form::label('num_tama', 'Tamaño (kilobyte)')!!}
		{!! Form::text('num_tama', null, ['class' => 'form-control' , 'placeholder' => '', 'disabled', 'id'=>'num_tama'])!!}
	</div>


	<div class='form-group'>
		{!! Form::label('nom_soft', 'Software')!!}
		{!! Form::text('nom_soft', null, ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('nom_vers', 'Versión')!!}
		{!! Form::text('nom_vers', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('nom_reso', 'Resolución')!!}
		{!! Form::text('nom_reso', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('nom_idio', 'Idiomas')!!}
		{!! Form::text('nom_idio', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>


	<div class='form-group'> 
		{!! Form::submit('Registrar',['class' => 'btn btn-primary'] )!!}
	</div>

	<input type="text" name="cod_expe" value="{{$cod_expe}}" style="display:none">
	<input type="text" name="num_regi" value="{{$num_regi}}" style="display:none">
	
	{!! Form::close() !!}

@endsection

@section('js')
	<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
		<script src="{{ asset('template/plugins/datepicker/bootstrap-datepicker.js')}}"></script>



	<script type="text/javascript">

				$('#datepicker').datepicker({
		autoclose: true
	});




		  $(".select2").select2();
		 $('#nom_arch').change(function (){
	     var sizeByte = this.files[0].size;
	     var siezekiloByte = parseInt(sizeByte / 1024);
	     $("#num_tama").val(siezekiloByte);
	     
	 	});
	</script>
@endsection