<?php

/**
 * Transform an input product creation import CSV file into an output
 * product update import file by changing the SKU of the rows.
 * (Last row of the file is lost).
 *
 * Example, input file:
 *
 *      sku;family;attr1;attr2
 *      id1;pants;foo;bar
 *      id2;jackets;baz;baz
 *      id3;tv;yolo;goat
 *
 * Will produce the output file:
 *
 *      sku;family;attr1;attr2
 *      id2;pants;foo;bar
 *      id3;jackets;baz;baz
 *
 * Usage:
 *
 *      php products_creation_to_update_import_file.php path/to/the/input/file.csv
 *
 * The output file will be path/to/the/input/file_update.csv
 *
 * @author    Julien Janvier <jjanvier@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   https://opensource.org/licenses/OSL-3.0
 */

if (file_exists($file = __DIR__ . '/../vendor/autoload.php')) {
    require_once $file;
} else {
    require_once __DIR__ . '/../../../autoload.php';
}

if (2 !== $argc) {
    die('Please provide the input file as argument.');
}

$inputFile = $argv[1];
if (!is_readable($inputFile)) {
    die('Please provide a readable CSV input file as argument.');
}

$inputFileInfo = pathinfo($inputFile);
if ('csv' !== strtolower($inputFileInfo['extension'])) {
    die('Please provide a readable CSV input file as argument.');
}

$outputFile = sprintf(
    '%s/%s_update.%s',
    $inputFileInfo['dirname'],
    $inputFileInfo['filename'],
    $inputFileInfo['extension']
);

$reader = Box\Spout\Reader\ReaderFactory::create(Box\Spout\Common\Type::CSV);
$reader->setFieldDelimiter(';');
$reader->open($inputFile);

$writer = Box\Spout\Writer\WriterFactory::create(Box\Spout\Common\Type::CSV);
$writer->setFieldDelimiter(';');
$writer->openToFile($outputFile);

$previousRow = null;
foreach ($reader->getSheetIterator() as $sheet) {
    $headerWritten = false;
    foreach ($sheet->getRowIterator() as $row) {
        if ($headerWritten) {
            if (null !== $previousRow) {
                $rowToWrite = $previousRow;
                $rowToWrite[0] = $row[0];
                $writer->addRow($rowToWrite);
            }
            $previousRow = $row;
        } else {
            $writer->addRow($row);
            $headerWritten = true;
        }
    }
}

$reader->close();
$writer->close();

echo sprintf('Output file "%s" written. Done!', $outputFile);
