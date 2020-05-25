<?php

namespace App\Service\CurrenciesParserService\Resourse;

use App\Service\CurrenciesParserService\Resourse\ResourceInterface;
use Symfony\Component\DomCrawler\Crawler;

class CurrencyDotComParser implements ResourceInterface
{
    public $resourseUrl = 'https://currency.com/ru';
    public $currency = [];

    public function makeParse(string $content)
    {
        $crawler = new Crawler($content);
        $crawler->filter('.carouselTicker__list')->first()->filter('.buy')->each(function (Crawler $node, $i) {
            $string = $node->html();
            $arraySrings = explode("<span", $string);
            foreach ($arraySrings as &$element) {
                $element = str_replace(' class="ticker__val price">', '', $element);
                $element = str_replace(' class="ticker__val change grow-down">', '', $element);
                $element = str_replace(' class="ticker__val change grow-up">', '', $element);
                $element = str_replace('</span>', '', $element);
            }
            $this->currency[] = $arraySrings;
        });

        return $this->currency;
    }
}
