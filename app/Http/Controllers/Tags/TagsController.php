<?php

namespace App\Http\Controllers\Tags;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tags\TagDeleteRequest;
use App\Http\Requests\tags\TagsIndexRequest;
use App\Http\Requests\Tags\TagStoreRequest;
use App\Http\Requests\Tags\TagUpdateRequest;
use App\Jobs\DeleteTag;
use App\Tag;

class TagsController extends Controller
{
    /**
     * Get all tags
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll()
    {
        $allTags = Tag::select('id', 'name')->get();
    
        return response()->json($allTags);
    }
    
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(TagsIndexRequest $request)
    {
        if (isset($request->tag)) {
            $tags = Tag::search($request->tag)->paginate(config('app.tags_per_page', 10));
        } else {
            $tags = Tag::paginate(config('app.tags_per_page', 10));
        }
        
        return response()->json($tags);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TagStoreRequest $request)
    {
        
        $tag = Tag::create($request->all());

        if (config('app.delete_new_content')) {
            DeleteTag::dispatch($tag)->delay(now()->addMinutes(config('app.delete_content_after_minutes', 5)));
        }
        
        return response()->json(true);
    }
    
    /**
     * Update tag
     *
     * @param \App\Http\Requests\Tags\TagUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TagUpdateRequest $request)
    {
        Tag::find($request->id)->update($request->all());
        
        return response()->json(true);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(TagDeleteRequest $request)
    {
        Tag::find($request->id)->forceDelete();
        
        return response()->json(true);
    }
}
