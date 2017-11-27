@extends('template.pages.mainerror')

@section('title')
    Etiquetas
@endsection


@section('name_aplication')
    <h1>
      	Etiquetas
    </h1>
@endsection


@section('content')


		<div class="col-xs-12">
		    <div class="form-group">
		    	{!! Form::label('cod_bode', 'No. de Caja')!!}
				{!! Form::text('cod_bode', null, ['class' => 'form-control' , 'placeholder' => '', 'id' => 'cod_bode'])!!}
			</div>
	    </div>

	    <div class="col-xs-12">
			<div class='form-group'> 
				{!! Form::button('Generar',['class' => 'btn btn-primary', 'id'=>'registrar'] )!!} 
			</div>
		</div>

@endsection


@section('js')
<script type="text/javascript">
	$("#registrar").click(function () {
			var PostUri = "{{ route('fuid.pdf')}}";
			bodega = $("#cod_bode").val();

			$.ajax({
		    url: PostUri,
		    type: 'post',
		    data: {
		        cod_bode: bodega
		    },
		    headers: {
		        'X-CSRF-TOKEN': "{{ Session::token() }}", //for object property name, use quoted notation shown in second
		    },
		    success: function (data) {
		        if(data != "error")
		        {
		                urlb = "{{url('/')}}"; 
		                var url = urlb+"/documentos/etiquetas"+data+".pdf";
		                window.open(url, "", "width=800,height=800");
		        }

		    }
		});
	});
</script>

@endsection
