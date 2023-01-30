<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Models\Video;

class DestroyController extends Controller
{
    public function __invoke(Video $video)
    {
    $video->delete();
    }
}
