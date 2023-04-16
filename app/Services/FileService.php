<?php
namespace App\Services;

use App\Exceptions\FileProcessingException;

class FileService
{
    public function readFile(string $filePath): string
    {
        if (!file_exists($filePath)) {
            throw new FileProcessingException("File not found: {$filePath}");
        }

        $content = file_get_contents($filePath);
        if ($content === false) {
            throw new FileProcessingException("Failed to read file: {$filePath}");
        }

        return $content;
    }

    public function writeFile(string $filePath, string $content): void
    {
        $result = file_put_contents($filePath, $content);
        if ($result === false) {
            throw new FileProcessingException("Failed to write file: {$filePath}");
        }
    }
}