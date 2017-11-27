@extends('template.pages.main')

@section('title')
    Dependencias
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection


@section('name_aplication')
    <h1>
        Generar Tabla de Retención Documental
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
				<br/><br/>
	                <div class="col-xs-4">
		                <div class="form-group">
				            <select id='cod_orga' name='cod_orga' class="form-control select2" ">                 
				            	<option value="">Seleccione una oficina productora</option>                 
				            	@foreach($orga as $org)
				            		
										<option value="{{$org->cod_orga}}">{{$org->nom_orga}}</option>
						
				            		
								@endforeach             
							</select>         
						</div>

	                </div>
	                <input type="text" name="data" value="1" style="display:none">
	                <div class="col-xs-4">
	                 	<div class="form-group">
				            <select id='cod_seri' name='cod_seri' class="form-control select2" >
				            	<option value="">Seleccione una serie</option>
				              	@foreach($seri as $ser)
							
										<option value="{{$ser->cod_seri}}">{{$ser->nom_seri}}</option>
				            	
									
				                @endforeach
				            </select>
				        </div>

	                </div>
	                <div class="col-xs-1">
						
					</div>
					<div class="row">

					<a class='btn btn-primary' href="#"  id="generarPDF" onclick="validar()"> Generar Reporte</a>
					

					</div>
				</div>
		
			
		
			


				
			</div>
		</div>
	</div>
@endsection

@section('js')


<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>



<script type="text/javascript">
    $(".select2").select2();
	function validar()
	{
		url();
		
	}
	function url()
	{
		var seri, orga;
		var cod_seri = ($("#cod_seri").val());
		var n = cod_seri.length;
		if(n>0)
		{
			seri = cod_seri;
		}
		else
		{
			seri= "0";
		}
		var cod_orga = ($("#cod_orga").val());
		var n = cod_orga.length;
		if(n>0)
		{
			orga = cod_orga;
		}
		else
		{
			orga= "0";
		}
		if(orga == "0")
		{
			alert("Seleccione una oficina productora");
			 $("#generarPDF").attr("href", "#");
			 $("#generarPDF").removeAttr("target");
		}
		else{
			$("#generarPDF").attr("href", 'excel/'+orga+'/'+seri);
			$("#generarPDF").attr("target", "_blank");

		}
	}



</script>


@endsection
