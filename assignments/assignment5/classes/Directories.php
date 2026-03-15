<?php

class Directories {

    private $dirName;
    private $content;
    private $basePath = "directories";

    public function __construct($dirName, $content) {
        $this->dirName = $dirName;
        $this->content = $content;
    }

    public function createDirectoryAndFile() {

        $fullPath = $this->basePath . "/" . $this->dirName;

        if (is_dir($fullPath)) {
            return [
                "success" => false,
                "error" => "A directory already exists with that name."
            ];
        }

        if (!mkdir($fullPath, 0777)) {
            return [
                "success" => false,
                "error" => "Error: Directory could not be created."
            ];
        }

        $filePath = $fullPath . "/readme.txt";

        if (file_put_contents($filePath, $this->content) === false) {
            return [
                "success" => false,
                "error" => "Error: File could not be created."
            ];
        }

        return [
            "success" => true,
            "path" => $filePath
        ];
    }
}