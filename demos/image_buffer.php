<?php

/**
 * @see http://libxlsxwriter.github.io/image_buffer_8c-example.html
 */

use FFILibXlsxWriter\FFILibXlsxWriter;
use FFILibXlsxWriter\Structs\Color;
use FFILibXlsxWriter\Structs\ImageBuffer;
use FFILibXlsxWriter\Structs\ImageOptions;
use FFILibXlsxWriter\Structs\Underline;
use FFILibXlsxWriter\Workbook;

require_once __DIR__ . '/../vendor/autoload.php';

FFILibXlsxWriter::init();

/* Simple array with some PNG data. */
$image_buffer = new ImageBuffer([
    0x89, 0x50, 0x4e, 0x47, 0x0d, 0x0a, 0x1a, 0x0a, 0x00, 0x00, 0x00, 0x0d,
    0x49, 0x48, 0x44, 0x52, 0x00, 0x00, 0x00, 0x20, 0x00, 0x00, 0x00, 0x20,
    0x08, 0x02, 0x00, 0x00, 0x00, 0xfc, 0x18, 0xed, 0xa3, 0x00, 0x00, 0x00,
    0x01, 0x73, 0x52, 0x47, 0x42, 0x00, 0xae, 0xce, 0x1c, 0xe9, 0x00, 0x00,
    0x00, 0x04, 0x67, 0x41, 0x4d, 0x41, 0x00, 0x00, 0xb1, 0x8f, 0x0b, 0xfc,
    0x61, 0x05, 0x00, 0x00, 0x00, 0x20, 0x63, 0x48, 0x52, 0x4d, 0x00, 0x00,
    0x7a, 0x26, 0x00, 0x00, 0x80, 0x84, 0x00, 0x00, 0xfa, 0x00, 0x00, 0x00,
    0x80, 0xe8, 0x00, 0x00, 0x75, 0x30, 0x00, 0x00, 0xea, 0x60, 0x00, 0x00,
    0x3a, 0x98, 0x00, 0x00, 0x17, 0x70, 0x9c, 0xba, 0x51, 0x3c, 0x00, 0x00,
    0x00, 0x46, 0x49, 0x44, 0x41, 0x54, 0x48, 0x4b, 0x63, 0xfc, 0xcf, 0x40,
    0x63, 0x00, 0xb4, 0x80, 0xa6, 0x88, 0xb6, 0xa6, 0x83, 0x82, 0x87, 0xa6,
    0xce, 0x1f, 0xb5, 0x80, 0x98, 0xe0, 0x1d, 0x8d, 0x03, 0x82, 0xa1, 0x34,
    0x1a, 0x44, 0xa3, 0x41, 0x44, 0x30, 0x04, 0x08, 0x2a, 0x18, 0x4d, 0x45,
    0xa3, 0x41, 0x44, 0x30, 0x04, 0x08, 0x2a, 0x18, 0x4d, 0x45, 0xa3, 0x41,
    0x44, 0x30, 0x04, 0x08, 0x2a, 0x18, 0x4d, 0x45, 0x03, 0x1f, 0x44, 0x00,
    0xaa, 0x35, 0xdd, 0x4e, 0xe6, 0xd5, 0xa1, 0x22, 0x00, 0x00, 0x00, 0x00,
    0x49, 0x45, 0x4e, 0x44, 0xae, 0x42, 0x60, 0x82
]);
$image_size = 200;

/* Create a new workbook and add a worksheet. */
$workbook  = new Workbook(__DIR__ . '/output/image_buffer.xlsx');
$worksheet = $workbook->addWorksheet();
$options = new ImageOptions();
$options->x_offset = 34;
$options->y_offset = 4;
$options->x_scale = 2;
$options->y_scale = 1;
/* Insert the image from the buffer. */
list($row, $col) = FFILibXlsxWriter::cell("B3");
$worksheet->insertImageBuffer($row, $col, $image_buffer, $image_size);
/* Insert the image from the same buffer, with some options. */
list($row, $col) = FFILibXlsxWriter::cell("B7");
$worksheet->insertImageBufferOpt($row, $col, $image_buffer, $image_size, $options);

$workbook->close();
