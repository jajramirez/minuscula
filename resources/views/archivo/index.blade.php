@extends('template.pages.main')

@section('title')
    Detalles
@endsection

@section('content')

<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Detalles</h3>
            </div>



	{!! Form::open(['route' => 'archivo.create' , 'method' => 'GET'])!!}
		<input type="text" name="cod_expe" value="{{$cod_expe}}" style= "display:none;">
		<input type="text" name="num_regi" value="{{$num_regi}}" style= "display:none;">
		<button type="submit" class="btn btn-primary"  >
	        Nuevo Registro
	    </button>  
	{!! Form::close() !!}
 
	<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Archivos Expedientes</h3>
            </div>
     
	<div class="box-body table-responsive no-padding">
	<table id='datainfo' class="table table-bordered table-hover">
		<thead>
			<th>Archivo</th>
			<th>Fecha</th>
			<th>Paginas</th>
			<th>Tamaño</th>
			<th>Software</th>
			<th>Versión</th>
			<th>Resolución</th>
			<th>Idioma</th>
			<th>Ver</th>
			<th>Acción</th>
		</thead>
		<tbody>
			@if($detalles != null)

			@foreach($detalles as $dep)
					<td>{{ $dep->nom_arch}} </td>
					<td>{{ $dep->fec_arch}} </td>
					<td>{{ $dep->num_pagi}} </td>
					<td>{{ $dep->num_tama}} </td>
					<td>{{ $dep->nom_soft}} </td>
					<td>{{ $dep->nom_vers}} </td>
					<td>{{ $dep->nom_reso}} </td>
					<td>{{ $dep->nom_idio}} </td>
					<td>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg" 	onclick="cargarmodal('{{ $dep->nom_arch}}')">
								<i class="fa fa-eye" aria-hidden="true"></i>
							</button>

					</td>
					<td>
						<a href="{{ route('archivo.edit', $dep->cod_expe.'_'.$dep->num_regi.'_'.$dep->num_arch) }}"  class="btn btn-warning fa fa-pencil" title="Editar Registro"></a>
						<a href="{{ route('archivo.destroy', $dep->cod_expe.'_'.$dep->num_regi.'_'.$dep->num_arch) }}" class="btn btn-danger fa fa-times" title="Eliminar Registro" onclick ="return confirm('Desea eliminar el registro seleccionado?')"></a> 	
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
            }
        ],
        "language": {
            "lengthMenu": "Mostrando _MENU_ registros por pagina",
            "zeroRecords": "Sin resultados",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtro desde _MAX_ total registros)",
            "search": "Buscar"
        },
        columnDefs: [
            { width: 60, targets: 1 	 }
        ],
    });
  });
} );


  	  function cargarmodal(data)
		  {
		  		url = "{{url('/')}}"; 

		  		res = '<iframe src="https://docs.google.com/viewerng/viewer?url='+url+'/documentos/'
		  		+data
		  		+'&embedded=true" style="border: none; width:100%; height: 35em;"></iframe>';
		  	$("#contenidomodal").html(res);
		  }
</script>

@endsection
