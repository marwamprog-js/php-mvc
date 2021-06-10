<?php

use App\core\Controller;
use App\Auth;

class Users extends Controller
{
    public function cadastrar()
    {
        Auth::checkLogin();
        Auth::checkLoginAdmin();
       
        $mensagem = [];
        $user = $this->model('User');
        
        if(isset($_POST['cadastrar'])){

            $valid = 's';

            if(empty($_POST['nome'])){
                $valid = 'n';
                $mensagem[] = 'Favor preencher campo Nome.';
            }

            if(empty($_POST['email'])){
                $valid = 'n';
                $mensagem[] = 'Favor preencher campo E-mail.';
            }

            if(empty($_POST['senha'])){
                $valid = 'n';
                $mensagem[] = 'Favor preencher campo Senha.';
            }

            if($valid == 's'){

                $user->nome = $_POST['nome'];
                $user->email = $_POST['email'];

                $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
                $user->senha = $senha;

                $mensagem[] = $user->save();

            }

        }

        $this->view('users/cadastrar', $dados = ['mensagem' => $mensagem]);
    }

    public function editar($id)
    {

        Auth::checkLogin();

        $mensagem = [];
        $note = $this->model('Note');

        if (isset($_POST['atualizar'])) {

            $valid = 's';

            if (empty($_POST['titulo'])) {
                $valid = 'n';
                $mensagem[] = "O campo titulo está vazio!";
            }

            if (empty($_POST['texto'])) {
                $valid = 'n';
                $mensagem[] = "O campo texto está vazio!";
            }

            if ($valid == 's') {
                $note->titulo = $_POST['titulo'];
                $note->texto = $_POST['texto'];

                $mensagem[] = $note->update($id);
            }
        }

        $dados = $note->findId($id);
        
        $this->view('notes/editar', $dados = ['mensagem' => $mensagem, 'registros' => $dados]);
    }


    public function ver($id = '')
    {
        $note = $this->model('Note');

        $dado = $note->findId($id);

        $this->view('notes/ver', $dado);
    }


    public function excluir($id = '')
    {

        Auth::checkLogin();

        $mensagem = array();

        $note = $this->model('Note');
        $mensagem[] = $note->delete($id);

        $dados = $note->getAll();

        $this->view('home/index', $dados = ['registros' => $dados, 'mensagem' => $mensagem]);
    }
}
