@extends('template.pages.main')

@section('title')
Detalle  Préstamo
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
<link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
<h1>
    Detalle Préstamos 
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

<div class='form-group col-md-6'>
    {!! Form::label('sid_ofci', 'Oficina solicitante ')!!}
    {!! Form::text('sid_ofci', $prestamos->sid_ofci, ['class' => 'form-control' , 'placeholder' => '', 'id'=>'sid_ofci', 'disabled'])!!}

</div>
<div class='form-group col-md-6'>
    {!! Form::label('nom_soli', 'Funcionario que solicita')!!}
    {!! Form::text('nom_soli', $prestamos->nom_soli, ['class' => 'form-control' , 'placeholder' => '', 'id'=>'nom_soli', 'disabled'])!!}


</div>
<div class='form-group col-md-6'>
    {!! Form::label('des_sopo', 'Soporte')!!}
    {!! Form::text('des_sopo', $prestamos->des_sopo, ['class' => 'form-control' , 'placeholder' => '', 'id'=>'des_sopo', 'disabled'])!!}
</div>
<div class='form-group col-md-6' >
    <label>Fecha entrega</label>
    <div class="input-group date">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="datepicker4" name="fec_entr" value="{{$prestamos->fec_entr}}" disabled>
    </div>
</div>

<table id='datainfo' class="table table-bordered table-hover">
    <thead>
        <th>Ítem</th>
        <th>Código</th>
        <th>Caja</th>
        <th>Carpeta</th>
        <th>Carpetas contenidas</th>
        <th>Tipo</th>
        <th>Observación</th>
        <th>Fecha solicitud</th>
    </thead>
<tbody>
    @if($detalles != null)
        @foreach($detalles as $d)
        <tr>
            <td> {{$d->sid_cod}}</td>
            <td> {{$d->cod_trd}}</td>
            <td> {{$d->sid_caja}}</td>
            <td> {{$d->sid_carp}}</td>
            <td> {{$d->sid_cont}}</td>
            <td> {{$d->sid_tipo}}</td>
            <td> {{$d->sid_obse}}</td>
            <td> {{$d->sid_obse}}</td>
            <td> {{$d->fec_soli}}</td>
        </tr>
        @endforeach

    @endif
 
</tbody>
</table>




@endsection

@section('js')
<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{ asset('template/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript">
$(function () {
$('#datainfo').DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    dom: 'Bfrtip',
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

</script>


@endsection
