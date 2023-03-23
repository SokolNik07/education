<?php

namespace App\Http\Controllers\FileManager;

use App\Http\Controllers\Controller;
use App\Http\Requests\File\FileRequest;
use App\Http\Requests\File\FilterRequest;
use App\Http\Requests\File\UpdateRequest;
use App\Http\Resources\File\FileResource;
use App\Models\File;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class FileManagerController1 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(FilterRequest $request)
    {
        $builder = File::query();
        $page = $request['page'] ?? 1;
        $perPage = $request['per_page'] ?? 10;
        $builder = $this->serviceFilter->filter($request, $builder);
        $result = $builder->paginate($perPage, ['*'], 'page', $page);

        return FileResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FileRequest $request
     * @return JsonResponse
     */
    public function store(FileRequest $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $uniqueName = md5(microtime(true)) .'.'. $extension;

        if ($request->hasFile('image')) {
                $path = Storage::putFileAs('files', $file, $uniqueName);
//                $image = File::create([
//                    'user_id' => $request->user()->id,
//                    'name' => $request['name'],
//                    'path' => $path,
//                ]);
                $meta = [
                    'name' => $name,
                    'link' => asset('storage/'.$path),
                    'microtimename' => $uniqueName,
                ];
                $metaFileName = $uniqueName . '.meta';
                Storage::put('files/'.$metaFileName, json_encode($meta));

                $decode = Storage::get('files/'.$uniqueName.'.meta');
                $ddd = json_decode($decode, true);
//                return new FileResource($image);
                return response()->json($ddd);
            }
        throw new \RuntimeException('Вы не добавили файл или он не верного формата');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function show(File $id)
    {
//        return Storage::download($id->path);
        return new FileResource($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param File $id
     * @return FileResource
     */
    public function update(UpdateRequest $request, File $id)
    {
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

        Storage::delete($id->path);
        $path = Storage::putFileAs('files', $file, "{$request['name']}.$extension");
        $id->update([
            'name' => $request['name'],
            'path' => $path,
        ]);
        return new FileResource($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(File $id)
    {
        Storage::delete($id->path);
        $id->delete();
        return Response::deny('OK');
    }
}
