<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tags\DeleteRequest;
use App\Http\Requests\Tags\EditRequest;
use App\Http\Requests\Tags\GetArticlesByTagNameRequest;
use App\Http\Requests\tags\GetRequest;
use App\Http\Requests\Tags\StoreRequest;
use App\Http\Requests\Tags\TakeTagsRequest;
use App\Jobs\DeleteTag;
use App\Tag;

class TagController extends Controller
{
	const PER_PAGE = 10;
	
	/**
	 * @param \App\Http\Requests\tags\GetRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function get(GetRequest $request)
	{
		
		if (isset($request->tag)) {
			$tags = Tag::search($request->tag)->paginate(self::PER_PAGE);
		} else {
			$tags = Tag::paginate(self::PER_PAGE);
		}
		
		return response()->json($tags);
	}
	
	/**
	 * @param \App\Http\Requests\Tags\GetArticlesByTagNameRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getArticlesByTagName(GetArticlesByTagNameRequest $request){
		$tag = Tag::where(['name' => $request->get('tag_name')])->first();
		
		// Return only published articles
		$articles = $tag->articles()->where('is_draft', 0)->with('headerImage')->latest()->paginate(self::PER_PAGE);
		
		return response()->json($articles);
	}
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getAll(){
		$allTags = Tag::select('id', 'name')->get();
		
		return response()->json($allTags);
	}
	
	/**
	 * @param \App\Http\Requests\Tags\StoreRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(StoreRequest $request)
	{
		$tag = Tag::create($request->all());
		
		DeleteTag::dispatch($tag)->delay(now()->addMinutes(15));
		
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
