<?php namespace Fizik\ReportDispatcher\Interfaces;

/**
* Интерфейс для обработчиков сохранения отчетов
*/
interface SaverInterface
{
    /**
    * Публичная функция для вызова сохранения
    *
    * @param array $data отчет для сохранения
    * @return string $name имя файла/дискриптор таблицы и т.д. для сохранения
    * @return bool true если успешно сохранило
    */
    public function save(array $data, string $name): bool;
}
