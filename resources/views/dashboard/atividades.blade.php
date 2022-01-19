@extends('layout.layout')

@section('content')

<!-- pesquisa --------------------------------------------------->

<!--  -------------------------------------------------------------->

<!-- conteúdo -->
<div class="col-xl-12 col-lg-12">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="2"><small class="font-weight-bold">Atividade<small></th>
                    <th scope="col"><small class="font-weight-bold">Categoria<small></th>
                    <th scope="col"><small class="font-weight-bold">Data<small></th>
                </tr>
            </thead>
            <tbody>

            <tbody>
                @foreach($transacoes as $transacao)
                @if($transacao->tipo_transacao == 2)
                <tr class="shadow-sm">
                    <td><img src="<?php echo asset('img/positivo.png') ?>" class="img-fluid rounded-circle avatar" alt="" style="margin-top:15%;" /></td>
                    <td><span class="d-block text-success" style="margin-top: 15%">Deposito</span></td>
                    <td><span class="d-block text-secondary" style="margin-top: 10%">{{ $transacao->categoria }}</span></td>

                    <td class="align-middle"><span class="badge badge-primary text-primary">22/06/2021</span></td>
                    <td class="align-middle"><span class="badge badge-secondary text-success"> R$ {{ $transacao->valor }}<i class="icon ion-md-cash ml-2"></i></span></td>
                    <td class="align-middle"><button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#detalhes" data-descricao="{{ $transacao->descricao }}" data-data="<?php $data = $transacao->data;
                                                                                                                                                                                                        $data = new DateTime($data);
                                                                                                                                                                                                        echo $data->format('d/m/y'); ?>" data-valor="{{ $transacao->valor }}">Detalhes</button></td>
                </tr>
                @endif

                @if($transacao->tipo_transacao == 1)
                <tr class="shadow-sm">
                    <td><img src="<?php echo asset('img/negativo.png') ?>" class="img-fluid rounded-circle avatar" alt="" style="margin-top:15%;" /></td>
                    <td><span class="d-block text-danger" style="margin-top: 15%">Saque</span></td>
                    <td><span class="d-block text-secondary" style="margin-top: 10%">{{ $transacao->categoria }}</span></td>

                    <td class="align-middle"><span class="badge badge-primary text-primary">22/06/2021</span></td>
                    <td class="align-middle"><span class="badge badge-secondary text-danger"> R$ {{ $transacao->valor }}<i class="icon ion-md-cash ml-2"></i></span></td>
                    <td class="align-middle"><button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#detalhes" data-descricao="{{ $transacao->descricao }}" data-data="<?php $data = $transacao->data;
                                                                                                                                                                                                        $data = new DateTime($data);
                                                                                                                                                                                                        echo $data->format('d/m/y'); ?>" data-valor="{{ $transacao->valor }}">Detalhes</button></td>
                </tr>
                @endif
                @endforeach
            </tbody>


            <!-- Modal -->
            <div class="modal fade detalhes" id="detalhes" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="card">
                            <div class="card-header bg-primary text-center">
                                Detalhes
                            </div>
                            <div class="card-body">
                                <div>
                                    <label for="exampleFormControlInput1">Valor:</label>
                                    <label type="text" class="form-control" id="valor" readonly></label>
                                </div>

                                <div>
                                    <label for="exampleFormControlSelect1">Data:</label>
                                    <label type="text" class="form-control" id="data" readonly></label>
                                </div>
                                <div>
                                    <label for="exampleFormControlTextarea1">Descricao</label>
                                    <textarea class="form-control" id="desc" rows="7" readonly></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary text-primary" data-dismiss="modal" style="width:100%">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
            </tbody>
        </table>
    </div>
</div>

<script>
    $("#detalhes").on("show.bs.modal", function(event) {
        var button = $(event.relatedTarget); // Botão que acionou o modal
        var valor = button.data("valor");
        var data = button.data("data"); // Extrai informação dos atributos data-*
        var descricao = button.data("descricao");
        // Se necessário, você pode iniciar uma requisição AJAX aqui e, então, fazer a atualização em um callback.
        // Atualiza o conteúdo do modal. Nós vamos usar jQuery, aqui. No entanto, você poderia usar uma biblioteca de data binding ou outros métodos.
        var modal = $(this);
        modal.find("#valor").text(valor);
        modal.find("#data").text(data);
        modal.find("#desc").text(descricao);
    });
</script>

@endsection