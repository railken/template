<?php

namespace Railken\Template\Generators;

use Twig;

class BaseGenerator implements GeneratorContract
{
    /**
     * Construct.
     */
    public function __construct()
    {
    }

    /**
     * Generate a view file.
     *
     * @param string $content
     *
     * @return string
     */
    public function generateViewFile($content)
    {
        $name = $this->getRandomName();

        $path = sys_get_temp_dir();

        $filename = $path.'/'.$name.'.twig';

        if (!file_exists(dirname($filename))) {
            mkdir(dirname($filename), 0755, true);
        }

        file_put_contents($filename, $content);

        return $filename;
    }

    /**
     * Get random file.
     *
     * @return string
     */
    public function getRandomName()
    {
        return sha1(rand() * rand());
    }

    /**
     * Remove a file.
     *
     * @param string $filename
     */
    public function remove(string $filename)
    {
        unlink($filename);
    }

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
        return Twig::render($filename, $data);
    }

    /**
     * Generate a file and renderd it.
     *
     * @param string $content
     * @param array  $data
     *
     * @return string
     */
    public function generateAndRender($content, $data)
    {
        $filename = $this->generateViewFile($content);
        try {
            $rendered = $this->render($filename, $data);
        } catch (\Exception $e) {
            $this->remove($filename);
            throw $e;
        }

        $this->remove($filename);

        return $rendered;
    }
}
