<?php namespace Fizik\Crawler\Dispatchers;

use Fizik\Services\{CheckUrlHelper,
                    CrawlResultParser};
/**
* Crawler в рамках рекурсивного прохода по всем ссылкам на сайте и его подадресах
*
* @param CheckUrlHelper $CheckUrlHelper Хэлпер для работы с адресами
* @param array $result хранит результаты рекурсивного обхода
* @param string $init_url хранит исходный адрес
*/
class RecursiveCrawler extends BaseDispatcher
{
    use CrawlResultParser;

    private $result = [];
    private $init_url = '';

    /**
    * Запуск рекурсивного обхода и сохранения исходного адреса
    *
    * @param string $url исходный адрес
    * @return array массив-отчет
    */
    public function crawlUrl(string $url): array
    {
        $this->init_url = $url;

        return $this->recursiveCrawl($url);
    }


    /**
    * Инициализирует нужные для обхода объекты (хэлпер и объект для работы
    * с dom-структурой) и запускает рекурсию
    *
    * @param string $url исходный адрес
    * @return array пропаршеный массив-отчет
    */
    private function recursiveCrawl(string $url): array
    {
        $dom = new \DOMDocument('1.0');

        $this->CheckUrlHelper = $this->CheckUrlHelper ?? new CheckUrlHelper();
        $this->recursiveCrawl_($url, $dom);

        return $this->parseResult($this->result);
    }


    /**
    * Осуществляет рекурсию.
    *
    * Сначала идет подсчет картинок на входной адресе $url и запись результата;
    * далее идет цикл по всем ссылкам на странице. Каждый адрес парсится:
    * если '/en/about', то он преобразуется в 'http://example.com/en/about'),
    * в противном случае - он не меняется (указания параметров через ? игнорируются).
    * Если адрес ссылки уже был просмотрен, то этот адрес пропускается,
    * если нет - записывается в статическую переменную $seen. В последнем
    * случае идет проверка является ли он подадресом исходного адреса $this->init_url
    * и если да - проверяется дает ли он html (не 404) ответ. Если да, для
    * этого адреса запускается этот же метод.
    *
    * @param string $url адрес на данном уровне рекурсии
    * @param \DOMDocument $dom объект для работы с DOM структурой данной страницы
    * @return void
    */
    private function recursiveCrawl_(string $url, \DOMDocument $dom): void
    {
        static $seen;
        static $delta_time;

        $seen[$url] = true; //нужно, чтобы первая страница была записана в массив

        $delta_time = -hrtime(true); // см. ниже
        @$dom->loadHTMLFile($url);

        $this->countImgOnPage_($url, $dom);
        $delta_time += hrtime(true);
        $this->result[$url]['time'] = $delta_time * 1e-6; //time in milliseconds
        echo 'done in '.($delta_time * 1e-6)." ms\n";

        $anchors = $dom->getElementsByTagName('a');
        foreach ($anchors as $element) {
            //можно это задавать тут, тогда будет подсчитываться время и на проверку страниц
            // $delta_time = -hrtime(true);
            $href = $element->getAttribute('href');
            $href = explode('?', $href)[0];
            $href = $this->CheckUrlHelper->makeValidUrl($href, $this->init_url);

            if(!isset($seen[$href])) {
                $seen[$href] = true;

                if($this->CheckUrlHelper->checkLocalUrl($href, $this->init_url)) {
                    if($this->CheckUrlHelper->checkUrlIsHTML($href)){
                        echo "Crawling $href...";
                        $this->recursiveCrawl_($href, $dom);
                    }
                }
            }
        }
    }


    /**
    * Подсчет кол-ва картинок на странице.
    *
    * @param string $url адрес на данном уровне рекурсии
    * @param \DOMDocument $dom объект для работы с DOM структурой данной страницы
    * @return void
    */
    private function countImgOnPage_(string $url, \DOMDocument $dom): void
    {
        $this->result[$url]['num'] = count($dom->getElementsByTagName('img'));
    }

}
