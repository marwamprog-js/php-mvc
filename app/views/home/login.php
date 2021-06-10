<h1>Fazer login</h1><br><br>

<?php 

    if(!empty($data['mensagem'])):
        foreach($data['mensagem'] as $mensagem):
            echo $mensagem . '<br>';
        endforeach;
    endif; 
?>

<br>
<form action="/home/login" method="POST">
    <label for="email">Email</label><br>
    <input type="email" name="email" id="email" ><br>
    <label for="senha">Senha</label><br>
    <input type="password" name="senha" id="senha" ><br><br>
    <button class="waves-effect waves-light btn" type="submit" name="entrar">Entrar</button>
</form>