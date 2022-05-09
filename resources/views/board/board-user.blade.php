@extends('voyager::master')

@section('page_title', 'Viendo Registros')

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="voyager-list"></i> Lista de Registros
                </h1>     
                <a type="button" data-toggle="modal" target="_blank" href="{{route('day.tv', $id)}}" class="btn btn-dark btn-add-new">
                    <i class="voyager-tv"></i> <span>Proyectar</span>
                </a>           
            </div>
            <div class="col-md-4">

            </div>
        </div>
        
        <div class="row">
            <div class="col-md-3">
                <span class="input-group-text texto" style="font-size:200%"><b> Categoria:<br> {{$next->category}}</b></span> 
            </div>
            <div class="col-md-3">
                <span class="input-group-text texto" style="font-size:200%"><b> Lote:<br> {{$next->lote}}</b></span> 
            </div>
            <div class="col-md-2">
                <span class="input-group-text texto" style="font-size:200%"><b> Cantidad:<br> {{$next->quantity}}</b></span> 
            </div>
            {!! Form::open(['route' => 'day.board-update','class' => 'was-validated'])!!}
            <div class="col-md-2">
                <span class="input-group-text texto" style="font-size:200%"><b> Precio:<br></b></span> 
                <input type="text" class="form-control" name="price" value="{{$next->price}}">
            </div>
            <div class="col-md-2">
                
                <input type="hidden" name="id" value="{{$next->ready_id}}">
                <input type="hidden" name="day_id" value="{{$id}}">
                <button type="submit" class="btn btn-primary btn-sm" title="Actualizar..">
                    <i class="voyager-refresh"></i>
                </button>
                {!! Form::close()!!} 
                <br>
                {!! Form::open(['route' => 'day.board-next','class' => 'was-validated'])!!}
                <input type="hidden" name="id" value="{{$next->ready_id}}">
                <input type="hidden" name="day_id" value="{{$id}}">
                <button type="submit" class="btn btn-success btn-sm" title="Siguiente..">
                    <i class="voyager-forward"></i>
                </button>
                {!! Form::close()!!} 
            </div>
            
            
        </div>
        
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        
        @include('voyager::alerts')
        
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        
                        <div class="table-responsive">
                            <table id="detalles" class="dataTables table table-hover">
                                <thead>
                                    <tr>
                                        {{-- <th class="text-center">Id&deg;</th> --}}
                                        {{-- <th class="text-center">Id&deg;</th> --}}
                                        <th class="text-center">Categoria.</th>
                                        <th class="text-center">Lote.</th>
                                        <th class="text-center">Cantidad.</th>
                                        <th class="text-center">Precio Unitario.</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i =0;
                                    @endphp
                                    @forelse($readys as $item)
                                        <tr class="text-center">
                                            {{-- <td>{{ $i}}</td> --}}
                                            {{-- <td>{{ $item->id }}</td> --}}
                                            <td>{{ $item->category->name }}</td>
                                            <td>{{ $item->lote }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>
                                                <a type="button" href="{{route('day.manual',['id'=>$item->id,'i'=>$i, 'day'=>$id] )}}" class="btn btn-success btn-sm" title="Siguiente..">
                                                    <i class="voyager-forward"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No hay registros</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('css')
    <style>
        .select2{
            width: 100% !important;
        }

        #detalles {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        #detalles td, #detalles th {
        border: 1px solid #ddd;
        padding: 8px;
        }

        #detalles tr:nth-child(even){background-color: #f2f2f2;}

        #detalles tr:hover {background-color: #ddd;}

        #detalles th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

        .form-control .select2{
            border-radius: 5px 5px 5px 5px;
            color: #000000;
            border-color: rgb(63, 63, 63);
        }
    </style>
@stop

@section('javascript')
    <script src="{{ url('js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            // $(".select2").select2({theme: "classic"});
            $('.dataTable').DataTable({
                        language: {
                            // "order": [[ 0, "desc" ]],
                            sProcessing: "Procesando...",
                            sLengthMenu: "Mostrar _MENU_ registros",
                            sZeroRecords: "No se encontraron resultados",
                            sEmptyTable: "Ningún dato disponible en esta tabla",
                            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                            sSearch: "Buscar:",
                            sInfoThousands: ",",
                            sLoadingRecords: "Cargando...",
                            oPaginate: {
                                sFirst: "Primero",
                                sLast: "Último",
                                sNext: "Siguiente",
                                sPrevious: "Anterior"
                            },
                            oAria: {
                                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            },
                            buttons: {
                                copy: "Copiar",
                                colvis: "Visibilidad"
                            }
                        },
                        order: [[ 0, 'asc' ]],
                    })

            $('#select-checkcategoria_id').select2();

          

            $('#select-checkcategoria_id').on('change', function_divs);
        });

        $('#modal_edit').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) //captura valor del data-empresa=""

                var id = button.data('id')
                var category = button.data('name')
                var lote = button.data('lote')
                var precio = button.data('precio')
                var cantidad = button.data('cant')
                // alert(category)

                var modal = $(this)
                modal.find('.modal-body #select-checkcategoria_id').val(category).trigger('change')
                modal.find('.modal-body #id').val(id)
                modal.find('.modal-body #lote').val(lote)
                modal.find('.modal-body #precio').val(precio)
                modal.find('.modal-body #cantidad').val(cantidad)
                
        });
        $('#modal_delete').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) //captura valor del data-empresa=""

                var id = button.data('id')
                
                var modal = $(this)
                modal.find('.modal-body #id').val(id)
                
        });

    </script>
    <script type="text/javascript">
        function validaNumericos(event) {
            if(event.charCode >= 48 && event.charCode <= 57){
              return true;
            }
            return false;        
        }
      </script>
@stop
