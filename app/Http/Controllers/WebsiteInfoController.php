<?php

namespace App\Http\Controllers;

use App\Http\Requests\WebsiteInfo\UpdateWebsiteInfoRequest;
use App\WebsiteInfo;

class WebsiteInfoController extends Controller
{
	private $websiteInfo;
	
	public function getWebsiteInfo()
	{
		$this->websiteInfo = WebsiteInfo::latest()->first();
		
		if (!isset($this->websiteInfo)) {
			$this->websiteInfo          = new WebsiteInfo();
			$this->websiteInfo->content = null;
			$this->websiteInfo->save();
		}
		
		return response()->json($this->websiteInfo);
	}
	
	public function updateWebsiteInfo(UpdateWebsiteInfoRequest $request)
	{
		// Delete older than month
		WebsiteInfo::where('created_at', '<=', now()->subMonth()->toDateTimeString())->delete();
		
		// Create contacts
		WebsiteInfo::create(['content' => $request->get('content')]);
		
		return response()->json(true);
	}
}
