<?php

namespace App\Http\Controllers\Info;

use App\Contacts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Info\ContactsUpdateRequest;

class ContactsController extends Controller
{
    /**
     * Get contacts
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $contacts = Contacts::latest()->first();
        
        if (!isset($contacts)) {
            $contacts          = new Contacts();
            $contacts->content = null;
            $contacts->save();
        }
        
        return response()->json($contacts);
    }
    
    /**
     * Update contacts
     *
     * @param \App\Http\Requests\Info\ContactsUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ContactsUpdateRequest $request)
    {
        // Delete older than month
        Contacts::where('created_at', '<=', now()->subMonth()->toDateTimeString())->delete();
        
        // Create contacts
        Contacts::create(['content' => $request->get('content')]);
        
        return response()->json(true);
    }
}
