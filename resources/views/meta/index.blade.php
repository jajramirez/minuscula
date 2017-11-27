@extends('template.pages.main')

@section('title')
    Descripción Subseries
@endsection


@section('name_aplication')
    <h1>
        Descripción Subseries
        <small></small>
    </h1>
    <ol class="breadcrumb">
    </ol>
@endsection





@section('content')

	<div class="row">
        <div class="col-xs-12">
          <div class="box">

	


      <div class="row">
          {!! Form::open(['route' => 'meta.create' , 'method' => 'GET' ,'id' =>'createR'])!!}
          <button type="submit" class="btn btn-primary"  style="display:none">
               <span class="fa fa-plus-circle" aria-hidden="true"> </span>
            </button>  
          {!! Form::close() !!}
        </div>

	<hr>


     
	<div class="box-body table-responsive no-padding">
	<table id='datainfo' class="table table-bordered table-hover">
		<thead>
			<!--<th>Numero Registro</th>-->
			<th>Serie</th>
			<th>Subserie</th>
			<th>met1</th>
			<th>met2</th>
      <th>met3</th>
      <th>met4</th>
      <th>met5</th>
      <th>met6</th>
      <th>met7</th>
      <th>met8</th>
      <th>met9</th>
      <th>met10</th>
      <th>met11</th>
			<th>Acción</th>
		</thead>
		<tbody>
			@foreach($ccds as $ccd)
				<tr>
					<!--<td>{{ $ccd->num_regi}} </td>-->
					<td>{{ $ccd->cod_seri}} </td>
					<td>{{ $ccd->cod_subs}} </td>
					<td>{{ $ccd->met1}} </td>
          <td>{{ $ccd->met2}} </td>
          <td>{{ $ccd->met3}} </td>
          <td>{{ $ccd->met4}} </td>
          <td>{{ $ccd->met5}} </td>
          <td>{{ $ccd->met6}} </td>
          <td>{{ $ccd->met7}} </td>
          <td>{{ $ccd->met8}} </td>
          <td>{{ $ccd->met9}} </td>
          <td>{{ $ccd->met10}} </td>
          <td>{{ $ccd->met11}} </td>
					<td>
						<a href="{{ route('meta.edit', $ccd->cod_enti.'_'.$ccd->num_regi) }}"  class="btn btn-warning fa fa-pencil" title="Editar Registro"></a>
						<a href="{{ route('meta.destroy', $ccd->num_regi) }}" class="btn btn-danger fa fa-times" title="Eliminar Registro" onclick ="return confirm('Desea eliminar el registro seleccionado?')"></a> 	
					</td>		
					
					
				</tr>
			@endforeach
		</tbody>
	</table>
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
} );

</script>
@endsection
