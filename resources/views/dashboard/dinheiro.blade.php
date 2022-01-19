@extends('layout.layout')

@section('content')

@if(session('categoriaExiste') === true)
<div class="alert alert-danger" role="alert">
    Categoria ja existe
</div>
@endif

@if(session('categoriaExiste') === false)
<div class="alert alert-success" role="alert">
    Categoria adicionada com sucesso
</div>
@endif

@if(session('saqueRealizado') === false)
<div class="alert alert-danger" role="alert">
    você não tem saldo suficiente para realizar este saque
</div>
@endif

@if(session('saqueRealizado') === true)
<div class="alert alert-success" role="alert">
    Saque realizado
</div>
@endif

@if(session('depositoRealizado') === true)
<div class="alert alert-success" role="alert">
    Deposito realizado
</div>
@endif


<div class="row">
    <div class="col-lg-4">
        <div class="card d-inline-block border-0 shadow-sm shadow-hover w-100 mr-3 mb-5">
            <div class="card-body">
                <h5 class="mb-0">Dinheiro disponível</h5>
                <br>
                <h5 class="mb-0 text-success">R$ {{ $saldo->saldo }}</h5>
                <br>
                <div class="mb-2">
                    <button style="width:45%;" data-target=" #modalDeposito" data-toggle="modal" class="badge badge-primary text-primary mr-1 btn deposito" type="button">Fazer deposito</button>
                    <button style="width:45%;" data-target="#modalSaque" data-toggle="modal" class="badge badge-primary text-primary mr-1 btn saque" type="button">Fazer saque</button>
                </div>
                <div class="">
                    <button style="width:90%;" data-target="#modalCategoria" data-toggle="modal" class="badge badge-primary text-primary mr-1 btn saque" type="button">Adicionar categoria</button>
                </div>
            </div>
        </div>
    </div>
    <!--  -->
    <div class="col-xl-8 col-lg-8" style="margin-top: -20px">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="3"><small class="font-weight-bold">Atividades recentes<small></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    @foreach($transacoes as $transacao)

                    @if($transacao->tipo_transacao == 1)
                    <tr class="shadow-sm">
                        <td><img src="<?php echo asset('img/negativo.png') ?>" class="img-fluid rounded-circle avatar" alt="" /></td>
                        <td><span class="d-block text-danger" style="margin-top: 5%">Saque</span></td>
                        <td class="align-middle"><span class="badge badge-primary text-primary"><?php
                                                                                                $data = $transacao->data;
                                                                                                $data = new DateTime($data);
                                                                                                echo $data->format('d/m/y');
                                                                                                ?></span></td>
                        <td class="align-middle"><span class="badge badge-secondary text-danger"> R$ {{ $transacao->valor }} <i class="icon ion-md-cash ml-2"></i></span></td>
                    </tr>
                    @endif

                    @if($transacao->tipo_transacao == 2)
                    <tr class="shadow-sm">
                        <td><img src="<?php echo asset('img/positivo.png') ?>" class="img-fluid rounded-circle avatar" alt="" /></td>
                        <td><span class="d-block text-success" style="margin-top: 5%">Deposito</span></td>
                        <td class="align-middle"><span class="badge badge-primary text-primary"><?php
                                                                                                $data = $transacao->data;
                                                                                                $data = new DateTime($data);
                                                                                                echo $data->format('d/m/y');
                                                                                                ?></span></td>
                        <td class="align-middle"><span class="badge badge-secondary text-success"> R$ {{ $transacao->valor }} <i class="icon ion-md-cash ml-2"></i></span></td>
                    </tr>
                    @endif

                    @if($i == 6 )
                    @break;
                    @endif

                    <?php $i++ ?>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--  -->

<!-- modal depositar -->
<!-- Modal -->
<div class="modal fade" id="modalDeposito" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <!--Content-->
        <div class="modal-content form-elegant">
            <!--Header-->
            <div class="modal-header text-center">
                <h3 class="modal-title w-100 dark-grey-text font-weight-bold my-3" id="myModalLabel"><strong>Depositar</strong></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--Body-->
            <div class="modal-body mx-4">
                <!--Body-->
                <form action={{ route('dashboard.transacao.Depositar') }} method="post">
                    @csrf
                    <div class="md-form mb-5">
                        <label data-error="wrong" data-success="right" for="Form-email1">Valor:</label>
                        <input type="number" class=" form-control validate input" name="valor" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Categoria</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="categoria" required>
                            <option value="" selected hidden disabled>Selecionar categoria</option>
                            <option value="Sem categoria">Sem categoria</option>
                            @foreach($categorias as $categoria)
                            <option value="{{ $categoria->categoria }}">{{ $categoria->categoria }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label data-error="wrong" data-success="right" for="Form-email1">Detalhes:</label>
                    <textarea cols="30" rows="10" name="descricao" required></textarea>

                    <div class="text-center mb-3">
                        <button type="submit" class="btn blue-gradient btn-block btn-rounded z-depth-1a">Depositar</button>
                    </div>
                </form>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<!-- Modal -->
<!--  fim modal depositar -->

<!-- modal saque -->
<div class="modal fade" id="modalSaque" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <!--Content-->
        <div class="modal-content form-elegant">
            <!--Header-->
            <div class="modal-header text-center">
                <h3 class="modal-title w-100 dark-grey-text font-weight-bold my-3" id="myModalLabel"><strong>Sacar</strong></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--Body-->
            <div class="modal-body mx-4">
                <!--Body-->
                <form action={{ route('dashboard.transacao.sacar') }} method="post">
                    @csrf
                    <div class="md-form mb-5">
                        <label data-error="wrong" data-success="right" for="Form-email1">Valor:</label>
                        <input type="number" class=" form-control validate input" name="valor" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Categoria</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="categoria" required>
                            <option value="" selected hidden disabled>Selecionar categoria</option>
                            <option value="Sem categoria">Sem categoria</option>
                            @foreach($categorias as $categoria)
                            <option value="{{ $categoria->categoria }}">{{ $categoria->categoria }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label data-error="wrong" data-success="right" for="Form-email1">Detalhes:</label>
                    <textarea cols="30" rows="10" name="descricao" required></textarea>

                    <div class="text-center mb-3">
                        <button type="submit" class="btn blue-gradient btn-block btn-rounded z-depth-1a">Retirar dinheiro</button>
                    </div>
                </form>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<!--  fim modal sacar -->

<!--  -->
<div class="modal fade" id="modalCategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <!--Content-->
        <div class="modal-content form-elegant">
            <!--Header-->
            <div class="modal-header text-center">
                <h3 class="modal-title w-100 dark-grey-text font-weight-bold my-3" id="myModalLabel"><strong>Adicionar categoria</strong></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--Body-->
            <div class="modal-body mx-4">
                <!--Body-->
                <form action={{ route('dashboard.categorias.adicionar') }} method="post">
                    @csrf
                    <div class="md-form mb-5">
                        <label data-error="wrong" data-success="right" for="Form-email1">Categoria:</label>
                        <input type="text" class=" form-control validate input" name="categoria" required>
                    </div>

                    <div class="text-center mb-3">
                        <button type="submit" class="btn blue-gradient btn-block btn-rounded z-depth-1a">Adicionar categoria</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection