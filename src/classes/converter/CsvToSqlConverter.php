<?php


namespace taskforce\classes\converter;

use DirectoryIterator;
use taskforce\classes\exceptions\ConverterException;

class CsvToSqlConverter
{
    protected array $filesToConvert = [];

    /**
     * CsvToSqlConverter constructor.
     * @param string $directory - директория с csv-файлами
     * @throws ConverterException
     */
    public function __construct(string $directory)
    {
        if (!is_dir($directory)) {
            throw new ConverterException("Указанная директория $directory не существует");
        }
        $this->loadCsvFiles($directory);
    }


    /**
     * Загружаем CSV файлы, перекладываем в массив объекты (файлов) типа SplFileInfo c абсолютным адресом
     * @param string $directory
     */
    protected function loadCsvFiles(string $directory): void
    {
        foreach (new DirectoryIterator($directory) as $file) {
            if ($file->getExtension() === 'csv') {
                if ($file->isDot()) {
                    continue;
                }
                $this->filesToConvert[] = $file->getRealPath();
            }
        }
    }

    /**
     * Конвертируем все файлы
     * @param string $outputDirectory
     * @return array
     * @throws ConverterException
     */
    public function convertFiles(string $outputDirectory): array
    {
        $result = [];
        foreach ($this->filesToConvert as $file) {
            $result[] = $this->convertFile($file, $outputDirectory);
        }
        return $result;
    }

    /**
     * Конвертируем csv-файл
     * @param string $file
     * @param string $outputDirectory
     * @return string
     * @throws ConverterException
     */
    protected function convertFile(string $file, string $outputDirectory): string
    {
        $file = new \SplFileObject($file);
        $file->setFlags(\SplFileObject::READ_CSV);

        $columns = $file->fgetcsv();
        $separator = ',';
        $columnsNames = implode($separator, $columns);

        $values = [];

        while (!$file->eof()) {
            $values[] = $file->fgetcsv();
        }

        $fileName = $file->getBasename('.csv');

        $fileConvertedToSql = $this->getSqlContent($fileName, $columnsNames, $values);

        return $this->saveSqlContent($fileName, $outputDirectory, $fileConvertedToSql);
    }

    /**
     * Берем массив данных и создаем команды
     * @param string $fileName
     * @param string $columnsNames
     * @param array $values
     * @return string
     */
    protected function getSqlContent(string $fileName, string $columnsNames, array $values): string
    {
        $sql = "INSERT INTO $fileName ($columnsNames) VALUES ";

        foreach ($values as $value) {
            array_walk($value, function (&$row) {
                $row = filter_var($row, FILTER_SANITIZE_ADD_SLASHES);
                $row = "'$row'";
            });
            $sql .= "( " . join(', ', $value) . "), ";
        }

        return substr($sql, 0, -2);
    }

    /**
     * Сохраняем конвертированные файл(ы) с sql в нужную директорию
     * @param string $tableName
     * @param string $outputDirectory
     * @param string $content
     * @return string
     * @throws ConverterException
     */
    protected function saveSqlContent(string $tableName, string $outputDirectory, string $content): string
    {
        if (!is_dir($outputDirectory)) {
            throw new ConverterException('Директория для конвертированных файлов не существует');
        }

        $fileName = $outputDirectory . DIRECTORY_SEPARATOR . $tableName . '.sql';
        file_put_contents($fileName, $content);

        return $fileName;
    }
}
