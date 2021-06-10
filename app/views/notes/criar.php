<h1>Criar bloco de anotação</h1>
<a href="/">Voltar</a> <br><br>

<?php 

    if(!empty($data['mensagem'])):
        foreach($data['mensagem'] as $mensagem):
            echo $mensagem . '<br>';
        endforeach;
    endif; 
?>

<br>
<form action="/notes/criar" method="POST" enctype="multipart/form-data">
    <label for="titulo">Titulo</label><br>
    <input type="text" name="titulo" id="titulo" /><br>
    <label for="texto"></label><br><br>
    <textarea name="texto" id="texto" cols="30" rows="10"></textarea><br><br>
    <label for="foo">Arquivo</label><br>
    <input type="file" name="foo" id="foo" /><br><br>
    <button class="waves-effect waves-light btn" type="submit" id="cadastrar" name="cadastrar">Cadastrar</button>
</form>