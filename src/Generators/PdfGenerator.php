<?php

namespace Railken\Template\Generators;

use Dompdf\Dompdf;
use Twig;

class PdfGenerator extends BaseGenerator
{
    /**
     * Render a file.
     *
     * @param string $filename
     * @param array  $data
     *
     * @return string
     */
    public function render($filename, $data)
    {
        $html = Twig::render($filename, $data);

        $dir = sys_get_temp_dir()."/dompdf";

        if (!file_exists($dir)) {
            mkdir($dir);
        }

        $dompdf = new Dompdf([
            'temp_dir' => $dir,
            'font_cache' => $dir,
            'fond_dir' => $dir,
            'enable_remote' => true
        ]);

        $dompdf->loadHtml($html);
        $dompdf->render();

        return $dompdf->output();
    }
}
