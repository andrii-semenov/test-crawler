<?php namespace Fizik\Crawler;
/**
* Абрстактный класс  для Crawler-а.
*
* @param CrawlerDispatcherInterface $dispatcher хранит обработчика crawling-a
*/
abstract class CrawlerAbstract
{
        public $dispatcher;

        public function __construct(string $param)
        {
            $this->setDispatcher($param);
        }

        /**
        * Публичная функция для задания Crawler-a
        *
        * @param string $param тип Crawler-a
        * @return void
        */
        abstract public function setDispatcher(string $param): void;
}
