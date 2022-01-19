@extends('layout.layout')

@section('content')

<!-- conteúdo -->

@if(session('categoriaApagada'))
<div class="alert alert-success" role="alert">
    {{ session('categoriaApagada') }}
</div>
@endif

@if(sizeof($categorias) == 0)
<div class="alert alert-primary" role="alert">
    Você não tem nenhuma categoria registrada
</div>
@endif

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th scope="col"><small class="font-weight-bold">Categorias<small></th>
            </tr>
        </thead>
        <tbody>
            @foreach($categorias as $categoria)
            <tr class="shadow-sm">
                <td><span class="d-block" style="margin: 1%; font-size:18px;">{{ $categoria->categoria }}</span></td>
                <td class="align-middle"><button type="button" id="btn{{ $categoria->id }}" class="btn btn-outline-danger" data-toggle="modal" data-target="#apagar{{ $categoria->id }}" data-id="<?php echo $categoria->id ?>" data-categoria="<?php echo $categoria->categoria ?>">
                        Excluir
                    </button></td>
            </tr>

            <!-- Modal Apagar-->
            <div class="modal fade" id="apagar{{ $categoria->id }}" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="TituloModalCentralizado{{ $categoria->id }}">Tem certeza que deseja apagar?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action={{ route('dashboard.categorias.apagar') }} method="post">
                            @csrf
                            @method('delete')
                            <div class="modal-body">
                                <input type="text" class="form-control" name="id" id="id{{ $categoria->id }}" placeholder="id" value="" style="display: none">
                                <input type="text" class="form-control" name="categoria" id="categoria{{ $categoria->id }}" placeholder="categoria" value="" style="display: none">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-outline-danger">Apagar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                $('#btn{{ $categoria->id }}').click(function() {

                    button = document.querySelector('#btn{{ $categoria->id }}')

                    var id = button.dataset.id
                    var categoria = button.dataset.categoria

                    var idModal = document.querySelector('#id{{ $categoria->id }}')
                    var categoriaModal = document.querySelector('#categoria{{ $categoria->id }}')

                    idModal.value = id
                    categoriaModal.value = categoria
                })
            </script>
            @endforeach
        </tbody>
    </table>
</div>

@endsection