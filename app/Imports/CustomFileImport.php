<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomFileImport
{
    private $file_content;
    private $imported_file;

    public function __construct($imported_file)
    {
        $uploaded_file_path = storage_path('app' . DIRECTORY_SEPARATOR . $imported_file->name);

        $this->imported_file = $imported_file;
        $this->file_content = file_get_contents($uploaded_file_path);
    }

    public function import($type)
    {
        switch ($type)
        {
            case 'json':
                $this->import_json();
                break;
        }
    }

    private function import_json()
    {
        $rows = json_decode($this->file_content);

        foreach ($rows as $row) {
            DB::table('import_entries')->insert([
                'import_file_id' => $this->imported_file->id,
                'country' => $row->country,
                'capital' => $row->capital,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
