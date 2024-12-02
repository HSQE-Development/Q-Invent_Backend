<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExportProducts implements WithEvents
{

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $spreadsheet = $event->sheet->getParent();

                $templatePath = storage_path('app/Templates/EXPORT_TEMPLATE.xlsx');

                if (!file_exists($templatePath)) {
                    throw new \Exception("La plantilla no se encuentra en la ruta especificada: $templatePath");
                }


                $template = IOFactory::load($templatePath);
                $templateSheet = $template->getActiveSheet();

                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setTitle($templateSheet->getTitle());

                $highestRow = $templateSheet->getHighestRow();
                $highestColumn = $templateSheet->getHighestColumn();

                for ($row = 1; $row <= $highestRow; $row++) {
                    for ($col = 'A'; $col <= $highestColumn; $col++) {
                        $cell = $templateSheet->getCell("$col$row");
                        $sheet->setCellValue("$col$row", $cell->getValue());

                        $font = $templateSheet->getStyle("$col$row")->getFont();
                        $sheet->getStyle("$col$row")->getFont()->setName($font->getName())
                            ->setSize($font->getSize())
                            ->setBold($font->getBold())
                            ->setItalic($font->getItalic())
                            ->setUnderline($font->getUnderline())
                            ->setColor($font->getColor());
                        $fill = $templateSheet->getStyle("$col$row")->getFill();
                        $sheet->getStyle("$col$row")->getFill()->setFillType($fill->getFillType())
                            ->getStartColor()->setRGB($fill->getStartColor()->getRGB());
                        $borders = $templateSheet->getStyle("$col$row")->getBorders();
                        $sheet->getStyle("$col$row")->getBorders()->getTop()->setBorderStyle($borders->getTop()->getBorderStyle())
                            ->getColor()->setRGB($borders->getTop()->getColor()->getRGB());
                        $sheet->getStyle("$col$row")->getBorders()->getBottom()->setBorderStyle($borders->getBottom()->getBorderStyle())
                            ->getColor()->setRGB($borders->getBottom()->getColor()->getRGB());
                        $sheet->getStyle("$col$row")->getBorders()->getLeft()->setBorderStyle($borders->getLeft()->getBorderStyle())
                            ->getColor()->setRGB($borders->getLeft()->getColor()->getRGB());
                        $sheet->getStyle("$col$row")->getBorders()->getRight()->setBorderStyle($borders->getRight()->getBorderStyle())
                            ->getColor()->setRGB($borders->getRight()->getColor()->getRGB());
                        $alignment = $templateSheet->getStyle("$col$row")->getAlignment();
                        $sheet->getStyle("$col$row")->getAlignment()->setHorizontal($alignment->getHorizontal())
                            ->setVertical($alignment->getVertical())
                            ->setWrapText($alignment->getWrapText());
                    }
                }
                foreach ($templateSheet->getDrawingCollection() as $drawing) {
                    $drawingCopy = clone $drawing;
                    $drawingCopy->setWorksheet($sheet);
                }

                $sheet->fromArray($templateSheet->toArray(), null, "A1");

                $products = Product::with('assignmentPeople')->get();
                $startRow = 5;

                foreach ($products as $product) {
                    // dd($product);
                    $sheet->setCellValue("A{$startRow}", $product->name);
                    $sheet->setCellValue("B{$startRow}", $product->total_quantity);
                    $sheet->setCellValue("C{$startRow}", $product->quantity_available);
                    $sheet->setCellValue("D{$startRow}", $this->calculateAssignedQuantity($product));
                    $startRow++;
                }
            }
        ];
    }
    private function calculateAssignedQuantity(Product $product): int
    {
        return $product->assignmentPeople->sum('pivot.assigned_quantity');
    }
}
