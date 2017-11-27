@extends('template.pages.main')

@section('title')
    Nuevo CCD
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
	<link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Crear CCD
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

	{!! Form::open(['route' => 'ccd.store' , 'method' => 'POST'])!!}

	    <div class="form-group">
     	   <label>Código Serie</label>
            <select name='cod_seri' class="form-control select2" style="width: 100%;" required>
              	@foreach($seris as $seri)
					<option value="{{$seri->cod_seri}}">{{$seri->nom_seri}}</option>
                @endforeach
            </select>
        </div>


	<div class='form-group'>
		{!! Form::label('cod_subs', 'Subserie')!!}
		{!! Form::text('cod_subs', null, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
	</div> 

	<div class='form-group'>
		{!! Form::label('nom_subs', 'Nombre')!!}
		{!! Form::text('nom_subs', null, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 'title'=>'El campo no puede estar en blanco'])!!}
	</div>

	<div id="cursos" class='form-group' >
		{!! Form::label('ind_esta', 'Estado')!!}
		{!! Form::select('ind_esta', ['A'=>'Activado', 'D'=>'Desactivado'] , null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opcion', 'required'])!!}
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
	</script>
@endsection
