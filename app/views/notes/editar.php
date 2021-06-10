<h1>Editar bloco de anotação</h1>
<a href="/">Voltar</a> <br><br>

<?php

if (!empty($data['mensagem'])) :
    echo '<script>';
    foreach ($data['mensagem'] as $mensagem) :
        echo $mensagem;
    endforeach;
    echo '</script>';
endif;
?>

<br>
<form action="/notes/editar/<?= $data['registros']['id'] ?>" method="POST" enctype="multipart/form-data">
    <label for="titulo">Titulo</label><br>
    <input type="text" name="titulo" id="titulo" value="<?= $data['registros']['titulo'] ?>" />
    <label for="texto"></label><br><br>
    <textarea name="texto" id="texto" cols="30" rows="10"><?= $data['registros']['texto'] ?></textarea><br><br>

    <?php if (!empty($data['registros']['imagem'])) : ?>
        <button class="btn orange" type="submit" id="deletarImagem" name="deletarImagem">Deletar Imagem</button>
    <?php else : ?>
        <label for="foo">Arquivo</label><br>
        <input type="file" name="foo" id="foo" /><br><br>
    <?php endif; ?>

    <button class="btn blue" type="submit" id="atualizar" name="atualizar">Atualizar</button>
</form>