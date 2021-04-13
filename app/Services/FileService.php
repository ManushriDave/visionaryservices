<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileService
{
    public function uploadFile(UploadedFile $file, string $folder): string
    {
        return $file->store($folder);
    }

    public function uploadFilePublicly(UploadedFile $file, string $folder): string
    {
        return Storage::disk('public')->putFile($folder, $file);
    }

    public function download($path): BinaryFileResponse
    {
        $path = Storage::path($path);
        return response()->download($path)->sendHeaders();
    }

    public function destroy($path): bool
    {
        return Storage::disk('public')->delete($path);
    }
}
