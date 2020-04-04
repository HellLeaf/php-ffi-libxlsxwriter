<?php
/**
 * @see http://libxlsxwriter.github.io/tutorial01.html
 */
use FFILibXlsxWriter\FFILibXlsxWriter;
use FFILibXlsxWriter\Workbook;

require_once __DIR__ . '/../vendor/autoload.php';

FFILibXlsxWriter::init();

$workbook = new Workbook(__DIR__ . '/output/simple.xlsx');
$worksheet = $workbook->addWorksheet('First worksheet');

$col = 0;
$expenses = [
    ["item" => "Rent", "cost" => 1000],
    ["item" => "Gas", "cost" => 100],
    ["item" => "Food", "cost" => 300],
    ["item" => "Gym", "cost" => 50],
];

/* Iterate over the data and write it out element by element. */
for ($row = 0; $row < 4; $row++) {
    $worksheet->writeString($row, $col, $expenses[$row]['item'], NULL);
    $worksheet->writeNumber($row, $col + 1, $expenses[$row]['cost'], NULL);
}
/* Write a total using a formula. */
$worksheet->writeString($row, $col, "Total", NULL);
$worksheet->writeFormula($row, $col + 1, "=SUM(B1:B4)", NULL);

$workbook->close();