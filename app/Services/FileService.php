<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $uniqueName = md5(microtime(true)) . '.' . $extension;
            $path = Storage::putFileAs('files', $file, $uniqueName);
        }
        return $path;
    }

    public function update(Request $request, $id)
    {
        if ($request->hasFile('image')) {
            if ($id->image !== '') {
                Storage::delete($id->image);

                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();

                $uniqueName = md5(microtime(true)) . '.' . $extension;
                $path = Storage::putFileAs('files', $file, $uniqueName);
            }
            return $path;
        }
    }

    public function delete($id)
    {
        if ($id->image !== '') {
            Storage::delete($id->image);
        }
    }
}
