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

{!! Form::open(['route' => 'detalle.actualiza' , 'method' => 'POST'])!!}

	<div class="form-group">
        <label>Código Serie</label>
        <select name='cod_seri' class="form-control select2" style="width: 100%;" required>
        	<option value="">Seleccione una opcion</option>
           	@foreach($series as $seri)
           		@if($seri->cod_seri == $expe->cod_tipo)
					<option value="{{$seri->cod_seri}}" selected>{{$seri->nom_seri}}</option>
				@else
					<option value="{{$seri->cod_seri}}">{{$seri->nom_seri}}</option>
				@endif
            @endforeach
        </select>
    </div>

    <div class="form-group">
     	<label>Organizacion</label>
        <select name='cod_orga' class="form-control select2" style="width: 100%;" required>
        	<option value="">Seleccione una opcion</option>
          	@foreach($orgas as $orga)
          		@if($orga->cod_orga == $expe->cod_orga)
					<option value="{{$orga->cod_orga}}" selected>{{$orga->nom_orga}}</option>
				@else
					<option value="{{$orga->cod_orga}}">{{$orga->nom_orga}}</option>
				@endif
            @endforeach
        </select>
    </div>
	
	<div class='form-group'>
		{!! Form::label('cod_subs', 'Sub Serie')!!}
		{!! Form::text('cod_subs', $expe->cod_subs, ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('nom_moda', 'Modalidad')!!}
		{!! Form::text('nom_moda', $expe->nom_moda, ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('nom_prog', 'Programa academico')!!}
		{!! Form::text('nom_prog', $expe->nom_prog, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

		<div class='form-group'>
		{!! Form::label('fec_ingr', 'Fecha Ingreso')!!}
		{!! Form::text('fec_ingr', $expe->fec_ingr, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

		<div class='form-group'>
		{!! Form::label('anh_fina', 'Año Finalizacion')!!}
		{!! Form::text('anh_fina', $expe->anh_fina, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>


	<div class='form-group'>
		{!! Form::label('tip_nivel', 'Nivel')!!}
		{!! Form::text('tip_nivel', $expe->tip_nivel, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('obs_gene', 'Obseraciones')!!}
		{!! Form::text('obs_gene', $expe->obs_gene, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

	<input type="text" name="cod_expe" value="{{$expe->cod_expe}}" style="display:none">
	<input type="text" name="num_regi" value="{{$expe->num_regi}}" style="display:none">

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