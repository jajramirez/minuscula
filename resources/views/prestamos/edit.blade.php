@extends('template.pages.main')

@section('title')
Editar  Ítem
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
<link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
<h1>
    Editar Ítem
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

{!! Form::open(['route' => 'prestamo.prestamo' , 'method' => 'POST' ,'id' =>'createR'])!!}
 <input type="text" name="proceso" value="E" style="display:none">
 <input type="text" name="item" value="{{$item}}" style="display:none">
<div class='form-group col-md-12'>
    {!! Form::label('TRD', 'Código TRD')!!}

    {!! Form::text('TRD', $datos['cod_trd'], ['class' => 'form-control' , 'placeholder' => '', 'disabled', 'id' => 'TRD'])!!}
</div>

<div class="form-group col-md-4">
    <label>Oficina Productora</label>
    <select id='cod_orga' name='cod_orga' class="form-control select2" style="width: 100%;" required onchange="codigoTRD()">
        <option value="">Seleccione una opcion</option>
        @foreach($orgas as $orga)
          @if($datos['cod_orga'] == $orga->cod_orga  )
            <option selected value="{{$orga->cod_orga}}">{{$orga->nom_orga}}</option>
          @else
            <option value="{{$orga->cod_orga}}">{{$orga->nom_orga}}</option>
          @endif
        @endforeach
    </select>
</div>


<div class="form-group col-md-4">
    <label>Código Serie</label>
    <select name='cod_seri' id='cod_seri' class="form-control select2" style="width: 100%;" required onchange="cargarSubs()">
        <option value="">Seleccione una opcion</option>
        @foreach($series as $seri)
          @if($datos['cod_seri'] == $seri->cod_seri)
            <option selected value="{{$seri->cod_seri}}">{{$seri->nom_seri}}</option>
          @else
            <option value="{{$seri->cod_seri}}">{{$seri->nom_seri}}</option>
          @endif
        @endforeach
    </select>
</div>


      <div class='form-group col-md-4'>
          {!! Form::label('cod_subs', 'Sub Serie')!!}
          <input type="text" style="display:none" id="CODSUB" value="{{$datos['cod_subs']}}">
          <select id="cod_subs" name='cod_subs' class="form-control select2" style="width: 100%;" onchange="codigoTRD()">
                  <option value="">Seleccione una subserie</option>
          </select>
        </div>


<div class="col-md-4">
    <div class='form-group'>
        <div class="col-md-5">
            {!! Form::label('sid_caja', 'Caja      ')!!} 
        </div> 
        <div class="col-md-7">
            <input type="checkbox" id="sid_caja_C" name="sid_caja_C" value="Completa">Caja Completa
        </div>
        {!! Form::text('sid_caja', $datos['sid_caja'] , ['class' => 'form-control' , 'placeholder' => '', 'id'=>'sid_caja', 'required'])!!}  
    </div>
</div>
<div class="col-md-4">
    <div class='form-group'>
        {!! Form::label('sid_carp', 'Carpeta')!!}
        {!! Form::text('sid_carp', $datos['sid_carp'], ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}          
    </div>
</div>
<div class="col-md-4">
    <div class='form-group'>
        {!! Form::label('sid_cont', 'Carpetas Contenidas')!!}
        {!! Form::text('sid_cont', $datos['sid_cont'], ['class' => 'form-control' , 'placeholder' => ''])!!}          
    </div>
</div>  

<div class="col-md-4">
    <div class='form-group'>
        {!! Form::label('sid_tipo', 'Tipo')!!}
        {!! Form::text('sid_tipo', $datos['sid_tipo'], ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}  
    </div>
</div>

<div class="col-md-4">
    <div class='form-group'>
        <label>Fecha solicitud</label>
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" id="datepicker" name="fec_soli" required value="{{$datos['fec_soli']}}">
        </div>          
    </div>
</div>

<div class="col-md-4">
    <div class='form-group'>
        {!! Form::label('sid_obse', 'Observaciones')!!}
        {!! Form::text('sid_obse', $datos['sid_obse'], ['class' => 'form-control' , 'placeholder' => ''])!!}
    </div>
</div>

<div class='form-group'> 
    {!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
</div>

{!! Form::close() !!}


@endsection

@section('js')
<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{ asset('template/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript">
                   $(".select2").select2();
                   $('#datepicker').datepicker({
                       autoclose: true
                   });
                   $('#datepicker2').datepicker({
                       autoclose: true
                   });
                   $('#datepicker3').datepicker({
                       autoclose: true
                   });
                   $('#datepicker4').datepicker({
                       autoclose: true
                   });


                    $( "#sid_caja_C" ).on( "click", function() {
                      $("#sid_caja").val("");
                      var caja = $( "input:checked" ).val();
                      if(caja == "Completa")
                      {
                        $("#sid_caja").attr('disabled', 'disabled');
                        $("#sid_caja").removeAttr('required');
                      }
                      else
                      {
                         $("#sid_caja").removeAttr('disabled');
                         $("#sid_caja").attr('required', 'required');
                      }

                    });


                    window.onload=load;

                    function load()
                    {
                      cargarSubs();
                      caja();
                    }

                    function caja()
                    {
                        if($("#sid_caja").val() == "Caja Completa")
                        {
                          $("#sid_caja_C").prop( "checked", true );
                          $("#sid_caja").val("");
                          $("#sid_caja").attr('disabled', 'disabled');

                        }

                    }

                   function cargarSubs()
                   {
                       var cod_seri = $("#cod_seri").val();
                       var cod_subs = $("#CODSUB").val();
                       var cod_subs = "135";
                       codigoTRD();
                       var PostUri = "{{ route('seris.buscarccd')}}";

                       $.ajax({
                           url: PostUri,
                           type: 'post',
                           data: {
                               cod_seri: cod_seri,
                               cod_subs: cod_subs
                           },
                           headers: {
                               'X-CSRF-TOKEN': "{{ Session::token() }}", //for object property name, use quoted notation shown in second
                           },
                           success: function (data) {
                               var comilla = '"';
                               if (data != "<option value=" + comilla + comilla + ">Seleccione una subserie</option>")
                               {

                                   $("#cod_subs").attr('required', 'required');
                               } else
                               {
                                   $("#cod_subs").removeAttr('required');
                               }


                               $("#cod_subs").html(data);

                           }
                       });

                   }

                   function codigoTRD()
                   {

                       var oficina = $("#cod_orga").val();
                       var cod_seri = $("#cod_seri").val();
                       if (cod_seri.length > 0)
                       {
                           cod_seri = '.' + $("#cod_seri").val();

                       }

                       var cod_subs = $("#cod_subs").val();
                       if (cod_subs.length > 0)
                       {
                           cod_subs = '.' + $("#cod_subs").val();

                       }
                       var trd = oficina + cod_seri + cod_subs;
                       $("#TRD").val(trd);
                   }

</script>


@endsection
