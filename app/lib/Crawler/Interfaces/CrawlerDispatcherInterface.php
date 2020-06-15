<?php namespace Fizik\Crawler\Interfaces;

/**
* Интерфейс для обработчиков crawling-a
*/
interface CrawlerDispatcherInterface
{
    /**
    * Входной метод для обработчиков
    *
    * @param string $url адрес для crawling-a
    * @return array отчет
    */
    public function crawlUrl(string $url): array;
}
