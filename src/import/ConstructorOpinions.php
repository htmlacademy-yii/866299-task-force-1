<?php

declare(strict_types=1);
namespace taskforce\import;

/**
 * Класс наследник для таблицы category
 */
final class ConstructorOpinions extends Constructor {

    public function __construct()
    {
        $this->tableName = 'feedback';
        $this->tableColumns = ['feedback_date', 'rate', 'feedback', 'user_who_id', 'user_to_id'];
    }

    /**
     * Создает шаблон для заполнения
     * @param array $data массив с данными
     */
    public function createSqlTemplate(array $data): string
    {
        $template = "INSERT INTO %s%s(%s)%sVALUES%s('%s', %s, %s);%s";
        $template = sprintf($template, $this->tableName, PHP_EOL, implode(',', $this->tableColumns), PHP_EOL, PHP_EOL, htmlspecialchars(implode("','", $data)), rand(1, 20), rand(1, 20), PHP_EOL);
        return $template;
    }
}