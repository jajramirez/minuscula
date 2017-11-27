@extends('template.pages.main')

@section('title')
    Editar Estructura Orgánica
@endsection


@section('name_aplication')
    <h1>
        Editar Estructura
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
	{!! Form::open(['route' => 'dependencias.actualizar' , 'method' => 'POST'])!!}
<!--    
    <div class="form-group">
     	<label>Oficina Dependiente</label>
        <select name='cod_padr' class="form-control select2" style="width: 100%;">
        	@if($seri->cod_padr == null)
				<option value="" selected="selected" >Ninguno</option>
			@else
				<option value="" >Ninguno</option>
			@endif
          	@foreach($orgs as $orga)
	          	@if($orga->cod_orga == $seri->cod_padr)
					<option value="{{$orga->cod_orga}}" selected="selected">{{$orga->nom_orga}}</option>
	           	@else
					<option value="{{$orga->cod_orga}}">{{$orga->nom_orga}}</option>
				@endif
            @endforeach
        </select>
    </div>
-->
	<div class='form-group'>
		{!! Form::label('cod_orga', 'Código')!!}
		{!! Form::text('cod_orga2', $seri->cod_orga, ['class' => 'form-control' , 'placeholder' => '', 'disabled'=>'disabled', ])!!}
	</div>
	<input type="text" style="display:none" name="cod_enti" value="{{$seri->cod_enti}}">
	<input type="text" style="display:none" name="cod_orga" value="{{$seri->cod_orga}}">

	<div class='form-group'>
		{!! Form::label('nom_orga', 'Nombre')!!}
		{!! Form::text('nom_orga', $seri->nom_orga, ['class' => 'form-control' , 'placeholder' => '', 'required', 
		'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 
		'title'=>'El campo no puede estar en blanco'])!!}
	</div>

<!--
	<div class='form-group'>
		{!! Form::label('cod_nive', 'Nivel')!!}
		{!! Form::number('cod_nive', $seri->cod_nive, ['class' => 'form-control' , 'placeholder' => '', 'required', 'min'=>'0'])!!}
	</div>

-->
	<div id="cursos" class='form-group' >
		{!! Form::label('ind_esta', 'Estado')!!}
		{!! Form::select('ind_esta', ['A'=>'Activado', 'D'=>'Desactivado'] , $seri->ind_esta, ['class' => 'form-control', 'placeholder' => 'Seleccione una opcion', 'required'])!!}
	</div>	

	<div class='form-group'>
                {!! Form::label('PATH', 'ruta')!!}
                {!! Form::text('PATH', $seri->PATH, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
        </div>


	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection
