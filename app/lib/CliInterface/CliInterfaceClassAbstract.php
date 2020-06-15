<?php namespace Fizik\CliInterface;
/**
* Абрстактный класс  для обработчика коммандной строки.
*
* @param array $argv хранит переданные параметры из коммандной строки
*/
abstract class CliInterfaceClassAbstract
{
    protected $argv;

    public function __construct(array $argv)
    {
        $this->argv = $argv;
        $this->checkInputArgs();
    }

    /**
    * Метод для обратки всех введенных параметров.
    *
    * @return void
    */
    abstract protected function checkInputArgs(): void;
}
