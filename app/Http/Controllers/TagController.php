<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tags\DeleteRequest;
use App\Http\Requests\Tags\EditRequest;
use App\Http\Requests\Tags\GetArticlesByTagNameRequest;
use App\Http\Requests\tags\GetRequest;
use App\Http\Requests\Tags\StoreRequest;
use App\Http\Requests\Tags\TakeTagsRequest;
use App\Tag;

class TagController extends Controller
{
	private $perPage= 10;
	/**
	 * @param \App\Http\Requests\tags\GetRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function get(GetRequest $request)
	{
		
		if (isset($request->tag)) {
			$tags = Tag::search($request->tag)->paginate($this->perPage);
		} else {
			$tags = Tag::paginate($this->perPage);
		}
		
		return response()->json($tags);
	}
	
	public function getArticlesByTagName(GetArticlesByTagNameRequest $request){
		$tag = Tag::where(['name' => $request->get('tag_name')])->first();
		
		// Return only published articles
		$articles = $tag->articles()->paginate($this->perPage);
		
		return response()->json($articles);
	}
	
	public function getAll(){
		$allTags = Tag::select('id', 'name')->get();
		
		return response()->json($allTags);
	}
	
	/**
	 * @param \App\Http\Requests\Tags\TakeTagsRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function takeTags(TakeTagsRequest $request)
	{
		if (isset($request->searchTagInput)) {
			// Get all tags
			$tags = Tag::search($request->searchTagInput)->get();
			
			// Remove already selected tags
			if(isset($request->tags_ids)){
				$tags->transform(function ($tag) use($request){
					return $tag->whereNotIn('id', $request->tags_ids);
				});
			}
			
			// Limit how mach tags will be returned
			$tags->take($request->take);
		} elseif(isset($request->tags_ids)){
			$tags = Tag::whereNotIn('id', $request->tags_ids)->take($request->take)->get();
		} else {
			// Take only how mach user requested
			$tags = Tag::take($request->take)->get();
		}
		
		return response()->json($tags->all());
	}
	
	/**
	 * @param \App\Http\Requests\Tags\StoreRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(StoreRequest $request)
	{
		Tag::create($request->all());
		
		return response()->json(true);
	}
	
	/**
	 * @param \App\Http\Requests\Tags\EditRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function edit(EditRequest $request)
	{
		$tag = Tag::find($request->id);
		
		$tag->update($request->all());
		
		return response()->json(true);
	}
	
	/**
	 * @param \App\Http\Requests\Tags\DeleteRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(DeleteRequest $request)
	{
		Tag::destroy($request->id);
		
		return response()->json(true);
	}
}
