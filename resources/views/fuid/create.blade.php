@extends('template.pages.main')

@section('title')
    Nuevo FUID
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Crear FUID
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
	{!! Form::open(['route' => 'fuid.store' , 'method' => 'POST'])!!}
		<div class="row">
			<div class="col-xs-6">
				<div class="form-group">
			     	<label>Codigo Estructura</label>
			        <select name='cod_orga' class="form-control select2" style="width: 100%;" required>
			        	<option value="">Seleccione una Oficina Productora</option>
			          	@foreach($orgas as $orga)
							<option value="{{$orga->cod_orga}}">{{$orga->nom_orga}}</option>
			            @endforeach
			        </select>
			    </div>
			</div>

			<div class="col-xs-6">
				<div class="form-group">
			     	<label>Codigo CCD</label>
			     	<div class="row">
			     		<div class="col-xs-6">
					        <select id="cod_seri" name='cod_seri' class="form-control select2" style="width: 100%;" required onchange="cargarSubs()">>
					        	<option value="">Seleccione una serie</option>
					          	@foreach($seris as $seri)
									<option value="{{$seri->cod_seri}}">{{$seri->nom_seri}}</option>
					            @endforeach
					        </select>
				    	</div>
						<div class="col-xs-6">
					        <select id="cod_subs" name='cod_subs' class="form-control select2" style="width: 100%;" >
					        	<option value="">Seleccione una subserie</option>
					          	<!--@foreach($ccds as $ccd)
									<option value="{{$ccd->cod_subs}}">{{$ccd->nom_subs}}</option>
					            @endforeach
					        	-->
					        </select>
				    	</div>
				       </div>

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
	                        <input type="text" class="form-control pull-right" id="datepicker" name="fec_inic">
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
	                        <input type="text" class="form-control pull-right" id="datepicker2" name="fec_fina">
                    	</div>
					</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('num_caja', 'Caja')!!}
						{!! Form::text('num_caja', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
					</div>
			</div>
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('num_carp', 'Carpeta')!!}
						{!! Form::text('num_carp', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
					</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('num_tomo', 'Tomo')!!}
						{!! Form::text('num_tomo', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
					</div>
			</div>
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('num_inte', 'Otro')!!}
						{!! Form::text('num_inte', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
					</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('num_foli', 'No. FOLIOS')!!}
						{!! Form::text('num_foli', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
					</div>
			</div>
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('gen_sopo', 'Soporte')!!}
						{!! Form::text('gen_sopo', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
					</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('obs_gen1', 'Notas')!!}
						{!! Form::text('obs_gen1', null, ['class' => 'form-control' , 'placeholder' => '' ])!!}
					</div>
			</div>
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('fre_cons', 'Frecuencia Consulta')!!}
						{!! Form::text('fre_cons', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
					</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('nom_arch', 'Archivo')!!}
						{!! Form::File('nom_arch')!!}
					</div>
			</div>

			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('nom_asun', 'Asunto')!!}
						{!! Form::text('nom_asun', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
					</div>
			</div>
			
		</div>

		<div class="row">
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('cod_bode', 'Consecutivo Bodega')!!}
						{!! Form::text('cod_bode', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
					</div>
			</div>
			
		</div>


		<input type="text" name="busqueda" value="{{$busqueda}}" style="display:none">


	<div class="row">
		<div class="col-xs-12">
			<div class='form-group'> 
				{!! Form::submit('Registrar',['class' => 'btn btn-primary'] )!!}
			</div>
		</div>
	</div>

	{!! Form::close() !!}


@endsection

@section('js')
	<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
	<script src="{{ asset('template/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script>

	
	 $('#nom_arch').change(function (){
     var sizeByte = this.files[0].size;
     var siezekiloByte = parseInt(sizeByte / 1024);
     $("#num_tama").val(siezekiloByte);
     $("#num_tama2").val(siezekiloByte);
     
 	});

	$('#datepicker').datepicker({
		autoclose: true
	});
	$('#datepicker2').datepicker({
		autoclose: true
	});
	
	$(".select2").select2();


	function cargarSubs()
	{
		var cod_seri = $("#cod_seri").val();
		var PostUri = "{{ route('seris.buscarccd')}}"; 

		$.ajax({
		    url: PostUri,
		    type: 'post',
		    data: {
		        cod_seri: cod_seri
		    },
		    headers: {
		        'X-CSRF-TOKEN': "{{ Session::token() }}", //for object property name, use quoted notation shown in second
		    },
		    success: function (data) {
		    	var comilla = '"';
			    if(data != "<option value="+comilla+comilla+">Seleccione una subserie</option>")
			    {
			    	$("#cod_subs").attr('required', 'required');
			    }
			    else
			    {
			    	$("#cod_subs").removeAttr('required');
			    }

		        $("#cod_subs").html(data);
		    }
		});

	}




	</script>
@endsection
