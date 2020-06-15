<?php namespace Fizik\Crawler;

use Fizik\Crawler\Interfaces\CrawlerInterface;
use Fizik\Crawler\CrawlerAbstract;
/**
* Crawler в рамках рекурсивного прохода по всем ссылкам на сайте и его подадресах
*
* @todo доделать использование wget
*/
class BaseCrawler extends CrawlerAbstract implements CrawlerInterface
{
    /**
    * Базовый функционал для задания обработчика crawling-a
    *
    * @param string $param идентефикатор crawler-a
    * @return void
    */
    public function setDispatcher(string $param): void
    {
        switch($param) {
            case 'recursive':
                $this->dispatcher = new \Fizik\Crawler\Dispatchers\RecursiveCrawler();
                break;
            //TODO: доделать использование wget
            //case 'wget':
            // exec("wget -r -l0 --follow-tags=a -P ".__DIR__."/app/tmp/ \
            //     --header='Accept: text/html' --reject '*.zip,*.rar,*.doc,*.js,*.css,*.ico,*.txt,*.gif,*.jpg,*.jpeg,*.png,*.mp3,*.pdf,*.tgz,*.flv,*.avi,*.mpeg,*.iso' --ignore-tags=img,link,script ".$argv[1]);
            //
            default:
                $this->dispatcher = new \Fizik\Crawler\Dispatchers\RecursiveCrawler();
                break;
        }
    }

    /**
    * Точка запуска обработчика crawling-a
    *
    * @param string $url входной адрес
    * @return array массив-отчет
    */
    public function crawl(string $url): array
    {
        return $this->dispatcher->crawlUrl($url);
    }

}
