<?php

use App\core\Controller;
use App\Auth;

class Notes extends Controller
{
    public function criar()
    {
        Auth::checkLogin();

        $mensagem = [];

        if (isset($_POST['cadastrar'])) {

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

                //UPLOAD DE ARQUIVOS

                $storage = new \Upload\Storage\FileSystem('assets/img');

                $file = new \Upload\File('foo', $storage);

                // Optionally you can rename the file on upload
                $new_filename = uniqid();
                $file->setName($new_filename);

                // Validate file upload
                // MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
                $file->addValidations(array(
                    // Ensure file is of type "image/png"
                    new \Upload\Validation\Mimetype('image/png'),

                    //You can also add multi mimetype validation
                    //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

                    // Ensure file is no larger than 5M (use "B", "K", M", or "G")
                    new \Upload\Validation\Size('5M')
                ));

                // Dados do upload da imagem.
                $data = array(
                    'name'       => $file->getNameWithExtension(),
                    'extension'  => $file->getExtension(),
                    'mime'       => $file->getMimetype(),
                    'size'       => $file->getSize(),
                    'md5'        => $file->getMd5(),
                    'dimensions' => $file->getDimensions()
                );

                // echo '<pre>';
                // var_dump($data);
                // die;


                // Try to upload file
                try {
                    // Success!
                    $file->upload();

                    $note = $this->model('Note');
                    $note->titulo = $_POST['titulo'];
                    $note->texto = $_POST['texto'];
                    $note->imagem = $data['name'];

                    $mensagem[] = $note->save();
                } catch (\Exception $e) {
                    // Fail!
                    $errors = $file->getErrors();
                    foreach ($errors as $erro) {
                        $mensagem[] = $erro;
                    }
                }
            }
        }

        $this->view('notes/criar', $dados = ['mensagem' => $mensagem]);
    }

    public function editar($id)
    {

        Auth::checkLogin();

        $mensagem = [];
        $note = $this->model('Note');

        if (isset($_POST['atualizar']) || isset($_POST['deletarImagem'])) {

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

                $note = $this->model('Note');

                if (isset($_FILES['foo']['name']) && !empty($_FILES['foo']['name'])) {
                    //UPLOAD DE ARQUIVOS

                    $storage = new \Upload\Storage\FileSystem('assets/img');

                    $file = new \Upload\File('foo', $storage);

                    // Optionally you can rename the file on upload
                    $new_filename = uniqid();
                    $file->setName($new_filename);

                    // Validate file upload
                    // MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
                    $file->addValidations(array(
                        // Ensure file is of type "image/png"
                        new \Upload\Validation\Mimetype('image/png'),

                        //You can also add multi mimetype validation
                        //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

                        // Ensure file is no larger than 5M (use "B", "K", M", or "G")
                        new \Upload\Validation\Size('5M')
                    ));

                    // Dados do upload da imagem.
                    $data = array(
                        'name'       => $file->getNameWithExtension(),
                        'extension'  => $file->getExtension(),
                        'mime'       => $file->getMimetype(),
                        'size'       => $file->getSize(),
                        'md5'        => $file->getMd5(),
                        'dimensions' => $file->getDimensions()
                    );

                    // echo '<pre>';
                    // var_dump($data);
                    // die;

                    // Success!
                    $file->upload();


                    $note->imagem = $data['name'];
                }

                
                $note->titulo = $_POST['titulo'];
                $note->texto = $_POST['texto'];

                $mensagem[] = $note->update($id);
            }

            // echo '<pre>';
            // var_dump($_POST);die;

            if (isset($_POST['deletarImagem'])) {
                $imagem = $note->findId($id);
                unlink("assets/img/" . $imagem['imagem']);
                $mensagem[] = $note->deleteImage($id);
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
