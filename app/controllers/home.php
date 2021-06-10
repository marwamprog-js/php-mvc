<?php

use App\Auth;
use App\core\Controller;

class Home extends Controller
{
    public function index()
    {
        $note = $this->model('Note');

        $dados = $note->getAll();

        $this->view('home/index', $dados = ['registros' => $dados]);
    }

    public function logout(){
        Auth::logout();
    }

    public function buscar()
    {
        $busca =  isset($_POST['search']) ? $_POST['search'] : $_SESSION['search'];
        $_SESSION['search'] = $busca;

        $note = $this->model('Note');
        $dados = $note->search($busca);

        $this->view('home/index', $dados = ['registros' => $dados]);
    }

    public function login()
    {
        $mensagem = [];
        $valid = 's';

        if (isset($_POST['entrar'])) {

            if (empty($_POST['email'])) {
                $valid = 'n';
                $mensagem[] = "Favor preencher o campo email";
            }

            if (empty($_POST['senha'])) {
                $valid = 'n';
                $mensagem[] = "Favor preencher o campo senha";
            }

            if ($valid == 's') {
                $email = $_POST['email'];
                $senha = $_POST['senha'];

                $mensagem[] = Auth::login($email, $senha);
            }
        }

        $this->view('home/login', $dados = ['mensagem' => $mensagem]);
    }
}
