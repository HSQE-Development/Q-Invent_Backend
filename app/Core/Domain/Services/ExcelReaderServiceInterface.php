<?php

namespace App\Core\Domain\Services;

interface ExcelReaderServiceInterface
{
    public function readExcel(string $filePath): array;
}
