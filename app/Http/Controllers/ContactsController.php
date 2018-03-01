<?php

namespace App\Http\Controllers;

use App\Contacts;
use App\Http\Requests\Contacts\UpdateContentRequest;

class ContactsController extends Controller
{
	private $contacts;
	
	public function getContacts()
	{
		$this->contacts = Contacts::latest()->first();
		
		if(!isset($this->contacts)){
			$this->contacts = new Contacts();
			$this->contacts->content = null;
			$this->contacts->save();
		}
		
		return response()->json($this->contacts);
	}
	
	public function updateContacts(UpdateContentRequest $request)
	{
		// Delete older than month
		Contacts::where('created_at', '<=', now()->subMonth()->toDateTimeString())->delete();
		
		// Create contacts
		Contacts::create(['content' => $request->get('content')]);
		
		return response()->json(true);
	}
}
