@extends('template.pages.main')

@section('title')
    Usuarios
@endsection

@section('name_aplication')
    <h1>
        Usuarios Registrados
        <small> Funalmi</small>
    </h1>
    <ol class="breadcrumb">
    </ol>
@endsection




@section('content')

	<div class="row">
        <div class="col-xs-12">
          <div class="box">


    <div class="row">
          {!! Form::open(['route' => 'usuarios.create' , 'method' => 'GET' ,'id' =>'createR'])!!}
          <button type="submit" class="btn btn-primary"  style="display:none">
               <span class="fa fa-plus-circle" aria-hidden="true"> </span>
            </button>  
          {!! Form::close() !!}
        </div>
	<hr>

	<div class="row">
        <div class="col-xs-12">
          <div class="box">
      
     
	<div class="box-body table-responsive no-padding">
	<table id='datainfo' class="table table-bordered table-hover">
		<thead>
			<th>Codigo</th>
			<th>Nombre Usuario</th>
			<th>Estado</th>
			<th>Rol</th>
			<th>Acción</th>
		</thead>
		<tbody>
			@foreach($usuarios as $user)
					<td>{{ $user->cod_usua}} </td>
					<td>{{ $user->nom_usua}} </td>
					<td>{{ $user->ind_esta}} </td>
					<td>
						@if($user->cod_role == "1")
							Administrador
						@endif
						@if($user->cod_role == "2")
							Operario
						@endif
						@if($user->cod_role == "3")
							Consulta
						@endif
					<td>
						<a href="{{ route('usuarios.edit', $user->id) }}"  class="btn btn-warning fa fa-pencil" title="Editar Registro"></a>
						<a href="{{ route('usuarios.destroy', $user->id) }}" class="btn btn-danger fa fa-times" title="Eliminar Registro" onclick ="return confirm('Desea eliminar el usuario')"></a> 	
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