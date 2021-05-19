<?php

declare(strict_types=1);
namespace taskforce\import;

/**
 * Класс наследник для таблицы category
 */
final class ConstructorProfiles extends Constructor {

    public function __construct()
    {
        $this->tableName = 'user';
        $this->tableColumns = ['address', 'birthday', 'description', 'phone', 'skype'];
    }

    /**
     * Создает шаблон для заполнения
     * @param array $data массив с данными
     */
    public function createSqlTemplate(array $data): string
    {
        $template = "UPDATE %s%s SET %s%sWHERE user.id = %s;%s";
        $values = "";
        foreach ($this->tableColumns as $element => $value) {
            $values .= $this->tableColumns[$element]." = '".$data[$element]."',";
        }
        
        $template = sprintf($template, $this->tableName, PHP_EOL, rtrim($values,','), PHP_EOL, rand(1, 20), PHP_EOL,);
        return $template;
    }
}