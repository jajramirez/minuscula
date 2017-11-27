@extends('template.pages.main')

@section('title')
    FUID
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection



@section('name_aplication')
    <h1>
       	Formato Unico de Inventario Documental (FUID) 
        <small></small>
    </h1>
    <ol class="breadcrumb">
    </ol>
@endsection



@section('content')

<div class="row">
        <div class="col-xs-12">
          <div class="box">

		{!! Form::open(['route' => 'home.fuid', 'method' => 'GET', 'id'=>'buscarF']) !!}
				<div class="row"></div>
			
		 <div class="row">

                <div class="col-xs-3">
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
                <div class="col-xs-3">
                 	<div class="form-group">
			            <select name='cod_seri' class="form-control select2">
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

                 <div class="col-xs-3">
	                <div class="form-group">
						{!! Form::text('obs_gen1', null, ['class' => 'form-control' , 'placeholder' => 'NOTAS'])!!}
					</div>
                </div>
			 </div>
				<div class="row">
	                

					 <div class="col-xs-3">
		                <div class="form-group">
							{!! Form::text('obs_gen2', null, ['class' => 'form-control' , 'placeholder' => 'obs_gen2'])!!}
						</div>
	                </div>
	                <div class="col-xs-3">
		                <div class="form-group">
							{!! Form::text('obs_gen3', null, ['class' => 'form-control' , 'placeholder' => 'obs_gen3'])!!}
						</div>
	                </div>
	                
					<input ype="text" value="1" name="data" style="display:none">

					<div class="col-xs-3">
		                <div class="form-group">
							{!! Form::text('obs_gen4', null, ['class' => 'form-control' , 'placeholder' => 'obs_gen4'])!!}
						</div>
	                </div>

				</div>

				<div class="row">
					
					<div class="col-xs-3">
		                <div class="form-group">
							{!! Form::text('Asunto', null, ['class' => 'form-control' , 'placeholder' => 'Asunto'])!!}
						</div>
	                </div>
	                
					<input ype="text" value="1" name="data" style="display:none">

					<div class="col-xs-3">
		                <div class="form-group">
							{!! Form::text('Anio', null, ['class' => 'form-control' , 'placeholder' => 'Año' , 'maxlength' => '4'])!!}
						</div>
	                </div>

					
					<div class="col-xs-3">
		                <div class="form-group">
							{!! Form::text('cod_bode', null, ['class' => 'form-control' , 'placeholder' => 'Consecutivo Bodega'])!!}
						</div>
	                </div>

				</div>


				<div class="row">
					
				
	                <div class="col-xs-3">
		                <div class="form-group">
							{!! Form::text('FEC_TRAN', null, ['class' => 'form-control' , 'placeholder' => 'Fecha Transferencia'])!!}
						</div>
	                </div>

	                <div class="col-xs-3">
		                <div class="form-group">
							{!! Form::text('NUM_TRAN', null, ['class' => 'form-control' , 'placeholder' => 'Numero Transferencia'])!!}
						</div>
	                </div>

	                  
	                
				</div>
           

			<div class="row">
				<div class="col-xs-10"></div>
				<div class="col-xs-1">
	                	<div class="form-group">	
							<button id="buscar" type="submit" class="btn btn-primary" style="display:none">
						  		<span class="glyphicon glyphicon-search" aria-hidden="true"> </span>
						 	</button>
						</div>
					</div>

					{!! Form::close()!!}


				<div class="col-xs-1">
					{!! Form::open(['route' => 'fuid.create' , 'method' => 'GET' ,'id' =>'createR'])!!}
					<input type="text" name="busqueda" value="" style="display:none">
					<button type="submit" class="btn btn-primary"  style="display:none">
				       <span class="fa fa-plus-circle" aria-hidden="true"> </span>
				    </button>  
					{!! Form::close() !!}
				</div>


			</div>
           
        
	

		

	<div class="box-body table-responsive no-padding">
		<table id='datainfo' class="table table-bordered table-hover">
			<thead>
				<th>No.Orden</th>
				<th>Código</th>
				<th>Serie</th>
				<th>Subserie</th>
				<th>Asunto</th>
				<th>Fecha Inicial</th>
				<th>Fecha Final</th>
				<th>Caja</th>
				<th>Carpeta</th>
				<th>Tomo</th>
				<th>Otro</th>
				<th>No. Folios</th>
				<th>Soporte</th>
				<th>Frecuencia Consulta</th>
				<th>Notas</th>
				<th>Consecutivo Bodega</th>
				<th>Fecha Transferencia</th>
				<th>Numero Transferencia</th>
				<th>Archivo</th>
				<th>Metadatos</th>
				<th>Etiqueta</th>
				<th>Acción</th>
			</thead>
			<tbody>
				@if($datos != null)
					@foreach($datos as $dato)
						<tr>
							<td>@if($dato->num_orde == NULL) {{ $dato->num_regi}} @else {{ $dato->num_orde}} @endif </td>
							<td>{{ $dato->cod_trd}} </td>
							<td>{{ $dato->nom_seri}} </td>
							<td>
								<?php

									if(count($info)>= $secuencia)
									{ 
										$dac = $info[$secuencia];
										foreach($dac as $v)
										{
											echo($v->nom_subs);
										}
									}
									$secuencia++
								?>



							</td>
							<td>{{ $dato->nom_asun}} </td>
							<td>{{ $dato->fec_inic}} </td>
							<td>{{ $dato->fec_fina}} </td>
							<td>{{ $dato->num_caja}} </td>
							<td>{{ $dato->num_carp}} </td>
							<td>{{ $dato->num_tomo}} </td>
							<td>{{ $dato->num_inte}} </td>
							<td>{{ $dato->num_foli}} </td>
							<td>{{ $dato->gen_sopo}} </td>
							<td>{{ $dato->fre_cons}} </td>
						 	<td>{{ $dato->obs_gen1}} </td>
							<td>{{ $dato->cod_bode}} </td>
							<td>{{ $dato->FEC_TRAN}} </td>
							<td>{{ $dato->NUM_TRAN}} </td>
							<!--<td><a href="documentos/{{ $dato->nom_arch}}" download><i class="fa fa-eye" aria-hidden="true"></i></a> </td> -->
							<td>
								@if( $dato->nom_arch != null)
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg" 	onclick="cargarmodal('{{$dato->PATH}}','{{ $dato->nom_arch}}')">
									<i class="fa fa-eye" aria-hidden="true"></i>
								</button>
								@endif

							</td>
							<td>
							
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg" 	onclick="verMetadatos('{{$dato->fec_crea}}', '{{$dato->num_pagi}}', '{{$dato->tam_arch}}', '{{$dato->sof_capt}}', '{{$dato->ver_arch}}', '{{$dato->res_arch}}', '{{$dato->idi_arch}}')">
									Consultar
								</button>
								
							</td>
							<td>
								<button title="Generar Etiqueta" class="btn btn-primary"  onclick ="generaretiquetas('{{$dato->cod_enti}}','{{$dato->cod_trd}}','{{$dato->num_regi}}')">Generar</button> 
							</td>
							<td>
								<a href="{{ route('fuid.edit', $dato->cod_enti.'_'.$dato->cod_trd.'_'.$dato->num_regi) }}"  class="btn btn-warning fa fa-pencil" title="Editar Registro"></a>
								<a href="{{ route('fuid.destroy', $dato->cod_enti.'_'.$dato->cod_trd.'_'.$dato->num_regi)}}" class="btn btn-danger fa fa-times" title="Eliminar Registro" onclick ="return confirm('Desea eliminar el registro seleccionado?')"></a> 	
							</td>		

							<!--<td>{{ $dato->nom_digi}} </td>-->
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
    $('#datainfo').removeAttr('width').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
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
                    $( "#buscarF" ).submit();
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
            "search": "Buscar",
            "showing":"Mostrando"
        },
        scrollX:        true,
        scrollCollapse: true,
        paging:         true,
        columnDefs: [
            { width: 60, targets: 5 },
            { width: 60, targets: 6 }
        ],
        fixedColumns: true
    });
  });



} );


function generaretiquetas(enti, trd, regi) {
			var PostUri = "{{ route('fuid.pdf')}}";
			bodega = '';
			$.ajax({
		    url: PostUri,
		    type: 'post',
		    data: {
		        cod_bode: bodega, 
		        cod_enti: enti,
		        cod_trd: trd,
		        NUN_REGI: regi
		    },
		    headers: {
		        'X-CSRF-TOKEN': "{{ Session::token() }}", //for object property name, use quoted notation shown in second
		    },
		    success: function (data) {
		        if(data != "error")
		        {
		                urlb = "{{url('/')}}"; 
		                var url = urlb+"/documentos/etiquetas"+data+".pdf";
		                window.open(url, "", "width=800,height=800");
		        }

		    }
		});
	}
</script>

	<script type="text/javascript">
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

		  function verMetadatos(fec_crea, num_pagi, tam_arch, sof_capt, ver_arch, res_arch, idi_arch)
		  {
		  	res = 	"Fecha Creación Archivo: " + fec_crea
				  	+"<br/>Número de Páginas: " + num_pagi
					+"<br/>Tamaño Archivo: " + tam_arch
					+"<br/>Software de Captura: " + sof_capt
					+"<br/>Versión Archivo: " + ver_arch
					+"<br/>Resolución: " + res_arch
					+"<br/>Idioma: " + idi_arch
					+"";

			$("#contenidomodal").html(res);
		  }
	</script>


@endsection
