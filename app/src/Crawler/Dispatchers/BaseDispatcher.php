<?php namespace Fizik\Crawler\Dispatchers;

use Fizik\Crawler\Interfaces\CrawlerDispatcherInterface;
/**
* Базовый класс crawler-ов
*/
class BaseDispatcher implements CrawlerDispatcherInterface
{
    /**
    * Тривиальная реализация метода обработки url
    *
    * @param string $url адрес для crawling-a
    * @return array отчет
    */
    public function crawlUrl(string $url): array
    {
        return [
            'url' => '',
            'count_img' => '',
            'time' => ''
        ];
    }

}
