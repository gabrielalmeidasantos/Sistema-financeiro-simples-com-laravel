<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="sortcut icon" href="<?php echo asset('img/Shortcut.png') ?>" type="image/png" />
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    @include('layout.css')
    @include('layout.script')

    <title>Finance Adviser</title>

</head>

<body>

    <div class="d-flex" id="content-wrapper">
        @include('layout.sidebar')
        <div id="page-content-wrapper" class="w-100 bg-light-blue">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container">
                    <button class="btn btn-primary text-primary menu-toggle" id="menu-toggle" style="width:20%"><img src="<?php echo asset('img/menu.png') ?>" id="img-menu"></button>
                </div>
            </nav>
            <div id="content" class="container-fluid p-5">
                <section class="py-3">
                    @yield('content')
                </section>
            </div>
        </div>

    </div>

    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#content-wrapper").toggleClass("toggled");
        });

        $(".paginacao").click(function(e) {
            $("#content-wrapper").toggleClass("toggled");
        });
    </script>
</body>

</html>