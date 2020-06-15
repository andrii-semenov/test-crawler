<?php namespace Fizik\Services;
/**
* Трейт для парсинга результата crawler-a
*/
trait CrawlResultParser
{

    /**
    * Превращает результат crawler-a в вид ['url'=>..., 'count_img'=>..., 'time'=>...]
    *
    * @param array $result результат crawler-a
    * @return array возвращает ['url'=>..., 'count_img'=>..., 'time'=>...]
    */
    private function parseResult(array $result): array
    {
        $report = [];
        foreach ($result as $key => $val) {
            $report[] = [
                'url' => $key,
                'count_img' => $val['num'],
                'time' => $val['time']
            ];
        }
        return $report;
    }
    
}
