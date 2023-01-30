<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Http\Requests\Video\UpdateRequest;
use App\Models\Video;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Video $video)
    {
    $data = $request->validated();

    $video->update($data);
    }
}
