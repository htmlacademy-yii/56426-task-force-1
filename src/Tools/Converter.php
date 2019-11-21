<?php
declare(strict_types=1);

namespace HtmlAcademy\Tools;

class Converter {

    private $source;
    private $target;
    private $table;
    private $fields;
    private $data;

    public function __construct(string $source, string $target, string $table) {
        $this->source = $source;
        $this->target = $target;
        $this->table = $table;
        $this->data = [];
    }

    // Работает как implode(), но дополнительно заключает значения в кавычки
    private static function stringOfValues(array $items, string $quoteSymbol = "'"): string {
        $result = "";
        $itemNumber = 1;
        foreach ($items as $item) {
            $result .= $quoteSymbol . $item . $quoteSymbol;
            if ($itemNumber < count($items)) {
                $result .= ",";
            }
            $itemNumber++;
        }
        return $result;
    }

    private function import(array $extraFields = []): void {
        $file = new \SplFileObject($this->source);
        $file->setFlags(\SplFileObject::SKIP_EMPTY);
        $file->rewind();
        $header = $file->fgetcsv();
        foreach ($extraFields as $fieldName => $maxValue) {
            $header[] = $fieldName;
        }
        $this->fields = self::stringOfValues($header, "`");
        while (!$file->eof()) {
            if ($line = $file->fgetcsv()) {
                foreach ($extraFields as $fieldName => $maxValue) {
                    if ($maxValue) {
                        $line[] = rand(1, $maxValue);
                    } else {
                        $line[] = count($this->data) + 1;
                    }
                }
                $this->data[] = $line;
            }
        }
    }

    private function export(): void {
        $file = new \SplFileObject($this->target, "w");
        foreach ($this->data as $line) {
            $file->fwrite("insert into `" . $this->table . "` (" . $this->fields . ") values (" . self::stringOfValues($line) . ");\n");
        }
    }

    public function convert(array $extraFields = []): int {
        $this->import($extraFields);
        $this->export();
        return count($this->data);
    }
    
}
