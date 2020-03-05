<?php

namespace App\Imports;

use App\ImportEntries;
use Maatwebsite\Excel\Concerns\ToModel;

class FileImport implements ToModel
{
    private $imported_file;

    public function __construct($imported_file)
    {
        $this->imported_file = $imported_file;
    }

    /**
     * @param array $row
     *
     * @return ImportEntries
     */
    public function model(array $row)
    {
        return new ImportEntries([
            'import_file_id' => $this->imported_file->id,
            'country' => $row[0],
            'capital' => $row[1],
        ]);
    }
}
