@extends('template.pages.main')

@section('title')
    Editar Retención 
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Editar registro de Retención Documental
        <small> </small>
    </h1>
@endsection


@section('content')

@if(count($errors) >0)
	<div class="alert alert-danger" role="alert">
		<ul>
			@foreach($errors->all() as $error)
				<li>
					{{ $error}}
				</li>
			@endforeach
		</ul>
	</div>
@endif

	{!! Form::open(['route' => 'trd.actualizar' , 'method' => 'POST'])!!}
		        
	<div class="form-group">
     	<label>Codigo TRD {{$trd->cod_trd}}</label>
     	<input type="text" style="display:none;" value="{{$trd->cod_trd}}" name="cod_trd">
     	<input type="text" style="display:none;" value="{{$trd->cod_enti}}" name="cod_enti">
        <div class="row">
			<div class="col-xs-5">
	            <div class="form-group">
		        	@foreach($orga as $org)
		      			@if($codorga == $org->cod_orga)
							<label> {{$org->cod_orga}} - {{$org->nom_orga}}</label>
						@endif
					@endforeach
				</div>
			</div>
            <div class="col-xs-5">
               	<div class="form-group">
		            @foreach($seri as $ser)
						@if($codseri == $ser->cod_seri)
							<label> {{$ser->cod_seri}} - {{$ser->nom_seri}}</label>								
						@endif
					@endforeach 
		        </div>
            </div>
        </div>
    </div>

	<div class="row">
		<div class="col-xs-4">
			<div class='form-group'>
				{!! Form::label('arc_gest', 'Gestión')!!}
				{!! Form::text('arc_gest', $trd->arc_gest, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
			</div>
		</div>
		
		<div class="col-xs-4">
			<div class='form-group'>
				{!! Form::label('arc_cent', 'Central')!!}
				{!! Form::text('arc_cent', $trd->arc_cent, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
			</div>
		</div>

		<div class="col-xs-4">
			<div class='form-group'>
				{!! Form::label('ban_ct', 'Conservación Total (0 = No, 1 = Si)')!!}
				{!! Form::text('ban_ct', $trd->ban_ct, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-1]', 'title' => 'Solo se permiten 0 - 1'])!!}
			</div>
		</div>
	</div>
		
	<div class="row">
		<div class="col-xs-4">	
			<div class='form-group'>
				{!! Form::label('ban_e', 'Eliminación (0 = No, 1 = Si)')!!}
				{!! Form::text('ban_e', $trd->ban_e, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-1]', 'title' => 'Solo se permiten 0 - 1'])!!}
			</div>
		</div>
		<div class="col-xs-4">
			<div class='form-group'>
				{!! Form::label('ban_m', 'Microfilmación (0 = No, 1 = Si)')!!}
				{!! Form::text('ban_m', $trd->ban_m, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-1]', 'title' => 'Solo se permiten 0 - 1'])!!}
			</div>
		</div>
		<div class="col-xs-4">
			<div class='form-group'>
				{!! Form::label('ban_s', 'Selección (0 = No, 1 = Si)')!!}
				{!! Form::text('ban_s', $trd->ban_s, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-1]', 'title' => 'Solo se permiten 0 - 1'])!!}
			</div>
		</div>
	</div>
	<div class='form-group'>
		{!! Form::label('tex_obse', 'Observaciones')!!}
		{!! Form::textarea('tex_obse', $trd->tex_obse, ['class' => 'form-control' , 'placeholder' => '', 'required', 'style'=> 'height:6em;'])!!}
	</div>

	<div id="cursos" class='form-group' >
		{!! Form::label('ind_esta', 'Estado')!!}
		{!! Form::select('ind_esta', ['A'=>'Activado', 'D'=>'Desactivado'] , $trd->ind_esta, ['class' => 'form-control', 'placeholder' => 'Seleccione una opcion', 'required'])!!}
	</div>

	<div class="form-group">
        <label>Detalle</label>
        <div class="row">
	        <div class="col-xs-4">
	        	{!! Form::text('textoSelect', null, ['class' => 'form-control' , 'placeholder' => '', 'id'=>'textodetalle'])!!}
	        </div>
	        <div class="col-xs-4">
	        	{!! Form::button('Agregar',['class' => 'btn btn-primary', 'id'=>'agregarselect', 'onclick' => 'agregar()'] )!!}
	        </div>
        </div>
        <div class="row">
        	<div class="col-xs-10">
		        <select multiple class="form-control" name='datosselect' id="datosselect">
		        	@if($detalle != null)
						@foreach($detalle as $d)
							<option value="{{$d->nom_desc}}">{{$d->nom_desc}}</option>
						@endforeach
		        	@endif
		        </select>
		     	<input type="text" style="display:none;" name='deta' id="deta" value="{{$des_deta}}">
		     	<input type="text" style="display:none;" name='original' id="original" value="{{$des_deta}}">
	        </div>
	        <div class="col-xs-2">
	        	{!! Form::button('Eliminar',['class' => 'btn btn-primary', 'onclick' => 'removeritem()'] )!!}
	        </div>
    	</div>
    </div>


	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection

@section('js')
	<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
	<script type="text/javascript">
		$(".select2").select2();

		function agregar()
		{
			var texto = $('#textodetalle').val();
			var data = '<option value="'+texto+'">'+ texto +'</option>'
		 	$("#datosselect").append(data);
		 	$("#deta").val("");
		 	var lista = "";
		 	$("#datosselect option").each(function(){
		 		lista = lista+ $(this).text() + '^';
    		});
    		$("#deta").val(lista);
    		$('#textodetalle').val("");
		}

		function removeritem() {
		    var x = document.getElementById("datosselect");
		    x.remove(x.selectedIndex);
		    $("#deta").val("");
		 	var lista = "";
		 	$("#datosselect option").each(function(){
		 		lista = lista+ $(this).text() + '^';
    		});
    		$("#deta").val(lista);
		}


	</script>
@endsection
