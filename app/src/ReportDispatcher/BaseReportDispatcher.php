<?php namespace Fizik\ReportDispatcher;

use Fizik\ReportDispatcher\ReportDispatcherAbstract;
/**
* Базовый класс управления обработчиков
*
* @param  $reportSaver
*/
class BaseReportDispatcher extends ReportDispatcherAbstract
{

    /**
    * Задает обработчика по переданным параметрам
    *
    * @param string $param параметр
    * @return void
    * @todo DB savers; file stream savers etc.
    */
    public function setSaverDispatcher(string $param): void
    {
        switch($param) {
            case 'html':
                $this->reportSaver = new Savers\HTMLTable();
                break;
            default:
                $this->reportSaver = new Savers\HTMLTable();
                break;
        }
    }

    /**
    * Вызов обработчика и передача ему отчета для сохранения
    *
    * @param array $report массив-отчет
    * @return bool true усли успешно
    * @todo DB savers; file stream savers etc.
    */
    public function save(array $report): bool
    {
        $name = 'report_'.date('d.m.Y').'.html';
        return $this->reportSaver->save($report, $name);
    }
}
