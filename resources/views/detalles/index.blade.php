@extends('template.pages.main')

@section('title')
    Detalles
@endsection

@section('content')


	{!! Form::open(['route' => 'detalles.nuevo' , 'method' => 'GET'])!!}
		<input type="text" name="cod_expe" value="{{$cod_expe}}" style= "display:none;">
		<button type="submit" class="btn btn-primary"  >
	        Nuevo Registro
	    </button>  
	{!! Form::close() !!}

	<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Expedientes</h3>
            </div>
     
	<div class="box-body table-responsive no-padding">
	<table id='datainfo' class="table table-bordered table-hover">
		<thead>
			@if($encabezado == null)
				<th>Codigo Territorial</th>
				<th>Codigo Serie</th>
				<th>Modalidad</th>
				<th>Programa Academico</th>
				<th>Fecha Ingreso</th>
				<th>Año Finalizacion</th>
				<th>Nivel</th>
				<th>Observaciones</th>
				<th>Archivo</th>
				
			@else
				@if($encabezado->met7 != null)
					<th>{{$encabezado->met7}}</th>
				@else
					<th>Codigo Territorial</th>
				@endif
				<th>Codigo Serie</th>
				@if($encabezado->met7 != null)
					<th>{{$encabezado->met8}}</th>
				@else
					<th>Modalidad</th>
				@endif
				<th>Programa Academico</th>
				@if($encabezado->met10 != null)
					<th>{{$encabezado->met10}}</th>
				@else
					<th>Fecha Ingreso</th>
				@endif
				@if($encabezado->met11 != null)
					<th>{{$encabezado->met11}}</th>
				@else
					<th>Año Finalizacion</th>
				@endif
				@if($encabezado->met9 != null)
					<th>{{$encabezado->met9}}</th>
				@else
					<th>NIVEL</th>
				@endif
				<th>Observaciones</th>
				<th>Archivo</th>

			@endif
			<th>Acción</th>
		</thead>
		<tbody>
			@foreach($detalles as $dep)
					<td>{{ $dep->cod_orga}} </td>
					<td>{{ $dep->cod_tipo}} </td>
					<td>{{ $dep->nom_moda}} </td>
					<td>{{ $dep->nom_prog}} </td>
					<td>{{ $dep->fec_ingr}} </td>
					<td>{{ $dep->anh_fina}} </td>
					<td>{{ $dep->tip_nivel}} </td>
					<td>{{ $dep->obs_gene}} </td>
					<td>
							{!! Form::open(['route' => 'archivo.index' , 'method' => 'GET'])!!}
								<input type="text" name="cod_expe" value="{{$dep->cod_expe}}" style= "display:none;">
								<input type="text" name="num_regi" value="{{$dep->num_regi}}" style= "display:none;">
								<button type="submit" class="btn btn-primary"  >
							        IR
							    </button>  
							{!! Form::close() !!}	
					</td>
					<td>
						<a href="{{ route('detalle.edit', $dep->cod_expe.'_'.$dep->num_regi) }}"  class="btn btn-warning fa fa-pencil" title="Editar Registro"></a>
						<a href="{{ route('detalle.destroy', $dep->cod_expe.'_'.$dep->num_regi) }}" class="btn btn-danger fa fa-times" title="Eliminar Registro" onclick ="return confirm('Desea eliminar el registro seleccionado?')"></a> 	
					</td>		
					
					
				</tr>
			@endforeach
		</tbody>
	</table>
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
        }
    });
  });
} );

</script>
@endsection
