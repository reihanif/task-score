<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function storeFile($file_data, $fileable)
    {
        $clientOriginalName = $file_data->getClientOriginalName();
        $filename = pathinfo($clientOriginalName, PATHINFO_FILENAME);
        $extension = $file_data->getClientOriginalExtension();
        $uniqueFilename = $filename . '_' . time() . '.' . $extension;

        $path = $file_data->storeAs($fileable['path'], $uniqueFilename);

        $file = new File();
        $file->name = $filename;
        $file->path = $path;
        $file->extension = $extension;
        $file->size = $file_data->getSize();
        $file->type = $fileable['type'];
        $file->fileable_id = $fileable['fileable_id'];
        $file->fileable_type = $fileable['fileable_type'];
        $file->save();

        return $file;
    }

    public function deleteFile($id)
    {
        $file = File::find($id);
        Storage::delete($file->path);
        $file->delete();

        return $file;
    }
}
