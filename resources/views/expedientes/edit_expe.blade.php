@extends('template.pages.main')

@section('title')
    Editar Expediente
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

	{!! Form::open(['route' => 'expedientes.actualiza' , 'method' => 'POST' , 'files'=>true]) !!}


	 <div class="col-md-12">

          <div class="box box-info">
            <div class="box-header">
              
            </div>
            <div class="box-body">
   
				<div class='form-group'>
					{!! Form::label('TRD', 'Código TRD')!!}
					{!! Form::text('TRD', null, ['class' => 'form-control' , 'placeholder' => '', 'disabled', 'id' => 'TRD'])!!}
				
				</div>

   					<div class="form-group col-md-4">
   						<label>Oficina Productora</label>
				     
				        <select id="cod_orga" name='cod_orga' class="form-control select2" style="width: 100%;"  required onchange="codigoTRD()">
				        	<option value="">Seleccione una opcion</option>
				          	@foreach($orgas as $orga)
				          		@if($orga->cod_orga == $detalle->cod_orga)
									<option value="{{$orga->cod_orga}}" selected>{{$orga->nom_orga}}</option>
								@else
									<option value="{{$orga->cod_orga}}">{{$orga->nom_orga}}</option>
								@endif
				            @endforeach
				        </select>
			    	</div>

				<div class="form-group col-md-4">
			        <label>Código Serie</label>
			        <select name='cod_seri' id='cod_seri' class="form-control select2" style="width: 100%;" required onchange="cargarSubs()">
			        	<option value="">Seleccione una opcion</option>
			           	@foreach($series as $seri)
			           		@if($seri->cod_seri == $codse)
								<option value="{{$seri->cod_seri}}" selected>{{$seri->nom_seri}}</option>
							@else
								<option value="{{$seri->cod_seri}}">{{$seri->nom_seri}}</option>
							@endif
			            @endforeach
			        </select>
			    </div>

			  
				
				<div class='form-group col-md-4'>
					{!! Form::label('cod_subs', 'Sub Serie')!!}
					<input type="text" style="display:none" id="CODSUB" value="{{$codsu}}">
					<select id="cod_subs" name='cod_subs' class="form-control select2" style="width: 100%;" onchange="codigoTRD()">
					        <option value="">Seleccione una subserie</option>
					</select>
				</div>

				<div class='form-group col-md-4'>
						@if($enc == null)
				     		{!! Form::label('nom_moda', 'Modalidad')!!}
				     	@else
				     		<label> {!!$enc->met8!!} </label>
				     	@endif
					

					{!! Form::text('nom_moda', $detalle->nom_moda, ['class' => 'form-control' , 'placeholder' => ''])!!}
				</div>

				<div class='form-group col-md-4'>
					@if($enc == null)
				     		{!! Form::label('nom_prog', 'Programa académico')!!}
						{!! Form::text('nom_prog', $detalle->nom_prog, ['class' => 'form-control' , 'placeholder' => '' , 'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 'title'=>'El campo no puede estar en blanco'])!!}
				     	@else
				     		<label> {!!$enc->met7!!} </label>
						{!! Form::text('nom_prog', $detalle->nom_prog, ['class' => 'form-control' , 'placeholder' => '', ])!!}
				     	@endif
				</div>

					<div class='form-group col-md-4'>
						@if($enc == null)
				     		{!! Form::label('fec_ingr', 'Fecha Ingreso')!!}
				     	@else
				     		<label> {!!$enc->met10!!} </label>
				     	@endif
					
					<div class="input-group date">
	                        <div class="input-group-addon">
	                            <i class="fa fa-calendar"></i>
	                        </div>
	                        <input type="text" class="form-control pull-right" id="datepicker" name="fec_ingr">
                    	</div>
				</div>

					<div class='form-group col-md-4'>
					
						@if($enc == null)
				     		{!! Form::label('anh_fina', 'Año Finalizacion')!!}
				     	@else
				     		<label> {!!$enc->met11!!} </label>
				     	@endif
					{!! Form::text('anh_fina', $detalle->anh_fina, ['class' => 'form-control' , 'placeholder' => '' ,'maxlength'=>'4','pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
				</div>


				<div class='form-group col-md-4'>
						@if($enc == null)
				     		{!! Form::label('tip_nivel', 'Nivel')!!}
				     	@else
				     		<label> {!!$enc->met9!!} </label>
				     	@endif
					
					
					{!! Form::text('tip_nivel', $detalle->tip_nivel, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
				</div>

				<div class='form-group col-md-4'>
					{!! Form::label('obs_gene', 'Observaciones')!!}
					{!! Form::text('obs_gene', $detalle->obs_gene, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
				</div>

				<input type="text" name="num_regi" value="{{$detalle->num_regi}}" style="display:none">
            </div>
 
          </div>

        </div>


	


	<div class="row">

		<div class="col-md-6">
			<div class="box box-default">
        <div class="box-header with-border">    
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
         <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
             	
				<div class="form-group">
					@if($enc == null)
			     		<label>Tipo Documento</label>
			     	@else
			     		<label>{{$enc->met2}}</label>
			     	@endif
			        <select name='tip_docu1' class="form-control select2" style="width: 100%;"  disabled>
			            <option value="">Seleccione una opcion</option>
			          	<option value="CC" {{$data[0]}}>Cédula de Ciudadanía</option>
						<option value="CE" {{$data[1]}}>Cédula de Extranjería</option>
						<option value="RC" {{$data[2]}}>Registro civil</option>
						<option value="TI" {{$data[3]}}>Tarjeta de identidad</option>
						<option value="NIT" {{$data[4]}}>NIT para personas jurídicas</option> 
			        </select>
			    </div>



				<div class='form-group'>
					@if($enc == null)
			     		{!! Form::label('num_docu1', 'Número Documento')!!}
			     	@else
			     		{!! Form::label('num_docu1', $enc->met1)!!}
			     	@endif
				
					{!! Form::text('num_docu1', $expe->num_docu, ['class' => 'form-control' , 'placeholder' => '', 'disabled'])!!}
				</div>

				<div class='form-group' >
					
					@if($enc == null)
			     		{!! Form::label('pri_nomb', 'Primer Nombre')!!}
			     	@else
			     		{!! Form::label('pri_nomb', $enc->met3)!!}
			     	@endif
					{!! Form::text('pri_nomb', $expe->pri_nomb, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 'title'=>'El campo no puede estar en blanco'])!!}
				</div>	
				

            </div>
            <!-- /.col -->
            <div class="col-md-12">

            	<div class='form-group' >
            		@if($enc == null)
			     		{!! Form::label('seg_nomb', 'Segundo Nombre')!!}
			     	@else
			     		{!! Form::label('seg_nomb', $enc->met4)!!}
			     	@endif
					
					{!! Form::text('seg_nomb', $expe->seg_nomb, ['class' => 'form-control' , 'placeholder' => ''])!!}
				</div>	
				<div class='form-group' >
					@if($enc == null)
			     		{!! Form::label('pri_apel', 'Primer Apellido')!!}
			     	@else

			     		<label> {!!$enc->met5!!} </label>
			     	@endif
					
					{!! Form::text('pri_apel', $expe->pri_apel, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 'title'=>'El campo no puede estar en blanco'])!!}
				</div>	
				<div class='form-group' >
					
					@if($enc == null)
			     		{!! Form::label('seg_apel', 'Segundo Apellido')!!}
			     	@else
			     		<label> {!!$enc->met6!!} </label>
			     	@endif
					{!! Form::text('seg_apel', $expe->seg_apel, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 'title'=>'El campo no puede estar en blanco'])!!}
				</div>
				<input type="text" name="cod_expe" value="{{$expe->cod_expe}}" style= "display:none;">
				<input type="text" name="tip_docu" value="{{$expe->tip_docu}}" style= "display:none;">
				<input type="text" name="num_docu" value="{{$expe->num_docu}}" style= "display:none;">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">	

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
						<input type="text" name='nombrearchivo' value="{{$arch->nom_arch}}" style="display:none"/>
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
					{!! Form::text('num_pagi', $arch->num_pagi, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
				</div>

					<div class='form-group'>
					{!! Form::label('num_tama', 'Tamaño (kilobyte)')!!}
		
					{!! Form::text('num_tama2', $arch->num_tama, ['class' => 'form-control' , 'placeholder' => '', 'id'=>'num_tama2', 'disabled'])!!}
					<input type="text" name="num_tama" id="num_tama" style="display:none" value="{{$arch->num_tama}}">
				</div>


				<div class='form-group'>
					{!! Form::label('nom_soft', 'Software')!!}
					{!! Form::text('nom_soft', $arch->nom_soft, ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}
				</div>

				<div class='form-group'>
					{!! Form::label('nom_vers', 'Versión')!!}
					{!! Form::text('nom_vers', $arch->nom_vers, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
				</div>

				<div class='form-group'>
					{!! Form::label('nom_reso', 'Resolución')!!}
					{!! Form::text('nom_reso', $arch->nom_reso, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
				</div>

				<div class='form-group'>
					{!! Form::label('nom_idio', 'Idioma')!!}
					{!! Form::text('nom_idio', $arch->nom_idio, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
				</div>

				<input type="text" name="num_arch" value="{{$arch->num_arch}}" style="display:none">
	
            </div>
            
          </div>

        </div>

        
      </div>


	
	
	

	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
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
     if(sizeByte > 0)
     {
     	$("#nom_prog").attr('required', 'required');
     }
     else
     {
     	$("#nom_prog").removeAttr('required');
     }
     
 	});

	window.onload=cargarSubs;

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
		var cod_subs = $("#CODSUB").val();
		var PostUri = "{{ route('seris.buscarccd')}}"; 
		
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
		        $("#cod_subs").html(data);
		        codigoTRD();	
		    }
		});
		

	}

		function codigoTRD()
	{

		var oficina = $("#cod_orga").val();
		var cod_seri = $("#cod_seri").val();
		if(cod_seri.length > 0)
		{
			cod_seri = '.'+$("#cod_seri").val();
		}	
		
		var cod_subs = $("#cod_subs").val();
		if(cod_subs.length > 0)
		{
			cod_subs = '.'+$("#cod_subs").val();
		}
		else
		{

		}	
		var trd = oficina+cod_seri+cod_subs;
		$("#TRD").val(trd);
	}


	</script>
@endsection
