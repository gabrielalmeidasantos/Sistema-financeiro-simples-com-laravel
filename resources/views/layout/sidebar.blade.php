<div id="sidebar-container" class="bg-light border-right">
    <div class="logo">
        <h4 class="font-weight-bold mb-0">Finance Adviser</h4>
    </div>
    <div class="menu list-group-flush">
        <a href={{ route('dashboard.index') }} class="list-group-item list-group-item-action text-muted bg-light p-3 border-0"><i class="icon ion-md-apps lead mr-2"></i> Início</a>
        <a href={{ route('dashboard.dinheiro') }} class="list-group-item list-group-item-action text-muted bg-light p-3 border-0 "><i class="icon ion-md-cash lead mr-2"></i> Seu dinheiro</a>
        <a href={{ route('dashboard.atividades') }} class="list-group-item list-group-item-action text-muted bg-light p-3 border-0 "><i class="icon ion-md-stats lead mr-2"></i> Atividades</a>
        <a href={{ route('dashboard.categorias') }} class="list-group-item list-group-item-action text-muted bg-light p-3 border-0 "><i class="icon ion-md-stats lead mr-2"></i> Categorias</a>
        <a href={{ route('login.logout') }} class="list-group-item list-group-item-action text-muted bg-light p-3 border-0"> <i class="icon ion-md-log-out lead mr-2"></i> Encerrar sessão</a>
    </div>
</div>