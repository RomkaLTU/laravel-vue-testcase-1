<?php

namespace App\Http\Controllers;

use App\ImportEntries;
use App\ImportFiles;
use App\Imports\CustomFileImport;
use App\Imports\FileImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ImportFilesController extends Controller
{
    public function put_upload(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'import_file' => 'required',
        ]);

        if ($validation->passes()) {
            $uploaded_file = $request->file('import_file');

            $file_to_import = $uploaded_file->storeAs('import_files', time() . '_' . $uploaded_file->getClientOriginalName());
            $uploaded_file_path = storage_path('app' . DIRECTORY_SEPARATOR . $file_to_import);

            $imported_file = ImportFiles::create([
                'name' => $file_to_import,
            ]);

            // Laravel excel package doesnt work with JSON
            $custom_importer = new CustomFileImport($imported_file);

            switch ($uploaded_file->getMimeType())
            {
                case 'application/json':
                    $custom_importer->import('json');
                    break;

                default:
                    Excel::import(new FileImport($imported_file), $uploaded_file_path);
            }

            $imported_entries_query = ImportEntries::where('import_file_id', $imported_file->id);

            // @TODO delete failed or empty file

            return $imported_entries_query->paginate('100');

        }

        return false;
    }
}
