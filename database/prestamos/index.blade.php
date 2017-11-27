@extends('template.pages.main')

@section('title')
    Préstamos
@endsection


@section('name_aplication')
    <h1>
        Préstamos
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
          {!! Form::open(['route' => 'prestamo.prestamo' , 'method' => 'POST' ,'id' =>'createR'])!!}
          <input type="text" name="proceso" value="A" style="display:none">
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
			<th>Código </th>
			<th>Oficina solicitante</th>
			<th>Funcionario que solicita</th>
			<th>Soporte</th>
      <th>Fecha Entrega</th>
      <th>Fecha Devolución</th>
			<th>Detalle</th>
      <th>Devolución</th>
		</thead>
		<tbody>
      
      @if($prestamos != null )
        @foreach($prestamos as $prestamo)
          <tr>
              <td>{{$prestamo->sid_pres}}</td>
              <td>{{$prestamo->sid_ofci}}</td>
              <td>{{$prestamo->nom_soli}}</td>
              <td>{{$prestamo->des_sopo}}</td>
              <td>{{$prestamo->fec_entr}}</td>
              <td>{{$prestamo->fec_devoL}}</td>
              <td><a href="{{ route('prestamo.edit', $prestamo->sid_pres) }}"  
                class="btn btn-primary fa fa-eye" title="Ver detalle"></a></td>
              <td>
                @if($prestamo->fec_devoL != null)
                  <a href="{{ route('prestamo.entrega', $prestamo->sid_pres) }}"  
                  class="btn btn-primary fa fa-reply" title="Devolución" disabled></a>
                @else
                  <a href="{{ route('prestamo.entrega', $prestamo->sid_pres) }}"  
                  class="btn btn-primary fa fa-reply" title="Devolución" ></a>
                @endif
              </td>
          </tr>
        @endforeach

      @endif
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
