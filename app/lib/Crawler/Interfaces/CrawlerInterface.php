<?php namespace Fizik\Crawler\Interfaces;

/**
 * Интерфейс для Crawler-а
 */
interface CrawlerInterface
{
    /**
    * Публичная функция для вызова Crawler-a
    *
    * @param string $url адрес сайта для Crawler-a
    * @return array $report массив-отчет (желательно сделать это отдельно в виде класса для структурирования отчета)
    */
    public function crawl(string $url): array;
}
