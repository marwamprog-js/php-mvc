<?php

use App\core\Controller;
use Dompdf\Dompdf;

class Pdf extends Controller 
{
    public function index()
    {
        $dados = [];

        $dompfd = new Dompdf();
        
        ob_start();
        require "teste-pdf.php";
        $dompfd->loadHtml(ob_get_clean());
        $dompfd->setPaper("A4", "landscape");
        $dompfd->render();
        $dompfd->stream("arquivo", ['Attachment' => false]);

        $this->view('pdf/index', $dados = ['registros' => $dados]);
    }
}

?>