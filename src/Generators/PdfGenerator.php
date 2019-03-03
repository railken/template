<?php

namespace Railken\Template\Generators;

use Dompdf\Dompdf;
use Dompdf\Options;
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

        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $options->setFontDir($this->resolveDirectory($dir."/lib/fonts"));
        $options->setFontCache($this->resolveDirectory($dir."/lib/fonts"));
        //$options->setRootDir($this->resolveDirectory($dir));
        //$options->setChroot($this->resolveDirectory($dir));
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->render();

        return $dompdf->output();
    }

    /**
     * @param string $dir
     *
     * @return string
     */
    public function resolveDirectory(string $dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }
}
