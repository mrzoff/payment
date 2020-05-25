<?php

namespace App\Service\CurrenciesParserService;

use App\Service\CurrenciesParserService\Resourse\ResourceInterface;

class CurrenciesParser
{
    private $resourse;
    private $contentHtml;

    public function __construct(ResourceInterface $resourse)
    {
        $this->resourse = $resourse;
        $this->contentHtml = $this->getContentHtml($this->resourse->resourseUrl);
    }

    public function executeCurrenciesParser()
    {
        return $this->resourse->makeParse($this->contentHtml);
    }

    private function getContentHtml($resourseUrl)
    {
        return file_get_contents($resourseUrl);
    }
}