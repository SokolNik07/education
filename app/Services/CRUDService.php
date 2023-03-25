<?php


namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CRUDService
{
    public function create(Request $request, $id)
    {
        $requestBody = $request->validated();
        unset($requestBody['image']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $uniqueName = md5(microtime(true)) . '.' . $extension;
            $path = Storage::putFileAs('files', $file, $uniqueName);

            $addValues = [
                'user_id' => $request->user()->id,
                'image' => $path,
            ];
            $data = $requestBody + $addValues;

            $id = $id->create($data);
            return $id;
        }
        $addValues = [
            'user_id' => $request->user()->id,
        ];
        $data = $requestBody + $addValues;

        $id = $id->create($data);
        return $id;
    }

    public function update(Request $request, $id)
    {
        $requestBody = $request->validated();
        unset($requestBody['image']);

        if ($request->hasFile('image')) {
            if ($id->image !== '') {
                Storage::delete($id->image);

                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();

                $uniqueName = md5(microtime(true)) . '.' . $extension;
                $path = Storage::putFileAs('files', $file, $uniqueName);

                $addValues = [
                    'image' => $path,
                ];
                $data = $requestBody + $addValues;

                $id->update($data);
            }
        }
        $id->update($requestBody);
    }

    public function destroy($id)
    {
        if ($id->image) {
            Storage::delete($id->image);
        }
        $id->delete();
    }
}
