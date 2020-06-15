<?php namespace Fizik\ReportDispatcher;

/**
* Абрстактный класс  для управления обработчиками отчетов.
*
* @param SaverInterface $reportSaver хранит обработчика отчетов
*/
abstract class ReportDispatcherAbstract
{
    private $reportSaver;

    public function __construct(string $param)
    {
        $this->setSaverDispatcher($param);
    }

    /**
    * Публичная функция для задания обработчика
    *
    * @param string $param тип обработчика
    * @return void
    */
    abstract public function setSaverDispatcher(string $param): void;
}
