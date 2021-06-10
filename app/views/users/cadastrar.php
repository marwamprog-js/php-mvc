<h1>Cadastrar Usuário do sistema</h1>
<a href="/">Voltar</a> <br><br>

<?php 

    if(!empty($data['mensagem'])):
        foreach($data['mensagem'] as $mensagem):
            echo $mensagem . '<br>';
        endforeach;
    endif; 
?>

<br>
<form action="/users/cadastrar" method="POST">
    <label for="nome">Nome</label><br>
    <input type="text" name="nome" id="nome" /><br>
    <label for="email">E-mail</label><br>
    <input type="email" name="email" id="email" /><br>
    <label for="senha">Senha</label><br>
    <input type="password" name="senha" id="senha" /><br><br>
    <button type="submit" id="cadastrar" name="cadastrar">Cadastrar</button>
</form>