<?php namespace Fizik\ReportDispatcher\Savers;

/**
* Обработчик, сохраняющий отчет в виде html таблицы
*
* @param CheckUrlHelper $CheckUrlHelper Хэлпер для работы с адресами
* @param array $result хранит результаты рекурсивного обхода
* @param string $init_url хранит исходный адрес
*/
class HTMLTable extends BaseSaver
{

    /**
    * Создает html таблицу и сохраняет в файл
    *
    * @param array $data массив-отчет
    * @param string $name имя файла для сохранения
    * @return bool true если успешно
    */
    public function save(array $data, string $name): bool
    {
        return $this->fileSaver(
            $name,
            $this->constructHTMLTable($data)
        );
    }

    /**
    * Создает html таблицу
    *
    * @param array $data массив-отчет
    * @return string html всей страницы
    */
    protected function constructHTMLTable(array $data): string
    {
        $html = $this->getHTMLHeader();
        $html .= $this->getHTMLTable($data);
        $html .= $this->getHTMLFooter();
        return $html;
    }

    /**
    * Создает саму html таблицу
    *
    * @param array $data массив-отчет
    * @return string html таблицы
    */
    protected function getHTMLTable(array $data): string
    {
        $html = '<table border="1"><tr>';

        foreach(array_keys($data[0]) as $key) {
            $html .= "<th>$key</th>";
        }
        $html .= '</tr>';

        foreach ($data as $val) {
            $html .= '<tr>';
            foreach ($val as $subval) {
                $html .= "<td>$subval</td>";
            }
            $html .= '</tr>';
        }

        $html .= '</table>';
        return $html;
    }

    /**
    * Создает заголовок html
    *
    * @return string html заголовок
    */
    protected function getHTMLHeader(): string
    {
        return <<<EOD
            <!DOCTYPE html>
            <html>
                <body>
                <p>Time is in milliseconds</p>
        EOD;
    }

    /**
    * Создает footer html
    *
    * @return string html footer
    */
    protected function getHTMLFooter(): string
    {
        return <<<EOD
            </body>
            </html>
        EOD;
    }

}
