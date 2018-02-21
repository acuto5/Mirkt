<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\Articles\DeleteRequest;
use App\Http\Requests\Articles\EditArticleRequest;
use App\Http\Requests\Articles\GetAllArticlesRequest;
use App\Http\Requests\Articles\GetAllDraftArticlesRequest;
use App\Http\Requests\Articles\GetArticleRequest;
use App\Http\Requests\Articles\MarkArticleAsDraftRequest;
use App\Http\Requests\Articles\MarkArticleAsPublishedRequest;
use App\Http\Requests\Articles\SearchDraftArticlesRequest;
use App\Http\Requests\Articles\SearchPublishedArticlesRequest;
use App\Http\Requests\Articles\StoreArticleRequest;
use App\Image;
use App\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
	const ARTICLES_PER_PAGE = 12;
	
	/**
	 * @param GetArticleRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getArticle(GetArticleRequest $request)
	{
		$responseCode = 200;
		$where        = [['id', $request->id]];
		
		// If user isn`t moderator allow search only in published articles
		if (Auth::guest() || (Auth::check() && !$request->user()->isBlessed())) {
			$where = array_merge($where, [['is_draft', 0]]);
		}
		
		$article = Article::select(['id', 'title', 'content', 'user_id', 'is_draft', 'sub_category_id', 'created_at', 'updated_at'])
			->where($where)
			->with(['author:id,name', 'headerImage', 'tags', 'images', 'subCategory' => function($query){
				$query->select('id', 'name', 'category_id')->with('category:id,name');
			}])
			->first();
		
		// If article not found send 204 status code
		if ($article === null) {
			$responseCode = 204;
		};
		
		return response()->json($article, $responseCode);
	}
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getAll(GetAllArticlesRequest $request)
	{
		$orderBy = 'created_at';
		$where   = [['is_draft', false]];
		$select  = ['id', 'title', 'sub_category_id', 'created_at'];
		$isDesc  = (isset($request->order_by) && $request->order_by === 'oldest') ? 'asc' : 'desc';
		
		// if sub_category_id selected
		if (isset($request->sub_category_id)) {
			$where[] = ['sub_category_id', $request->sub_category_id];
		}
		
		$articles = Article::select($select)
			->where($where)
			->with('headerImage')
			->orderBy($orderBy, $isDesc)
			->paginate(self::ARTICLES_PER_PAGE);
		
		return response()->json($articles);
	}
	
	/**
	 * @param \App\Http\Requests\Articles\GetAllDraftArticlesRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getAllDraftArticles(GetAllDraftArticlesRequest $request)
	{
		$orderBy = 'created_at';
		$where   = ['is_draft', true];
		$select  = ['id', 'title', 'sub_category_id', 'created_at'];
		$isDesc  = (isset($request->order_by) && $request->order_by === 'oldest') ? 'asc' : 'desc';
		
		$articles = Article::select($select)
			->where([$where])
			->with('headerImage')
			->orderBy($orderBy, $isDesc)
			->paginate(self::ARTICLES_PER_PAGE);
		
		return response()->json($articles);
	}
	
	/**
	 * @param \App\Http\Requests\Articles\StoreArticleRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(StoreArticleRequest $request)
	{
		// Article will be associated with user
		$request->merge(['user_id' => Auth::id(), 'content' => clean($request->get('content'))]);
		
		// Create new Article
		$article = new Article($request->all());
		
		// Save article there to get article id
		$article->save();
		
		// Make this article searchable with sub_category_id (Laravel scout bugs...)
		Auth::user()->articles()->searchable();
		
		// Store and sync tags with article
		$this->syncTags($article, $request);
		
		// Store and sync images with article
		$article->storeImages($request, 'images');
		
		return response()->json($article->id);
	}
	
	/**
	 * @param \App\Http\Requests\Articles\EditArticleRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function edit(EditArticleRequest $request)
	{
		// Find article
		$article = Article::find($request->id);
		
		$request->merge(['content' => clean($request->get('content'))]);
		
		// update fillable fields
		$article->update($request->all());
		
		// Edit article tags
		$this->syncTags($article, $request);
		
		// Sync old article images
		$this->syncOldImages($article, $request);
		
		// Store and sync new images with article
		$article->storeImages($request, 'images');
		
		return response()->json($article->id);
	}
	
	/**
	 * @param \App\Http\Requests\Articles\MarkArticleAsDraftRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function markArticleAsDraft(MarkArticleAsDraftRequest $request)
	{
		$article = Article::find($request->id);
		
		$article->is_draft = true;
		$article->save();
		
		return response()->json(true);
	}
	
	/**
	 * @param \App\Http\Requests\Articles\MarkArticleAsPublishedRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function markArticleAsPublished(MarkArticleAsPublishedRequest $request)
	{
		$article = Article::find($request->id);
		
		$article->is_draft = false;
		$article->save();
		
		return response()->json(true);
	}
	
	/**
	 * @param \App\Http\Requests\Articles\DeleteRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(DeleteRequest $request)
	{
		$article = Article::find($request->id);
		
		$article->tags()->detach();
		$article->detachImages();
		$article->delete();
		
		return response()->json(true);
	}
	
	/**
	 * @param \App\Http\Requests\Articles\SearchPublishedArticlesRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function searchInPublishedArticles(SearchPublishedArticlesRequest $request)
	{
		// Find articles
		$articles = $this->searchArticles($request, false);
		$articles->load('headerImage');
		
		// If user choose orderBy, by oldest articles
		$this->sortByArticlesDates($articles, 'created_at', $request->order_by);
		// Filter, witch columns will be visible
		$this->hideColumns($articles, ['content', 'sub_category_id', 'is_draft']);
		
		return response()->json($articles->toArray());
	}
	
	/**
	 * @param \App\Http\Requests\Articles\SearchDraftArticlesRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function searchInDraftArticles(SearchDraftArticlesRequest $request)
	{
		// Find articles
		$articles = $this->searchArticles($request, true);
		$articles->load('headerImage');
		
		// If user choose orderBy, by oldest articles
		$this->sortByArticlesDates($articles, 'created_at', $request->order_by);
		
		// Filter, witch columns will be visible
		$this->hideColumns($articles, ['content', 'sub_category_id', 'is_draft']);
		
		return response()->json($articles);
	}
	
	/**
	 * @param \App\Article             $article
	 * @param \Illuminate\Http\Request $request
	 */
	private function syncOldImages(Article $article, Request $request)
	{
		if (isset($request->old_images_ids)) {
			$this->dissociateAllImages($article->images);
			
			$this->associateImagesWithArticle($article, $request->old_images_ids);
			
			// Make old img as default
			if ($request->is_default_img_old) {
				$this->makeImageDefault($request->default_image_id);
			}
		} else {
			$this->dissociateAllImages($article->images);
		}
	}
	
	/**
	 * @param integer $imageID
	 */
	private function makeImageDefault($imageID)
	{
		$image = Image::find($imageID);
		
		$image->update(['is_default' => true]);
	}
	
	/**
	 * @param \App\Article $article
	 * @param              $idsArray
	 */
	private function associateImagesWithArticle(Article $article, $idsArray)
	{
		$images = Image::find($idsArray);
		
		$article->images()->saveMany($images);
	}
	
	/**
	 * @param \Illuminate\Database\Eloquent\Collection $images
	 */
	private function dissociateAllImages(Collection $images)
	{
		foreach ($images as $image) {
			$image->is_default = false; // make all images not default
			$image->article()->dissociate();
			$image->save();
		}
	}
	
	/**
	 * @param \App\Article             $article
	 * @param \Illuminate\Http\Request $request
	 */
	private function syncTags(Article $article, Request $request)
	{
		if (isset($request->tags_ids)) {
			$tags = Tag::find($request->tags_ids);
			
			$article->tags()->sync($tags);
		} else {
			$article->tags()->detach();
		}
	}
	
	/**
	 * @param \Illuminate\Http\Request $request
	 * @param                          $searchInDraft
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	private function searchArticles(Request $request, $searchInDraft)
	{
		if (!isset($request->sub_category_id)) {
			return $this->searchArticlesWithoutSubCategory($request, $searchInDraft);
		}
		
		return $this->searchArticlesWithSubCategory($request, $searchInDraft);
	}
	
	/**
	 * @param \Illuminate\Http\Request $request
	 * @param                          $searchInDraft
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	private function searchArticlesWithoutSubCategory(Request $request, $searchInDraft)
	{
		return Article::search($request->title)
			->where('is_draft', (int)$searchInDraft)
			->paginate(self::ARTICLES_PER_PAGE);
	}
	
	/**
	 * @param \Illuminate\Http\Request $request
	 * @param                          $searchInDraft
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	private function searchArticlesWithSubCategory(Request $request, $searchInDraft)
	{
		return Article::search($request->title)
			->where('is_draft', (int)$searchInDraft)
			->where('sub_category_id', $request->sub_category_id)
			->paginate(self::ARTICLES_PER_PAGE);
		
	}
	
	/**
	 * @param        $articles
	 * @param        $columnName
	 * @param string $sortBy
	 */
	private function sortByArticlesDates($articles, $columnName, $sortBy = 'newest')
	{
		if ($sortBy === 'oldest') {
			$sortedCollection = $articles->sortBy($columnName)->values();
		} else {
			// newest
			$sortedCollection = $articles->sortByDesc($columnName)->values();
		}
		
		$articles->setCollection($sortedCollection);
	}
	
	/**
	 * @param $articles
	 * @param $columns
	 */
	private function hideColumns($articles, $columns)
	{
		$articles->transform(function($article) use($columns){
			return $article->makeHidden($columns)->toArray();
		});
	}
}