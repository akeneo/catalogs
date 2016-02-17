<?php

namespace Akeneo\Catalog;

use Box\Spout\Common\Helper\GlobalFunctionsHelper;
use Box\Spout\Writer\CSV\Writer;

class CsvWriterWithoutBOM extends Writer
{
    public function __construct()
    {
        parent::__construct();
        $this->setGlobalFunctionsHelper(new GlobalFunctionsHelper());
    }

    protected function openWriter()
    {
        // overwrite this method to remove the BOM on the CSV
        // as the PIM is currently not able to read it :(
    }
}
