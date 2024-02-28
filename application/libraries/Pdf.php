<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// panggil autoload dompdf nya
// require_once APPPATH.'third_party/dompdf/autoload.inc.php';
// require_once APPPATH.'third_party'
// .DIRECTORY_SEPARATOR.'dompdf'
// .DIRECTORY_SEPARATOR.'autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
class Pdf extends Dompdf{
    public function generate($html, $filename='', $paper = '', $orientation = '', $stream=TRUE)
    {   
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename.".pdf", array("Attachment" => 0));
        } else {
            return $dompdf->output();
        }
    }
}