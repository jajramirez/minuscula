@extends('template.pages.main')

@section('title')
    Dependencias
@endsection

@section('content')

	<a href="{{ route('dependencias.create') }}" class="btn btn-primary"> Nuevo Registro</a><hr>

	<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Dependencias</h3>
            </div>
     
	<div class="box-body table-responsive no-padding">
	<table id='datainfo' class="table table-bordered table-hover">
		<thead>
			<th>Código Padre</th>
			<th>Código</th>
			<th>Nombre</th>
			<th>Nivel</th>
			<th>Estado</th>
			<th>RUTA</th>
			<!--
			<th>Usuario</th>
			<th>Fecha</th>
			<th>Hora</th> -->
			<th>Acción</th>
		</thead>
		<tbody>
			@foreach($deps as $dep)
					<td>{{ $dep->cod_padr}} </td>
					<td>{{ $dep->cod_orga}} </td>
					<td>{{ $dep->nom_orga}} </td>
					<td>{{ $dep->cod_nive}} </td>
					<td>{{ $dep->ind_esta}} </td>
					<td>{{ $dep->PATH}} </td>
					<!-- <td>{{ $dep->cod_usua}} </td>
					<td>{{ $dep->fec_actu}} </td>
					<td>{{ $dep->hor_actu}} </td> -->
					<td>
						<a href="{{ route('dependencias.edit', $dep->cod_enti.'_'.$dep->cod_orga) }}"  class="btn btn-warning fa fa-pencil" title="Editar Registro"></a>
						<a href="{{ route('dependencias.destroy', $dep->cod_enti.'_'.$dep->cod_orga) }}" class="btn btn-danger fa fa-times" title="Eliminar Registro" onclick ="return confirm('Desea eliminar el registro seleccionado?')"></a> 	
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
