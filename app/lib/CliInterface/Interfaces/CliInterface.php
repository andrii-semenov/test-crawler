<?php namespace Fizik\CliInterface\Interfaces;
/**
* Интерфейс для обработчика коммандной строки
*/
interface CliInterface
{

    /**
    * Метод для возврата введенного адреса.
    *
    * @return string Возвращает отпаршеный адрес
    */
    public function getParsedUrl(): string;

    /**
    * Метод для возврата введенных параметров.
    *
    * @return array Возвращает отпаршеные параметры
    */
    public function getParsedParams(): array;
}
