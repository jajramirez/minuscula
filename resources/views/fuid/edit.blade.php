@extends('template.pages.main')

@section('title')
    Editar FUID
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Editar FUID
        <small> </small>
    </h1>
@endsection


@section('content')

<div class="row">
    <div class="col-xs-12">
        

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

		{!! Form::open(['route' => 'fuid.actualiza' , 'method' => 'POST'])!!}
			

			<div class="row">
				<div class="col-xs-12">
						<div class='form-group'>
							{!! Form::label('num_regi', 'Número Registro')!!}
							{!! Form::text('num_regi', $fuid->num_regi, ['class' => 'form-control' , 'placeholder' => '', 'disabled'])!!}
						</div>
				</div>

				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('cod_orga', 'Código Estructura')!!}
							{!! Form::text('cod_orga', $fuid->cod_orga, ['class' => 'form-control' , 'placeholder' => '', 'disabled'])!!}
						</div>
				</div>
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('cod_ccd', 'Código CCD')!!}
							{!! Form::text('cod_ccd', $fuid->cod_ccd, ['class' => 'form-control' , 'placeholder' => '', 'disabled'])!!}
						</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class='form-group'>
							{!! Form::label('fec_inic', 'Fecha Inicial')!!}
							
							<div class="input-group date">
		                        <div class="input-group-addon">
		                            <i class="fa fa-calendar"></i>
		                        </div>
		                        <input type="text" value="{{$fuid->fec_inic}}" class="form-control pull-right" id="datepicker" name="fec_inic">
	                    	</div>
					</div>
				</div>
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('fec_fina', 'Fecha Final')!!}
							<div class="input-group date">
		                        <div class="input-group-addon">
		                            <i class="fa fa-calendar"></i>
		                        </div>
		                        <input type="text"value="{{$fuid->fec_fina}}" class="form-control pull-right" id="datepicker2" name="fec_fina">
	                    	</div>
						</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('num_caja', 'Caja')!!}
							{!! Form::text('num_caja', $fuid->num_caja, ['class' => 'form-control'  , 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
						</div>
				</div>
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('num_carp', 'Carpeta')!!}
							{!! Form::text('num_carp', $fuid->num_carp, ['class' => 'form-control' , 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números' ])!!}
						</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('num_tomo', 'Tomo')!!}
							{!! Form::text('num_tomo', $fuid->num_tomo, ['class' => 'form-control' , 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
						</div>
				</div>
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('num_inte', 'Otro')!!}
							{!! Form::text('num_inte', $fuid->num_inte, ['class' => 'form-control', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
						</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('num_foli', 'No. FOLIOS')!!}
							{!! Form::text('num_foli', $fuid->num_foli, ['class' => 'form-control' , 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
						</div>
				</div>
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('gen_sopo', 'Soporte')!!}
							{!! Form::text('gen_sopo', null, ['class' => 'form-control' , 'placeholder' => '' ])!!}
						</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('obs_gen1', 'Notas')!!}
							{!! Form::text('obs_gen1', $fuid->obs_gen1, ['class' => 'form-control' , 'placeholder' => ''])!!}
						</div>
				</div>
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('fre_cons', 'Frecuencia Consulta')!!}
							{!! Form::text('fre_cons', $fuid->fre_cons, ['class' => 'form-control' , 'placeholder' => ''])!!}
						</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('nom_arch', 'Archivo')!!}
							{!! Form::File('nom_arch')!!}
							<input type="text" name='nombrearchivo' value="{{$fuid->nom_arch}}" style="display:none"/>
						</div>
				</div>

				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('nom_asun', 'Asunto')!!}
							{!! Form::text('nom_asun', $fuid->nom_asun, ['class' => 'form-control' , 'placeholder' => ''])!!}
						</div>
				</div>
				
			</div>

				<div class="row">
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('cod_bode', 'Consecutivo Bodega')!!}
							{!! Form::text('cod_bode', $fuid->cod_bode, ['class' => 'form-control' , 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
						</div>
				</div>
				
			</div>



			<input type="text" name="cod_enti" value="{{$fuid->cod_enti}}" style="display:none">
			<input type="text" name="num_regi" value="{{$fuid->num_regi}}" style="display:none">
			<input type="text" name="cod_trd" value="{{$fuid->cod_trd}}" style="display:none">

			<div class="row">
				<div class="col-xs-12">
					<div class='form-group'> 
						{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
					</div>
				</div>
			</div>

		{!! Form::close() !!}

</div>

</div>

@endsection

@section('js')
	<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
	<script src="{{ asset('template/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script>

	$('#datepicker').datepicker({
		autoclose: true
	});
	$('#datepicker2').datepicker({
		autoclose: true
	});
	
	$(".select2").select2();
	</script>
@endsection
