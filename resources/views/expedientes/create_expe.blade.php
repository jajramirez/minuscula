@extends('template.pages.main')

@section('title')
    Nuevo Expediente
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

	{!! Form::open(['route' => 'expedientes.store' , 'method' => 'POST', 'files'=>true]) !!}


	 <div class="col-md-12">

          <div class="box box-info">
            <div class="box-header">
              
            </div>
            <div class="box-body">

            	<div class='form-group col-md-12'>
					{!! Form::label('TRD', 'Código TRD')!!}
					{!! Form::text('TRD', null, ['class' => 'form-control' , 'placeholder' => '', 'disabled', 'id' => 'TRD'])!!}
				
				</div>


            	<div class="form-group col-md-4">
			     	<label>Oficina Productora</label>
			        <select id='cod_orga' name='cod_orga' class="form-control select2" style="width: 100%;" required onchange="codigoTRD()">
			        	<option value="">Seleccione una opcion</option>
			          	@foreach($orgas as $orga)
							<option value="{{$orga->cod_orga}}">{{$orga->nom_orga}}</option>
			            @endforeach
			        </select>
			    </div>
				

              	<div class="form-group col-md-4">
			        <label>Código Serie</label>
			        <select name='cod_seri' id='cod_seri' class="form-control select2" style="width: 100%;" required onchange="cargarSubs()">
			        	<option value="">Seleccione una opcion</option>
			           	@foreach($series as $seri)
							<option value="{{$seri->cod_seri}}">{{$seri->nom_seri}}</option>
			            @endforeach
			        </select>
			    </div>

			    
				<div class='form-group col-md-4'>
					{!! Form::label('cod_subs', 'Sub Serie')!!}
					<select id="cod_subs" name='cod_subs' class="form-control select2" style="width: 100%;" onchange="codigoTRD()">
					        <option value="">Seleccione una subserie</option>
					</select>
				</div>


				<div class='form-group col-md-4'>
					<label id="met8">Modalidad</label>
					{!! Form::text('nom_moda', null, ['class' => 'form-control' , 'placeholder' => '' , 'id' => 'text8'])!!}
				</div>

				<div class='form-group col-md-4'>
					<label id="met7">Programa Académico</label>
					{!! Form::text('nom_prog', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 'title'=>'El campo no puede estar en blanco', 'id'=>'nom_prog'])!!}
				</div>

					<div class='form-group col-md-4'>
					<label id="met10">Fecha Ingreso</label>
						<div class="input-group date">
	                        <div class="input-group-addon">
	                            <i class="fa fa-calendar"></i>
	                        </div>
	                        <input id="text10" type="text" class="form-control pull-right" id="datepicker" name="fec_ingr">
                    	</div>
				
				</div>

					<div class='form-group col-md-4'>
					<label id="met11">Año Finalizacion</label>
					{!! Form::text('anh_fina', null, ['class' => 'form-control' , 'placeholder' => '', 'maxlength'=>'4','pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números', 'id' => 'text11' ])!!}
				</div>


				<div class='form-group col-md-4'>
					<label id="met9">Nivel</label>
					{!! Form::text('tip_nivel', null, ['class' => 'form-control' , 'placeholder' => '' , 'id' => 'text9'])!!}
				</div>

				<div class='form-group col-md-4'>
					{!! Form::label('obs_gene', 'Obseraciones')!!}
					{!! Form::text('obs_gene', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
				</div>
            </div>
 
          </div>

        </div>


	



	<div class="row">
       
		<div class="col-md-6">
			<div class="box box-default">
        <div class="box-header with-border">    
          <div class="box-tools pull-right">
           <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>-->
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
             
				<div class="form-group">
			     	<label id="met2">Tipo Documento</label>
			        <select id="tip_docu" name='tip_docu' class="form-control select2" style="width: 100%;" required>
			            <option value="">Seleccione una opcion</option>
			          	<option value="CC">Cédula de Ciudadanía</option>
						<option value="CE">Cédula de Extranjería</option>
						<option value="RC">Registro civil</option>
						<option value="TI">Tarjeta de identidad</option>
						<option value="NIT">NIT para personas jurídicas</option> 
			        </select>
			    </div>

				<div class='form-group'>
					<label id="met1"> Número Documento</label>

					{!! Form::text('num_docu', null, ['class' => 'form-control' , 'placeholder' => '', 'required' ,'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números', 'id' => 'text1'])!!}
				</div>

				<div class='form-group' >
					
					<label id="met3">Primer Nombre</label>
					{!! Form::text('pri_nomb', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 'title'=>'El campo no puede estar en blanco', 'id' => 'text3'])!!}
				</div>

            </div>
            <!-- /.col -->
            <div class="col-md-12">

            	<div class='form-group' >
					<label id="met4">Segundo Nombre</label>
					{!! Form::text('seg_nomb', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 'title'=>'El campo no puede estar en blanco', 'id' => 'text4'])!!}
				</div>	
				<div class='form-group' >
					<label id="met5">Primer Apellido</label>
					{!! Form::text('pri_apel', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 'title'=>'El campo no puede estar en blanco' , 'id' => 'text5'])!!}
				</div>	
				<div class='form-group' >
					<label id="met6">Segundo Apellido</label>
					{!! Form::text('seg_apel', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 'title'=>'El campo no puede estar en blanco', 'id' => 'text6'])!!}
				</div>	

            </div>

          </div>

        </div>

        <div class="box-footer">
        
        </div>
      </div>
		</div>
         <div class="col-md-6">

          <div class="box box-info">
            <div class="box-header">
              
            </div>
            <div class="box-body">
             		<div class='form-group'>
						{!! Form::label('nom_arch', 'Archivo')!!}
						{!! Form::File('nom_arch', null, ['required', 'id'=> 'nom_arch'])!!}
					</div>
				<div class='form-group'>
					{!! Form::label('fec_arch', 'Fecha Creación del Archivo')!!}
							<div class="input-group date">
	                        <div class="input-group-addon">
	                            <i class="fa fa-calendar"></i>
	                        </div>
	                        <input type="text" class="form-control pull-right" id="datepicker2" name="fec_arch">
                    	</div>
				</div>

					<div class='form-group'>
					{!! Form::label('num_pagi', 'Paginas')!!}
					{!! Form::text('num_pagi', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
				</div>

					<div class='form-group'>
					{!! Form::label('num_tama', 'Tamaño (kilobyte)')!!}
					{!! Form::text('num_tama2', null, ['class' => 'form-control' , 'placeholder' => '', 'id'=>'num_tama2', 'disabled'])!!}
					<input type="text" name="num_tama" id="num_tama" style="display:none">
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
					{!! Form::label('nom_idio', 'Idioma')!!}
					{!! Form::text('nom_idio', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
				</div>

            </div>
            
          </div>

        </div>

        
      </div>


	
	
	

	<div class='form-group'> 
		{!! Form::submit('Registrar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection


@section('js')
	<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
		<script src="{{ asset('template/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
	<script type="text/javascript">

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
			codigoTRD();
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




	function codigoTRD()
	{

		var oficina = $("#cod_orga").val();
		var cod_seri = $("#cod_seri").val();
		if(cod_seri.length > 	0)
		{
			cod_seri = '.'+$("#cod_seri").val();
			
		}	
		
		var cod_subs = $("#cod_subs").val();
		if(cod_subs.length > 0)
		{
			cod_subs = '.'+$("#cod_subs").val();
			
		}	
		encabezados();
		var trd = oficina+cod_seri+cod_subs;
		$("#TRD").val(trd);
	}

	function encabezados()
		{
			var cod_seri = $("#cod_seri").val();
			var cod_subs = $("#cod_subs").val();
			var PostUri = "{{ route('expedientes.buscarencabezado')}}"; 

			$.ajax({
			    url: PostUri,
			    type: 'post',
			    data: {
			        cod_seri: cod_seri,
			        cod_subs: cod_subs
			    },
			    headers: {
			        'X-CSRF-TOKEN': "{{ Session::token() }}", //for object property name, use quoted notation shown in second
			    },
			    success: function (data) {
			    	if(data != 'null')
			    	{
			    		var labeltexto = JSON.parse(data);

			    		$("#met1").html(labeltexto.met1);
			    		if(labeltexto.met1 == null)
			    		{
			    		
			    			$("#text1").prop( "disabled", true );
			    		}
			    		else
			    		{
			    			$("#text1").prop( "disabled", false );
			    		}
			    		$("#met2").html(labeltexto.met2);
			    		
			    		if(labeltexto.met2 == null)
			    		{
			    		
			    			$("#tip_docu").prop( "disabled", true );
			    		}
			    		else
			    		{
			    			$("#tip_docu").prop( "disabled", false );
			    		}
			    		$("#met3").html(labeltexto.met3);
			    			if(labeltexto.met3 == null)
				    		{
				    		
				    			$("#text3").prop( "disabled", true );
				    		}
				    		else
				    		{
				    			$("#text3").prop( "disabled", false );
				    		}
				    	$("#met4").html(labeltexto.met4);
				    	if(labeltexto.met4 == null)
				    		{
				    		
				    			$("#text4").prop( "disabled", true );
				    		}
				    		else
				    		{
				    			$("#text4").prop( "disabled", false );
				    		}
			    		$("#met5").html(labeltexto.met5);
			    		if(labeltexto.met5 == null)
				    		{
				    		
				    			$("#text5").prop( "disabled", true );
				    		}
				    		else
				    		{
				    			$("#text5").prop( "disabled", false );
				    		}
			    		$("#met6").html(labeltexto.met6);
			    		if(labeltexto.met6 == null)
				    		{
				    		
				    			$("#text6").prop( "disabled", true );
				    		}
				    		else
				    		{
				    			$("#text6").prop( "disabled", false );
				    		}
			    		$("#met7").html(labeltexto.met7);
				    		if(labeltexto.met7 == null)
					    		{
					    		
					    			$("#nom_prog").prop( "disabled", true );
					    		}
					    		else
					    		{
					    			$("#nom_prog").prop( "disabled", false );
					    		}

			    		$("#met8").html(labeltexto.met8);
			    			if(labeltexto.met8 == null)
				    		{
				    		
				    			$("#text8").prop( "disabled", true );
				    		}
				    		else
				    		{
				    			$("#text8").prop( "disabled", false );
				    		}

			    		$("#met9").html(labeltexto.met9);
			    			if(labeltexto.met9 == null)
				    		{
				    		
				    			$("#text9").prop( "disabled", true );
				    		}
				    		else
				    		{
				    			$("#text9").prop( "disabled", false );
				    		}
			    		$("#met10").html(labeltexto.met10);
			    			if(labeltexto.met10 == null)
				    		{
				    		
				    			$("#text10").prop( "disabled", true );
				    		}
				    		else
				    		{
				    			$("#text10").prop( "disabled", false );
				    		}
			    		$("#met11").html(labeltexto.met11);
			    			if(labeltexto.met11 == null)
				    		{
				    		
				    			$("#text11").prop( "disabled", true );
				    		}
				    		else
				    		{
				    			$("#text11").prop( "disabled", false );
				    		}
			    		
			    		
			    		$("#tip_docu").removeAttr('required');
			    		$("#nom_prog").removeAttr('required');
			    	}
			    	else
			    	{
			    		$("#met1").html("Número Documento");
			    		$("#met2").html("Tipo Documento");
			    		$("#met3").html("Primer Nombre");
			    		$("#met4").html("Segundo Nombre");
			    		$("#met5").html("Primer Apellido");
			    		$("#met6").html("Segundo Apellido");
			    		$("#met7").html("Programa Académico");
			    		$("#met8").html("Modalidad");
			    		$("#met9").html("Nivel");
			    		$("#met10").html("Fecha Ingreso");
			    		$("#met11").html("Año Finalizacion");
			    		//2
			    		$("#tip_docu").attr('required', 'required');
			    		//7
			    		$("#nom_prog").attr('required', 'required');

			    		$("#tip_docu").prop( "disabled", false );
			    		$("#nom_prog").prop( "disabled", false );
			    		$("#text1").prop( "disabled", false );
			    		$("#text3").prop( "disabled", false );
			    		$("#text4").prop( "disabled", false );
			    		$("#text5").prop( "disabled", false );
			    		$("#text6").prop( "disabled", false );
			    		$("#text8").prop( "disabled", false );
			    		$("#text9").prop( "disabled", false );
			    		$("#text10").prop( "disabled", false );
			    		$("#text11").prop( "disabled", false );

			    	}

			    }
			});

		}
	</script>
@endsection
