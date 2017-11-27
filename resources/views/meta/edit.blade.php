@extends('template.pages.main')

@section('title')
    Editar Descripción Subseries
@endsection


@section('name_aplication')
    <h1>
        Editar Descripción Subseries
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
	{!! Form::open(['route' => 'meta.actualizar' , 'method' => 'POST'])!!}
	<input type="text" value="{{$ccdf->num_regi}}" name="num_regi" style="display:none">
	
	    <div class="row">
            <div class="col-xs-6">
               	<div class="form-group">
		            @foreach($seris as $ser)
						@if($ccdf->cod_seri == $ser->cod_seri)
							<label>Serie:  {{$ser->cod_seri}} - {{$ser->nom_seri}}</label>								
						@endif
					@endforeach 
					<br/>
					
					 @foreach($ccdo as $serw)
					 	@if($ccdf->cod_subs  != null)
							@if($ccdf->cod_subs == $serw->cod_subs && $ccdf->cod_seri == $serw->cod_seri)
								<label>Subserie:  {{$serw->cod_subs}} - {{$serw->nom_subs}}</label>								
							@endif
						@endif
					@endforeach 
		        </div>
            </div>

            <div class="col-xs-6">
               	<div class="form-group">
		           
		        </div>
            </div>
        </div>

		<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met1', 'Metadato 1')!!}
			<?php 
				$met1 = null;
				$met2 = null;
				$met3 = null;
				$met4 = null;
				$met5 = null;
				$met6 = null;
				$met7 = null;
				$met8 = null;
				$met9 = null;
				$met10 = null;
				$met11 = null;
				if($ccd != null)
				{
					$met1 = $ccd->met1;
					$met2 = $ccd->met2;
					$met3 = $ccd->met3;
					$met4 = $ccd->met4;
					$met5 = $ccd->met5;
					$met6 = $ccd->met6;
					$met7 = $ccd->met7;
					$met8 = $ccd->met8;
					$met9 = $ccd->met9;
					$met10 = $ccd->met10;
					$met11 = $ccd->met11;
				}

			?>
		
			{!! Form::text('met1', $met1, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met2', 'Metadato 2')!!}
			{!! Form::text('met2', $met2, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>
	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met3', 'Metadato 3')!!}
			{!! Form::text('met3', $met3, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met4', 'Metadato 4')!!}
			{!! Form::text('met4', $met4, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>

<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met5', 'Metadato 5')!!}
			{!! Form::text('met5', $met5, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>
	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met6', 'Metadato 6')!!}
			{!! Form::text('met6', $met6, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met7', 'Metadato 7')!!}
			{!! Form::text('met7', $met7, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met8', 'Metadato 8')!!}
			{!! Form::text('met8', $met8, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met9', 'Metadato 9')!!}
			{!! Form::text('met9', $met9, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>
	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met10', 'Metadato 10')!!}
			{!! Form::text('met10', $met10, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('met11', 'Metadato 11')!!}
			{!! Form::text('met11', $met11, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>

	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection
