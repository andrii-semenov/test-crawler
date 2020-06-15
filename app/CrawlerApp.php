<?php namespace Fizik;

use Fizik\CliInterface\CliInterfaceClass;
use Fizik\Crawler\Crawler;
use Fizik\ReportDispatcher\ReportDispatcher;

/**
* Класс для CrawlerApp
*
* Задает логику приложения. Реализует CrawlerAppAbstract
*
* @property CliInterfaceClass $cli_interface экземпляр класса обработчика коммандной строки
* @property Crawler $crawler экземпляр класса crawler-a
* @property ReportDispatcher $report_dispatcher экземпляр класса обработчика отчетов
* @property string $url хранит переданный url
* @property array $params хранит переданные параметры
*
* @todo Реализовать обработку дополнительных параметров и нескольких сайтов
*/
class CrawlerApp extends CrawlerAppAbstract
{
    private $cli_interface, $crawler, $report_dispatcher, $url, $params;

    /**
    * Сначала обработка входных данных, затем crawling, затем обработка отчета
    *
    * @param array $argv массив переданых аргументов
    * @return void
    */
    public function run(array $argv): void
    {
        $this->dispatchCli($argv);

        $report = $this->dispatchCrawler();

        $this->dispatchReportSaver($report);
    }

    /**
    * Метод для обработчика аргументов из коммандной строки.
    *
    * Создает экземпляр класса обработчика, инициализирует
    * переданные url и параметры.
    *
    * @param array $argv массив переданых аргументов
    * @return void
    */
    private function dispatchCli(array $argv): void
    {
        $this->cli_interface = $this->cli_interface ?? new CliInterfaceClass($argv);
        $this->url = $this->cli_interface->getParsedUrl();
        $this->params =  $this->cli_interface->getParsedParams();
    }

    /**
    * Метод для самой реализации crawling-a.
    *
    * Создает экземпляр класса crawler-a, возвращает отчет.
    *
    * @return array отчет в формате ['url'=>..., 'count_img'=>..., 'time'=>...]
    */
    private function dispatchCrawler(): array
    {
        echo "Creating crawler instance...\n";
        $this->crawler = $this->crawler ?? new Crawler($this->params['method']);
        echo "Crawling $this->url...";
        return $this->crawler->crawl($this->url);
    }

    /**
    * Метод для сохранения отчета.
    *
    * Создает экземпляр класса обработчика отчетов, сохраняет отчет.
    *
    * @param array $report отчет в стиле ['url'=>..., 'count_img'=>..., 'time'=>...]
    * @return void
    */
    private function dispatchReportSaver(array $report): void
    {
        echo "Saving report...\n";
        $this->report_dispatcher = $this->report_dispatcher ?? new ReportDispatcher($this->params['save_as']);

        if($this->report_dispatcher->save($report)) {
            echo "Report saved successfully!\n";
        }
        else {
            echo "Report was not saved!\n";
        }
    }
}
