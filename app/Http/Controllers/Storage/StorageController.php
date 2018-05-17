<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function index($fileName)
    {
        if (Storage::exists($fileName)){
            return response(Storage::get($fileName));
        }

        return abort(404);
    }
}
