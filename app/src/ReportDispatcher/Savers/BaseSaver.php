<?php namespace Fizik\ReportDispatcher\Savers;

use Fizik\ReportDispatcher\Interfaces\SaverInterface;
/**
* Базовый класс обработчиков
*/
class BaseSaver implements SaverInterface
{
    public function save(array $data, string $name): bool
    {
        return true;
    }

    /**
    * Сохраняет в файл
    *
    * @param string $name имя файла
    * @param string $html что сохранить
    * @return bool возвращает true если успешное сохранение
    * @todo сделать в виде отдельного класса
    */
    protected function fileSaver(string $name, string $html): bool
    {
        return file_put_contents($name, $html);
    }
}
