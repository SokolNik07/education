<?php

namespace App\Http\Controllers;

use App\Services\CRUDService;
use App\Services\FileService;
use App\Services\ServiceFilter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $serviceFilter;
    public $fileService;
    public $crudService;

    public function __construct(ServiceFilter $serviceFilter, FileService $fileService, CRUDService $crudService)
    {
        $this->serviceFilter = $serviceFilter;
        $this->fileService = $fileService;
        $this->crudService = $crudService;
    }
}
