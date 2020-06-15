<?php namespace Fizik\CliInterface;

use Fizik\CliInterface\Interfaces\CliInterface;
use Fizik\CliInterface\CliInterfaceClassAbstract;
use Fizik\Services\CheckUrlHelper;

/**
* Класс для реализации базового функционала обработчика коммандной строки.
*
* @param CheckUrlHelper $CheckUrlHelper экземпляр класса помошника обработчика URL
*/
class BaseCliInterfaceClass extends CliInterfaceClassAbstract implements CliInterface
{
    /**
    * Метод для возврата введенного адреса.
    *
    * @return string Возвращает отпаршеный адрес
    * @todo сделать через сэттеры и геттеры
    */
    public function getParsedUrl(): string
    {
        return $this->argv[1];
    }

    /**
    * Метод для возврата введенных параметров.
    *
    * @return array Возвращает отпаршеные параметры
    * @todo добавить функционал
    */
    public function getParsedParams(): array
    {
        return [
            'method' => 'recursive',
            'save_as' => 'html'
        ];
    }


    /**
    * Метод для парсинга параметров.
    *
    * @todo сделать через экземпляры парсеров с единым интерфейсом
    */
    protected function checkInputArgs(): void
    {
        if(count($this->argv) > 1)
            $this->argParser();
        else
            $this->TerminalParser();
    }


    /**
    * Метод для парсинга параметров из коммандной строки.
    *
    * @todo сделать через экземпляры парсеров с единым интерфейсом
    */
    private function argParser(): void
    {
        //TODO: больше функциональности, добавить использование $params
        $this->CheckUrlHelper = $this->CheckUrlHelper ?? new CheckUrlHelper();
        if($this->CheckUrlHelper->checkUrl($this->argv[1]) && $this->CheckUrlHelper->checkUrlIsHTML($this->argv[1])) {
            $this->argv[1] = trim($this->argv[1], '/');
        }
        else {
            die("The given url is invalid!\n");
        }
    }

    /**
    * Метод для парсинга параметров из коммандной строки, если ничего не было введено.
    *
    * @todo сделать через экземпляры парсеров с единым интерфейсом
    */
    private function TerminalParser(): void
    {
        //TODO: сделать ввод из коммандной строки
        die("Please specify the URL!\n");
    }

}
