<?php

namespace App\Http\Controllers\Info;

use App\Http\Requests\WebsiteInfo\WebsiteInfoUpdateRequest;
use App\WebsiteInfo;
use App\Http\Controllers\Controller;

class WebsiteInfoController extends Controller
{
    /**
     * Get website-info content
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $websiteInfo = WebsiteInfo::latest()->first();
        
        if (!isset($websiteInfo)) {
            $websiteInfo          = new WebsiteInfo();
            $websiteInfo->content = null;
            $websiteInfo->save();
        }
        
        return response()->json($websiteInfo);
    }
    
    /**
     * Website-info content update
     *
     * @param \App\Http\Requests\WebsiteInfo\WebsiteInfoUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(WebsiteInfoUpdateRequest $request)
    {
        // Delete older than month
        WebsiteInfo::where('created_at', '<=', now()->subMonth()->toDateTimeString())->delete();
        
        // Create contacts
        WebsiteInfo::create(['content' => $request->get('content')]);
        
        return response()->json(true);
    }
}
