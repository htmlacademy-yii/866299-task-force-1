<?php

declare(strict_types=1);

namespace taskforce\import;

use taskforce\exeptions\BadFileExeption;
use taskforce\import\ConstructorUsers;

/**
 * Класс ImportData
 * Отвечает за импорт данных их scv файлов
 * 
 */

class ImportData
{

    private $fileName;
    private $columns;
    private $readFileObject;
    private $readFilePath;
    private $uploadFileObject;
    private $uploadFilePath;

    /**
     * @param object $constructor объект конструктора
     */
    public function __construct(string $fileName, array $columns)
    {
        $this->fileName = $fileName;
        $this->columns = $columns;
        
        $this->readFilePath = sprintf('%s%sdata%s%s.csv', $_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $this->fileName);
        $this->uploadFilePath = sprintf('%s%ssql%s%s.sql', $_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $this->fileName);
    }


    /**
     * Проверяем файл для чтения
     */
    public function import(): void
    {
        if (!file_exists($this->readFilePath)) {
            throw new BadFileExeption('Файл для чтения не найден');
        }

        if (!$this->validateColumns($this->columns)) {
            throw new BadFileExeption('Заголовки столбцов заданы не верно. Должен быть хотя бы один заголовок в формате string.');
        }

        try {
            $this->readFileObject = new \SplFileObject($this->readFilePath);
            $this->readFileObject->setFlags(
                $this->readFileObject::SKIP_EMPTY
            );
        } catch (BadFileExeption $e) {
            throw new BadFileExeption('Не удалось открыть файл');
        }

        if ($this->getHeaderData() !== $this->columns) {
            throw new BadFileExeption('Заголовки столбцов не соответствуют заданным');
        }
    }

    /**
     * Проверяем заданные колонки
     */
    private function validateColumns(array $columns): bool
    {
        if (!count($columns)) {
            return false;
        }
        foreach ($columns as $column) {
            if (!is_string($column)) {
                return false;
            }
        }
        return true;
    }
    /**
     * Получаем заголовки из csv файла
     */
    public function getHeaderData(): ?array
    {
        return $this->readFileObject->fgetcsv();
    }
    /**
     * Создаем проверяем и записываем файл
     * @param obejct $sqlConstruct конструктор sql
     */
    public function upload(object $sqlConstruct):void {   
        $this->uploadFileObject = new \SplFileObject($this->uploadFilePath, 'w+');
        
        if(!is_readable($this->uploadFilePath)) {
            throw new BadFileExeption('Файл для записи не доступен для записи');
        }

        while(!$this->readFileObject->eof()) {
            $data = $this->readFileObject->fgetcsv();
            $this->uploadFileObject->fwrite($sqlConstruct->createSqlTemplate($data));
        }
    }
}
