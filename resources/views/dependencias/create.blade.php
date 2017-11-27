@extends('template.pages.main')

@section('title')
    Nuevo Estructura Orgánica
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Crear Estructura
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

	{!! Form::open(['route' => 'dependencias.store' , 'method' => 'POST', 'onsubmit' => 'return validar()'])!!}
<!--		        
	<div class="form-group">
     	<label>Oficina Dependiente</label>
        <select name='cod_padr' class="form-control select2" style="width: 100%;">
        		<option value="" selected="selected">Ninguno</option>
          	@foreach($orgs as $orga)
				<option value="{{$orga->cod_orga}}">{{$orga->nom_orga}}</option>
            @endforeach
        </select>
    </div>
-->

	<div class='form-group'>
		{!! Form::label('cod_orga', 'Código')!!}
		{!! Form::text('cod_orga', null, ['class' => 'form-control' , 'placeholder' => '', 'required' , 
		'pattern' => '^[0-9]+[0-9.]*$' , 'title'=>'Solo se permiten números y puntos', 'id'=> 'cod_orga'])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('nom_orga', 'Nombre')!!}
		{!! Form::text('nom_orga', null, ['class' => 'form-control' , 'placeholder' => '', 'required', 
		'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 
		'title'=>'El campo no puede estar en blanco'])!!}
	</div>

<!--
	<div class='form-group'>
		{!! Form::label('cod_nive', 'Nivel')!!}
		{!! Form::number('cod_nive', null, ['class' => 'form-control' , 'placeholder' => '', 'min'=>'0', ])!!}
	</div>
-->

	<div id="cursos" class='form-group' >
		{!! Form::label('ind_esta', 'Estado')!!}
		{!! Form::select('ind_esta', ['A'=>'Activado', 'D'=>'Desactivado'] , null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opcion', 'required'])!!}
	</div>	

	 <div class='form-group'>
                {!! Form::label('PATH', 'Ruta')!!}
                {!! Form::text('PATH', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
        </div>


	<div class='form-group'> 
		{!! Form::submit('Registrar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection

@section('js')
	<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
	<script type="text/javascript">
		  $(".select2").select2();
		function validar()
		{
			var status = "Y";
			var codigo = $("#cod_orga").val();
			for(i=0; i<codigo.length; i++) 
			{
				if(codigo.charAt(i) == ".")
				{
					if(codigo.charAt(i+1) == ".")
                                	{
						status = "N";
					}
				}
				//alert(i + ': ' + codigo.charAt(i));
			}
			if(codigo.charAt(codigo.length-1) == ".")
			{ status = "N";}
			if(status == "N")
			{
				alert("El código ingresado no es valido");
				return false;
			}
			else{
			return true;
			}
		}
	</script>
@endsection
