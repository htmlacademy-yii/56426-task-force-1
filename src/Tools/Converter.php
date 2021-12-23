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

    public function convert(array $extraFields = []): int {
        $this->import($extraFields);
        $this->export();
        return count($this->data);
    }

    private function import(array $extraFields = []): void {
        $file = new \SplFileObject($this->source);
        $file->setFlags(\SplFileObject::SKIP_EMPTY);
        $file->rewind();
        $header = $file->fgetcsv() or exit("Ошибка чтения CSV-заголовка в файле " . $this->source);
        $header = array_merge($header, array_keys($extraFields));
        $this->fields = "`" . implode("`, `", $header) . "`";
        while (!$file->eof()) {
            if ($line = $file->fgetcsv()) {
                foreach ($extraFields as $maxValue) {
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
        $insertCommand = "INSERT INTO `" . $this->table . "` (" . $this->fields . ") VALUES\n";
        $lineNumber = 1;
        foreach ($this->data as $line) {
            $insertCommand .= "('" . implode("', '", $line) . "')";
            if ($lineNumber < count($this->data)) {
                $insertCommand .= ",\n";
            }
            $lineNumber++;
        }
        $insertCommand .= ";\n";
        $file->fwrite($insertCommand);
    }
}
