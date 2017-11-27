@extends('template.pages.main')

@section('title')
    Nueva Descripción Subseries
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
	<link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Crear Descripción Subseries
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

	{!! Form::open(['route' => 'meta.store' , 'method' => 'POST'])!!}
	
	<div class="col-xs-12">
		<div class="form-group">    
			<div class="row">
				<div class="col-xs-6">
					<input type="text" value="{{$subserie->cod_seri}}" name="cod_seri" style="display:none">
			        <select id="cod_seri" name='cod_seriS' class="form-control select2" style="width: 100%;" disabled onchange="cargarSubs()">>
			        	<option value="">Seleccione una serie</option>
				        @foreach($seris as $seri)
				        	@if($subserie->cod_seri == $seri->cod_seri)

								<option value="{{$seri->cod_seri}}" selected>{{$seri->nom_seri}}</option>
							@else
								<option value="{{$seri->cod_seri}}">{{$seri->nom_seri}}</option>
							@endif
				        @endforeach
				    </select>
				</div>
				<div class="col-xs-6">
				    <select id="cod_subs" name='cod_subs' class="form-control select2" style="width:100%;">
				      	<option value="">Seleccione una subserie</option>
				    </select>
			    </div>
			</div>
	    </div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met1', 'met1')!!}
			{!! Form::text('met1', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met2', 'met2')!!}
			{!! Form::text('met2', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met3', 'met3')!!}
			{!! Form::text('met3', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met4', 'met4')!!}
			{!! Form::text('met4', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met5', 'met5')!!}
			{!! Form::text('met5', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met6', 'met6')!!}
			{!! Form::text('met6', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met7', 'met7')!!}
			{!! Form::text('met7', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met8', 'met8')!!}
			{!! Form::text('met8', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met9', 'met9')!!}
			{!! Form::text('met9', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>
	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met10', 'met10')!!}
			{!! Form::text('met10', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>
	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met11', 'met11')!!}
			{!! Form::text('met11', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
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
		function cargarSubs()
		{
			var cod_seri = $("#cod_seri").val();
			var PostUri = "{{ route('seris.buscarccd')}}"; 

			$.ajax({
			    url: PostUri,
			    type: 'post',
			    data: {
			        cod_seri: cod_seri
			    },
			    headers: {
			        'X-CSRF-TOKEN': "{{ Session::token() }}", //for object property name, use quoted notation shown in second
			    },
			    success: function (data) {
			    	var comilla = '"';
			    	if(data != "<option value="+comilla+comilla+">Seleccione una subserie</option>")
			    	{
			    	
			    		$("#cod_subs").attr('required', 'required');
			    	}
			    	else
			    	{
			    		$("#cod_subs").removeAttr('required');
			    	}

		
			        $("#cod_subs").html(data); 

			    }
			});

		}
	</script>
@endsection
