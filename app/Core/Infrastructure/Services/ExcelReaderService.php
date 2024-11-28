<?php

namespace App\Core\Infrastructure\Services;

use App\Core\Domain\Services\ExcelReaderServiceInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelReaderService implements ExcelReaderServiceInterface
{
    public function readExcel(string $filePath): array
    {

        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = [];
        $errors = [];
        $highestRow = $worksheet->getHighestRow();

        for ($rowIndex = 5; $rowIndex <= $highestRow; $rowIndex++) {

            $rowData = [];
            $rowErrors = [];

            foreach ($worksheet->getRowIterator($rowIndex)->current()->getCellIterator() as $colIndex => $cell) {
                $value = $cell->getValue();
                $rowData[] = $value;
            }

            if (!empty($rowErrors)) {
                $errors[] = $rowErrors;
            } else {
                $data[] = [
                    'quantity_type' => $rowData[0] ?? null,
                    'name' => $rowData[1] ?? null,
                    'total_quantity' => $rowData[2] ?? null,
                    'ubication' => $rowData[3] ?? null,
                ];
            }
        }
        return [$data, $errors];
    }
}
