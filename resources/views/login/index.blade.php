<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo asset('css/style-login.css') ?>" />
    <link rel="sortcut icon" href="<?php echo asset('img/Shortcut.png') ?>" type="image/png" />

    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action={{ route('login.auth') }} method="POST" class="sign-in-form">
                    @if(session('incorreto'))
                    <div style='color:red'>
                        {{ session('incorreto') }}
                    </div>
                    @endif

                    @if(session('userExists'))
                    <div style='color:red'>
                        <span>Usuário já cadastrado</span>
                    </div>
                    @endif

                    @if(session('userExists') === false)
                    <div style='color:green'>
                        <span>Usuário cadastrado com sucesso</span>
                    </div>
                    @endif

                    @csrf
                    <h2 class="title">Fazer login</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" name="email" placeholder="Email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Senha" minlength="8" maxlength="20" required />
                    </div>
                    <input type="submit" value="Entrar" class="btn solid" />
                </form>
                <form action={{ route('login.cadastrar') }} method="POST" class="sign-up-form">
                    @csrf
                    <h2 class="title">Criar conta</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" placeholder="nome" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="senha" minlength="8" maxlength="20" required />
                    </div>
                    <input type="submit" class="btn" value="Registrar" />
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Novo aqui ?</h3>
                    <p>
                        Crie sua conta para acessar a Finance Adviser !
                    </p>
                    <button class="btn transparent" id="sign-up-btn">Cadastrar</button>
                </div>
                <img src="./assets/img/log.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Já possui conta ?</h3>
                    <p>
                        Faça login e entre com sua conta na Finance Adviser !
                    </p>
                    <button class="btn transparent" id="sign-in-btn">Entrar</button>
                </div>
                <img src="./assets/img/register.svg" class="image" alt="" />
            </div>
        </div>
    </div>

    <script src="<?php echo asset('js/app.js') ?>"></script>
</body>

</html>