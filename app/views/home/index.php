<h1>Notes</h1>

<?php if (isset($_SESSION['logado'])) { ?>
    <a href="/notes/criar" class="waves-effect waves-light btn blue">Criar bloco</a>
    <a href="/users/cadastrar" class="waves-effect waves-light btn blue">Criar Usuário</a><br><br>
<?php } ?>

<hr>

<nav>
    <div class="nav-wrapper">
        <form action="/home/buscar" method="POST">
            <div class="input-field">
                <input id="search" name="search" type="search" required>
                <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                <i class="material-icons">close</i>
            </div>
        </form>
    </div>
</nav>

<?php
if (!empty($data['mensagem'])) :
    foreach ($data['mensagem'] as $mensagem) :
        echo $mensagem . '<br>';
    endforeach;
endif;

// echo '<pre>';
// var_dump($data);die;
?>

<?php
// PAGINAÇÃO

$pagination = new \App\Pagination($data['registros'], isset($_GET['page']) ? $_GET['page'] : 1, 2);

if (empty($pagination->resultado())) {
    echo "Nenhum registro encontrado!";
} else {

?>



    <?php foreach ($pagination->resultado() as $note) { ?>
        <div class="row">
            <?php if (!empty($note['imagem'])) : ?>
                <img style="float:left; margin:0 15px 15px 0;" width="200" height="200" src="<?= URL_BASE; ?>/assets/img/<?= $note['imagem'] ?>" alt="">
            <?php endif; ?>

            <a href="/notes/ver/<?= $note['id'] ?>">
                <h2 class="light"><?= $note['titulo'] ?></h2>
            </a>

            <p><?= $note['texto'] ?></p>
            <p><?= $note['nome'] ?></p>

            <?php if (isset($_SESSION['logado'])) { ?>
                <!-- Modal Structure -->
                <div id="modal<?= $note['id'] ?>" class="modal">
                    <div class="modal-content">
                        <p>Deseja realmente excluir <?= $note['titulo'] ?></p>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class="modal-close waves-effect waves-light btn red">Não</a>
                        <a href="/notes/excluir/<?= $note['id'] ?>" class="waves-effect waves-light btn green">Sim</a>
                    </div>
                </div>

                <a href="/notes/editar/<?= $note['id'] ?>" class="waves-effect waves-light btn orange">Atualizar</a>
                <a class="waves-effect waves-light btn modal-trigger red" href="#modal<?= $note['id'] ?>">Excluir</a>
            <?php } ?>
        </div>
<?php
    }

    echo '<br><br><hr>';

    $pagination->navigator();
}


?>