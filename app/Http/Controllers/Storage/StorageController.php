<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;

class StorageController extends Controller
{
    public function index($fileName)
    {
        return response(file_get_contents('./storage/'.$fileName));
    }
}
