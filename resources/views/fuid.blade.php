@extends('template.pages.main')

@section('title')
    Lista
@endsection


@section('name_aplication')
    <h1>
      
    </h1>
@endsection


@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lista FUID</h3>
            </div>
     
	<div class="box-body table-responsive no-padding">
	<table id='datainfo' class="table table-bordered table-hover">
		<thead>
			<th>No.ORD.</th>
			<th>CODIGO</th>
			<th>SERIE</th>
			<th>ASUNTO</th>
			<th>SUBS</th>
			<th>CONSECUTIVO</th>
			<th>FECHA INICIAL</th>
			<th>FECHA FINAL</th>
			<th>CARPETA</th>
			<th>TOMO</th>
			<th>CAJA</th>
			<th>CONSECUTIVO BODEGA</th>
			<th>No. DE FOLIOS</th>
			<th>FRECUENCIA CONSULTA</th>
			<th>DIGITALIZADOR</th>
			<th>NOMBRE ARCHIVO</th>
			<th>OBSERVACIONES	</th>
			<th>NUMERO ENTREGA</th>
		</thead>
		<tbody>
			@if($datos != null)
				
				@foreach($datos as $dato)
					
					<tr>
						<td>{{ $dato->num_regi}} </td>
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
						<td>{{ $dato->num_docu}} </td>
						<td>{{ $dato->fec_inic}} </td>
						<td>{{ $dato->fec_fina}} </td>
						<td>{{ $dato->num_carp}} </td>
						<td>{{ $dato->num_tomo}} </td>
						<td>{{ $dato->num_caja}} </td>
						<td>{{ $dato->num_inte}} </td>
						<td>{{ $dato->num_foli}} </td>
						<td>{{ $dato->fre_cons}} </td>
						<td>{{ $dato->nom_digi}} </td>
						<td><a href="documentos/{{ $dato->nom_arch}}" download>{{ $dato->nom_arch}}</a> </td>
						<td>{{ $dato->obs_gen1}} </td>
						<td>{{ $dato->obs_gen2}} </td>
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
	</div>
</div>
</div>
@endsection


@section('js')

<script>
  $(function () {
    $('#datainfo').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
  });
</script>
@endsection