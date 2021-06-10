<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso MVC</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">


</head>

<body>


    <nav class="blue">
        <div class="nav-wrapper container">
            <a href="#" class="brand-logo">Bloco de Anotações</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="/home/index">Home</a></li>
                <?php if (!isset($_SESSION['logado'])) { ?>
                    <li><a href="/home/login">Login</a></li>
                <?php } else { ?>
                    <li><a href="/home/logout">Sair</a></li>
                <?php } ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php if (isset($_SESSION['logado'])) { ?>
            <p>Olá <?= $_SESSION['userNome'] ?></p>
        <?php } ?>


        <?php require_once '../app/views/' . $view . '.php'; ?>

    </div>

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        window.onload = function () { 
            M.AutoInit(); 
        }         
    </script>
</body>

</html>