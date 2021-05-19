<?php
declare(strict_types=1);
namespace taskforce\import;


/**
 * Абстрактный класс sql таблицы, содержит в себе всю необходимую информацию о таблице sql.
 */
abstract class Constructor
{
    protected $tableName;
    protected $tableColumns;

    /**
     * Возвращает имя файла для чтения и записи
     * 
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }
    
    /**
     * Возвращает список колонок, котороые должны быть в читаемом файле
     * 
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * Создает шаблон для заполнения
     * @param array $data массив с данными
     */
    abstract public function createSqlTemplate(array $data): string;
    
}
