@extends('template.pages.main')

@section('title')
Nuevo  Préstamo
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
<link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
<h1>
    Crear Préstamos 
    <small> </small>
</h1>
{!! Form::button('Registrar',['class' => 'btn btn-primary', 'id'=>'registrar'] )!!}

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
{!! Form::open(['route' => 'prestamo.detalle' , 'method' => 'POST' ,'id' =>'createR'])!!}
<div class="row">

    <button type="submit" class="btn btn-primary"  style="display:none">
        <span class="fa fa-plus-circle" aria-hidden="true"> </span>
    </button>  

</div>


<div class='form-group col-md-6'>
    {!! Form::label('sid_ofci', 'Oficina solicitante ')!!}
    @if($encabezado!= null)
    {!! Form::text('sid_ofci', $encabezado['sid_ofci'], ['class' => 'form-control' , 'placeholder' => '', 'id'=>'sid_ofci'])!!}
    @else
    {!! Form::text('sid_ofci', null, ['class' => 'form-control' , 'placeholder' => '', 'id'=>'sid_ofci'])!!}
    @endif
</div>
<div class='form-group col-md-6'>
    {!! Form::label('nom_soli', 'Funcionario que solicita')!!}
    @if($encabezado!= null)
    {!! Form::text('nom_soli', $encabezado['nom_soli'], ['class' => 'form-control' , 'placeholder' => '', 'id'=>'nom_soli'])!!}
    @else
    {!! Form::text('nom_soli', null, ['class' => 'form-control' , 'placeholder' => '', 'id'=>'nom_soli'])!!}
    @endif

</div>
<div class='form-group col-md-6'>
    {!! Form::label('des_sopo', 'Soporte')!!}
    @if($encabezado!= null)
    {!! Form::text('des_sopo', $encabezado['des_sopo'], ['class' => 'form-control' , 'placeholder' => '', 'id'=>'des_sopo'])!!}
    @else
    {!! Form::text('des_sopo', null, ['class' => 'form-control' , 'placeholder' => '', 'id'=>'des_sopo'])!!}
    @endif
</div>
<div class='form-group col-md-6' >
    <label>Fecha entrega</label>
    <div class="input-group date">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        @if($encabezado!= null)
        <input type="text" class="form-control pull-right" id="datepicker4" name="fec_entr" value="{{$encabezado['fec_entr']}}">
        @else
        <input type="text" class="form-control pull-right" id="datepicker4" name="fec_entr">
        @endif
      
    </div>
</div>







{!! Form::close() !!}



<table id='datainfo' class="table table-bordered table-hover">
    <thead>
        <th>Ítem</th>
        <th>No. de Caja</th>
        <th>Carpeta</th>
        <th>Tipo</th>
        <th>Observación</th>
        <th>Fecha solicitud</th>
        <th>Acción</th>
    </thead>
<tbody>
    <?php
    $item = 1;
    $index = 1;
    for ($i = 0; $i < count($datos); $i++) {
        if(array_key_exists($i, $datos)){
            $fila = $datos[$i];
            echo "<tr id='fila".$i."'>";
            echo "<td>" . $item++ . "</td>";
            echo "<td>" . $fila['cod_bode'] . "</td>";
            echo "<td>" . $fila['sid_carp'] . "</td>";
            echo "<td>" . $fila['sid_tipo'] . "</td>";
            echo "<td>" . $fila['sid_obse'] . "</td>";
            echo "<td>" . $fila['fec_soli'] . "</td>";
            echo "<td>";
       
    ?>

            <a href="#" 
                class="btn btn-danger fa fa-times" title="Eliminar Registro" 
                onclick ="eliminar(<?php echo $i ?>)"></a>  
    <?php
        echo "</td>";
        echo "</tr>";
         }
    }
    ?>  
</tbody>
</table>




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

function cargarSubs()
{
var cod_seri = $("#cod_seri").val();
codigoTRD();
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

function editar(id)
{
    alert(id);
}

function eliminar (array)
{
       $("#fila" + array).remove();

        var PostUri = "{{ route('prestamo.actualizaritem')}}";

        $.ajax({
            url: PostUri,
            type: 'post',
            data: {
                item: array,
            },
            headers: {
                'X-CSRF-TOKEN': "{{ Session::token() }}", 
            },
            success: function (data) {
            }
        });
}

function codigoTRD()
{

var oficina = $("#cod_orga").val();
var cod_seri = $("#cod_seri").val();
if (cod_seri.length > 0)prestamo
loca
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

$(document).ready(function () {

$("#registrar").click(function () {
var myRows = {myRows: []};
var $th = $('table th');
$('table tbody tr').each(function (i, tr) {
    var obj = {}, $tds = $(tr).find('td');
    $th.each(function (index, th) {
        if($(th).text() == "Ítem")
        {
            obj["num_regi"] = $tds.eq(index).text();
        }
        if($(th).text()  == "No. de Caja")
        {
            obj["sid_caja"] = $tds.eq(index).text();
        }
        if($(th).text()  == "Carpeta")
        {
            obj["sid_carp"] = $tds.eq(index).text();
        }
        if($(th).text()  == "Tipo")
        {
            obj["sid_tipo"] = $tds.eq(index).text();
        }
        if($(th).text()  == "Observación")
        {
            obj["sid_obse"] = $tds.eq(index).text();
        }
        if($(th).text()  == "Fecha solicitud")
        {
            obj["fec_soli"] = $tds.eq(index).text();
        }
    });
    myRows.myRows.push(obj);
});



var detalle = JSON.stringify(myRows);
var PostUri = "{{ route('prestamo.store')}}";
var redirect = "{{ route('prestamo.index')}}";

$.ajax({
    url: PostUri,
    type: 'post',
    data: {
        detalle: detalle,
        sid_ofci: $("#sid_ofci").val(),
        nom_soli: $("#nom_soli").val(),
        des_sopo: $("#des_sopo").val(),
        fec_entr: $("#datepicker4").val(),
    },
    headers: {
        'X-CSRF-TOKEN': "{{ Session::token() }}", //for object property name, use quoted notation shown in second
    },
    success: function (data) {
        if(data != "error")
        {
                urlb = "{{url('/')}}"; 
                var redirect = "{{ route('prestamo.index')}}";
                var url = urlb+"/documentos/prestamo"+data+".pdf";
                window.open(url, "", "width=800,height=800");
                window.location.replace(redirect);
        }

    }
});




});


$(function () {
$('#datainfo').DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    dom: 'Bfrtip',
    buttons: [
        {
            text: '<span class="fa fa-plus-circle" aria-hidden="true"> </span>',
            titleAttr: 'Añadir',
            action: function (e, dt, node, config) {
                $("#createR").submit();
            }}
    ],
    "language": {
        "lengthMenu": "Mostrando _MENU_ registros por pagina",
        "zeroRecords": "Sin resultados",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtro desde _MAX_ total registros)",
        "search": "Buscar"
    }
});
});
});

</script>


@endsection
