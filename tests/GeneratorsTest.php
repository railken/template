<?php

namespace Railken\Template\Tests;

use Railken\Template\Generators;
use Spatie\PdfToText\Pdf;

class GeneratorsTest extends \Orchestra\Testbench\TestCase
{
    public function testPdfGenerator()
    {
        $generator = new Generators\PdfGenerator();
        $rendered = $generator->generateAndRender('The cake is a {{ message }}', ['message' => 'lie']);

        $tmpfile = __DIR__.'/../var/cache/dummy.pdf';

        if (!file_exists(dirname($tmpfile))) {
            mkdir(dirname($tmpfile), 0755, true);
        }

        file_put_contents($tmpfile, $rendered);

        $this->assertEquals('The cake is a lie', Pdf::getText($tmpfile));
    }

    public function testHtmlRender()
    {
        $generator = new Generators\HtmlGenerator();
        $rendered = $generator->generateAndRender('The cake is a <b>{{ message }}</b>', ['message' => 'lie']);

        $this->assertEquals('The cake is a <b>lie</b>', $rendered);
    }

    public function testTextRender()
    {
        $generator = new Generators\TextGenerator();
        $rendered = $generator->generateAndRender('The cake is a {{ message }}', ['message' => 'lie']);

        $this->assertEquals('The cake is a lie', $rendered);
    }

    protected function getPackageProviders($app)
    {
        return [
            \Railken\Template\TemplateServiceProvider::class,
        ];
    }
}
