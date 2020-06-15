<?php namespace Fizik;
/**
* Абстрактный класс для CrawlerApp
*
* Задает интерфейс приложения
*
*/
abstract class CrawlerAppAbstract
{
    /**
    * Метод для вызова логики приложения.
    * Должен быть реализован как минимум на базовом уровне.
    *
    * @param array $argv список аргументов из коммандной строки.
    * @return void Процедурный метод.
    */
    abstract public function run(array $argv): void;
}
