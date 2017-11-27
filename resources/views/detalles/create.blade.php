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

{!! Form::open(['route' => 'detalle.store' , 'method' => 'POST'])!!}

	<div class="form-group">
        <label>Código Serie</label>
        <select name='cod_seri' class="form-control select2" style="width: 100%;" required>
        	<option value="">Seleccione una opcion</option>
           	@foreach($series as $seri)
				<option value="{{$seri->cod_seri}}">{{$seri->nom_seri}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
     	<label>Organizacion</label>
        <select name='cod_orga' class="form-control select2" style="width: 100%;" required>
        	<option value="">Seleccione una opcion</option>
          	@foreach($orgas as $orga)
				<option value="{{$orga->cod_orga}}">{{$orga->nom_orga}}</option>
            @endforeach
        </select>
    </div>
	
	<div class='form-group'>
		{!! Form::label('cod_subs', 'Sub Serie')!!}
		{!! Form::text('cod_subs', null, ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}
	</div>


	<div class='form-group'>
		{!! Form::label('nom_moda', 'Modalidad')!!}
		{!! Form::text('nom_moda', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('nom_prog', 'Programa academico')!!}
		{!! Form::text('nom_prog', null, ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}
	</div>

		<div class='form-group'>
		{!! Form::label('fec_ingr', 'Fecha Ingreso')!!}
		{!! Form::text('fec_ingr', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

		<div class='form-group'>
		{!! Form::label('anh_fina', 'Año Finalizacion')!!}
		{!! Form::text('anh_fina', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>


	<div class='form-group'>
		{!! Form::label('tip_nivel', 'Nivel')!!}
		{!! Form::text('tip_nivel', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('obs_gene', 'Obseraciones')!!}
		{!! Form::text('obs_gene', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>


	<div class='form-group'> 
		{!! Form::submit('Registrar',['class' => 'btn btn-primary'] )!!}
	</div>

	<input type="text" name="cod_expe" value="{{$cod_expe}}" style="display:none">
	{!! Form::close() !!}

@endsection

@section('js')
	<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
	<script type="text/javascript">
		  $(".select2").select2();
	</script>
@endsection