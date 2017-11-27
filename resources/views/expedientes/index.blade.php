@extends('template.pages.main')

@section('title')
    Expedientes Electrónicos
@endsection

@section('name_aplication')
    <h1>
        Expedientes Electrónicos
        <small></small>
    </h1>
    <ol class="breadcrumb">
    </ol>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection




@section('content')

	
	<div class="row">
        <div class="col-xs-12">
          <div class="box">

            	{!! Form::open(['route' => 'expedientes.index', 'method' => 'GET' , 'id'=>'buscarF']) !!}
				
				<div class="row">
					<div class="col-xs-4">
		                <div class="form-group">
				            <select name='cod_orga' class="form-control select2" >                 
				            	<option value="">Seleccione una oficina productora</option>                 
				            	@foreach($orga as $org)
				            		@if($codorga != null)
										@if($codorga == $org->cod_orga)
											<option value="{{$org->cod_orga}}" selected="selected">{{$org->nom_orga}}</option>
										@else
											<option value="{{$org->cod_orga}}">{{$org->nom_orga}}</option>
										@endif
									@else
										<option value="{{$org->cod_orga}}">{{$org->nom_orga}}</option>
				            		@endif
				            		
								@endforeach             
							</select>         
						</div>

	                </div>
	                <input type="text" name="data" value="1" style="display:none">
	                <div class="col-xs-4">
	                 	<div class="form-group">
				            <select id='codeseri' name='cod_seri' class="form-control select2" onchange="cargarSubs()">
				            	<option value="">Seleccione una serie</option>
				              	@foreach($seri as $ser)
									@if($codseri != null)
										@if($codseri == $ser->cod_seri)
											<option value="{{$ser->cod_seri}}" selected="selected">{{$ser->nom_seri}}</option>
										@else
											<option value="{{$ser->cod_seri}}">{{$ser->nom_seri}}</option>
										@endif
									@else
										<option value="{{$ser->cod_seri}}">{{$ser->nom_seri}}</option>
				            		@endif

									
				                @endforeach
				            </select>
				        </div>

	                </div>

	                 <div class="col-xs-4">
	                 	<div class="form-group">
	                 		<input type="text" id="subs" value="{{$codsubs}}" style= "display:none;">
				            <select id="codesubs" name='cod_subs' class="form-control select2">
				            	<option value="">Seleccione una sub serie</option>
				            </select>
				        </div>

	                </div>



				</div>

				<div class="row">
	                

					 <div class="col-xs-4">
		                <div class="form-group">
							{!! Form::text('num_docu', null, ['class' => 'form-control' , 'placeholder' => 'Numero Documento'])!!}
						</div>
	                </div>
	                <div class="col-xs-4">
		                <div class="form-group">
							{!! Form::text('NOM_COM', null, ['class' => 'form-control' , 'placeholder' => 'Nombre '])!!}
						</div>
	                </div>
	                
					<input ype="text" value="1" name="data" style="display:none">

					<div class="col-xs-4">
		                <div class="form-group">
							{!! Form::text('nom_moda', null, ['class' => 'form-control' , 'placeholder' => 'Modalidad'])!!}
						</div>
	                </div>

				</div>

				<div class="row">
					
					<div class="col-xs-4">
		                <div class="form-group">
							{!! Form::text('nom_prog', null, ['class' => 'form-control' , 'placeholder' => 'Programa'])!!}
						</div>
	                </div>
	                

					<div class="col-xs-4">
		                <div class="form-group">
							{!! Form::text('TIP_NIVE', null, ['class' => 'form-control' , 'placeholder' => 'Nivel' ])!!}
						</div>
	                </div>


					<div class="col-xs-4">
		                <div class="form-group">
							{!! Form::text('nom_arch', null, ['class' => 'form-control' , 'placeholder' => 'Nombre Archivo' ])!!}
						</div>
	                </div>

	                

				</div>

				<div class="row">
					<div class="col-xs-10">
					</div>
					<div class="col-xs-1">
	                	<div class="form-group">	
							<button type="submit" class="btn btn-primary" style="display:none;" >
						  		<span class="glyphicon glyphicon-search" aria-hidden="true"> </span>
						 	</button>
						</div>
					</div>

				
				</div>
        {!! Form::close()!!}


	<div class="row">
					
						
					{!! Form::open(['route' => 'expedientes.create' , 'method' => 'GET' ,'id' =>'createR'])!!}
						<button type="submit" class="btn btn-primary"  style="display:none">
				       <span class="fa fa-plus-circle" aria-hidden="true"> </span>
				    </button>  
					{!! Form::close() !!}
			
					</div>




     
	<div class="box-body table-responsive no-padding">
	<table id='datainfo' class="table table-bordered table-hover">
		<thead>
			<th>Código</th>
				@if($encabezado == null)
					
					<th>Tipo Documento</th>
					<th>Documento de Identidad</th>
					<th>Primer Nombre</th>
					<th>Segundo Nombre</th>
					<th>Primer Apellido</th>
					<th>Segundo Apellido</th>
					
				@else

					@if($encabezado->met2 != null)
						<th>{{$encabezado->met2}}</th>
					@else
						<th><!--Tipo Documento--></th>
					@endif

					@if($encabezado->met1 != null)
						<th>{{$encabezado->met1}}</th>
					@else
						<th><!--Documento de Identidad--></th>
					@endif

					@if($encabezado->met3 != null)
						<th>{{$encabezado->met3}}</th>
					@else
						<th><!--Primer Nombre--></th>
					@endif

					@if($encabezado->met4 != null)
						<th>{{$encabezado->met4}}</th>
					@else
						<th><!--Segundo Nombre--></th>
					@endif

					@if($encabezado->met5 != null)
						<th>{{$encabezado->met5}}</th>
					@else
						<th><!--Primer Apellido--></th>
					@endif

					@if($encabezado->met6 != null)
						<th>{{$encabezado->met6}}</th>
					@else
						<th><!--Segundo Apellido--></th>
					@endif

				@endif


				@if($encabezado == null)
					<th>Oficina Productora</th>
					<th>Código Serie</th>
					<th>Modalidad</th>
					<th>Programa Academico</th>
					<th>Fecha Ingreso</th>
					<th>Año Finalizacion</th>
					<th>Nivel</th>
					<th>Observaciones</th>
					
				@else
					<th>Oficina Productora</th>
					
					<th>Codigo Serie</th>
					@if($encabezado->met8 != null)
						<th>{{$encabezado->met8}}</th>
					@else
						<th><!--Modalidad--></th>
					@endif
					@if($encabezado->met7 != null)
						<th>{{$encabezado->met7}}</th>
					@else
						<th><!--Programa Academico--></th>
					@endif
					@if($encabezado->met10 != null)
						<th>{{$encabezado->met10}}</th>
					@else
						<th><!--Fecha Ingreso--></th>
					@endif
					@if($encabezado->met11 != null)
						<th>{{$encabezado->met11}}</th>
					@else
						<th><!--Año Finalizacion--></th>
					@endif
					@if($encabezado->met9 != null)
						<th>{{$encabezado->met9}}</th>
					@else
						<th><!--NIVEL--></th>
					@endif
					<th><!--Observaciones--></th>
				@endif

			<!--<th>Detalle</th>-->
			<th>Archivo</th>
			<th>Fecha</th>
			<th>Paginas</th>
			<th>Tamaño</th>
			<th>Software</th>
			<th>Versión</th>
			<th>Resolución</th>
			<th>Idioma</th>
			<th>Ver</th>
			<th>Nuevo</th>
			<th>Acción</th>
		</thead>
		<tbody>
			@if($expedientes != null)

			@foreach($expedientes as $expediente)
					<td>{{ $expediente->cod_expe}} </td>
					<td>{{ $expediente->tip_docu}} </td>
					<td>{{ $expediente->num_docu}} </td>
					<td>{{ $expediente->pri_nomb}} </td>
					<td>{{ $expediente->seg_nomb}} </td>
					<td>{{ $expediente->pri_apel}} </td>
					<td>{{ $expediente->seg_apel}} </td>
					<td>{{ $expediente->cod_orga}} </td>
					<td>
						<!--{{ $expediente->cod_tipo}}--> 
					<?php

						if($expediente->cod_subs != null)
						{
							if($expediente->cod_subs !=  '0')
							{
								echo $expediente->cod_tipo.'.'.$expediente->cod_subs;
							}
							else
							{
								echo $expediente->cod_tipo;
							}
						}
						else{
							echo $expediente->cod_tipo;
						}
					?>

</td>
					<td>{{ $expediente->nom_moda}} </td>
					<td>{{ $expediente->nom_prog}} </td>
					<td>{{ $expediente->fec_ingr}} </td>
					<td>{{ $expediente->anh_fina}} </td>
					<td>{{ $expediente->tip_nivel}}</td>
					<td>{{ $expediente->obs_gene}} </td>

					<!--<td>
						{!! Form::open(['route' => 'detalles.expediente' , 'method' => 'GET'])!!}
						<input type="text" name="cod_expe" value="{{$expediente->cod_expe}}" style= "display:none;">
						<button type="submit" class="btn btn-primary"  >
	                        <i class="fa fa-eye"></i>
	                    </button>  
						{!! Form::close() !!}</td>-->
					<td>{{ $expediente->nom_arch}} </td>
					<td>{{ $expediente->fec_arch}} </td>
					<td>{{ $expediente->num_pagi}} </td>
					<td>{{ $expediente->num_tama}} </td>
					<td>{{ $expediente->nom_soft}} </td>
					<td>{{ $expediente->nom_vers}} </td>
					<td>{{ $expediente->nom_reso}} </td>
					<td>{{ $expediente->nom_idio}} </td>
					<td>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg" 	onclick="cargarmodal('{{ $expediente->PATH}}','{{ $expediente->nom_arch}}')">
								<i class="fa fa-eye" aria-hidden="true"></i>
						</button>

					</td>

					<td>
						{!! Form::open(['route' => 'archivo.index' , 'method' => 'GET'])!!}
								<input type="text" name="cod_expe" value="{{$expediente->cod_expe}}" style= "display:none;">
								<input type="text" name="num_regi" value="{{$expediente->num_regi}}" style= "display:none;">
								<button type="submit" class="btn btn-primary"  >
							        IR
							    </button>  
							{!! Form::close() !!}	
					</td>
					<td>
						<a href="{{ route('expedientes.edit', $expediente->cod_expe.'_'.$expediente->num_docu.'_'.$expediente->num_regi.'_'.$expediente->num_arch) }}"  class="btn btn-warning fa fa-pencil" title="Editar Registro"></a>
						<a href="{{ route('expedientes.destroy', $expediente->cod_expe.'_'.$expediente->num_docu) }}" class="btn btn-danger fa fa-times" title="Eliminar Registro" onclick ="return confirm('Desea eliminar el registro seleccionado?')"></a> 	
					</td>		
					
					
				</tr>
			@endforeach
			@endif
		</tbody>
	</table>
		</div>
</div>
</div>


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    	<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        	<span aria-hidden="true">&times;</span>
	        </button>
	        
	      </div>
	      <div class="modal-body">
	        <div id="contenidomodal"></div>
      	</div>
    </div>
  </div>
</div>

@endsection

@section('js')
<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
<script>
$(document).ready(function() {
  $(function () {
    $('#datainfo').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      dom: 'Bfrtip',
      buttons: [
            {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            },
             {
                text:      '<span class="glyphicon glyphicon-search" aria-hidden="true"> </span>',
                titleAttr: 'Buscar',
                action: function ( e, dt, node, config ) {
		    if($("#codesubs").attr("required") == "required" && $("#codesubs").val()== "")
			{alert("Debe seleccionar una subserie");}
		    else{
                    $( "#buscarF" ).submit();
		   }
                }
                
            },
            {
                text: '<span class="fa fa-plus-circle" aria-hidden="true"> </span>',
                titleAttr: 'Añadir',
                action: function ( e, dt, node, config ) {
                    $( "#createR" ).submit();
                }
                
            }
        ],
            "language": {
            "lengthMenu": "Mostrando _MENU_ registros por pagina",
            "zeroRecords": "Sin resultados",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtro desde _MAX_ total registros)",
            "search": "Buscar"
        }
    });
  });
});

$(".select2").select2();
		  


function cargarmodal(ruta, data)
{
	if(ruta == '' )
	{
		url = "{{url('/')}}";
		url = url+'/documentos/'
	}
	else
	{
		url = ruta;
	}
	res = '<iframe src="https://docs.google.com/viewerng/viewer?url='+url+data
  		+'&embedded=true" style="border: none; width:100%; height: 35em;"></iframe>';
  	$("#contenidomodal").html(res);
}

window.onload=cargarSubs;

	
function cargarSubs()
	{
		var cod_seri = $("#codeseri").val();
		var cod_subs = $("#subs").val();
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
			var comilla = '"';
                            if(data != "<option value="+comilla+comilla+">Seleccione una subserie</option>")
                            {
                                $("#codesubs").attr('required', 'required');
                            }
                            else
                            {
                                $("#codesubs").removeAttr('required');
                            }
		        $("#codesubs").html(data);
		    }
		});

	}
</script>
@endsection
