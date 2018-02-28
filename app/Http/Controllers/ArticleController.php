<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\Articles\DeleteRequest;
use App\Http\Requests\Articles\EditArticleRequest;
use App\Http\Requests\Articles\GetAllDraftArticlesRequest;
use App\Http\Requests\Articles\GetAllPublishedArticlesRequest;
use App\Http\Requests\Articles\GetArticleRequest;
use App\Http\Requests\Articles\MarkArticleAsDraftRequest;
use App\Http\Requests\Articles\MarkArticleAsPublishedRequest;
use App\Http\Requests\Articles\SearchDraftArticlesRequest;
use App\Http\Requests\Articles\SearchPublishedArticlesRequest;
use App\Http\Requests\Articles\StoreArticleRequest;
use App\Jobs\DeleteArticle;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
	const ARTICLES_PER_PAGE    = 12;
	const DELETE_AFTER_MINUTES = 15;
	
	private $request;
	
	private $additionalRequestData;
	
	private $article;
	
	private $articlesCollection;
	
	/**
	 * @param \App\Http\Requests\Articles\GetArticleRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getArticle(GetArticleRequest $request)
	{
		$where = [
			['id', $request->id],
		];
		
		$select = [
			'id',
			'title',
			'content',
			'user_id',
			'is_draft',
			'sub_category_id',
			'created_at',
			'updated_at',
			'deletion_at',
		];
		
		$with = [
			'author:id,name',
			'headerImage',
			'tags',
			'images',
			'subCategory' => function ($query) {
				$query->select('id', 'name', 'category_id')->with('category:id,name');
			},
		];
		
		// If user isn`t moderator allow search only in published articles
		if (Auth::guest() || (Auth::check() && !$request->user()->isBlessed())) {
			$where[] = ['is_draft', 0];
		}
		
		// Get article
		$this->article = Article::select($select)->where($where)->with($with)->first();
		
		// If article not found send 204 status code
		$responseCode = ($this->article === null) ? 204 : 200;
		
		return response()->json($this->article, $responseCode);
	}
	
	/**
	 * @param \App\Http\Requests\Articles\GetAllArticlesRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getAllPublishedArticles(GetAllPublishedArticlesRequest $request)
	{
		$this->request = $request;
		$orderBy       = 'created_at';
		$with          = 'headerImage';
		$where         = [['is_draft', false]];
		$select        = ['id', 'title', 'sub_category_id', 'created_at'];
		$isDesc        = (isset($this->request->order_by) && $this->request->order_by === 'oldest') ? 'asc' : 'desc';
		
		// if sub_category_id selected
		if (isset($this->request->sub_category_id)) {
			$where[] = ['sub_category_id', $this->request->sub_category_id];
		}
		
		// Get article
		$this->articlesCollection = Article::select($select)
			->where($where)
			->with($with)
			->orderBy($orderBy, $isDesc)
			->paginate(self::ARTICLES_PER_PAGE);
		
		return response()->json($this->articlesCollection);
	}
	
	/**
	 * @param \App\Http\Requests\Articles\GetAllDraftArticlesRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getAllDraftArticles(GetAllDraftArticlesRequest $request)
	{
		$orderBy = 'created_at';
		$with    = 'headerImage';
		$where   = [['is_draft', true]];
		$select  = ['id', 'title', 'sub_category_id', 'created_at'];
		$isDesc  = (isset($request->order_by) && $request->order_by === 'oldest') ? 'asc' : 'desc';
		
		$this->articlesCollection = Article::select($select)
			->where($where)
			->with($with)
			->orderBy($orderBy, $isDesc)
			->paginate(self::ARTICLES_PER_PAGE);
		
		return response()->json($this->articlesCollection);
	}
	
	/**
	 * @param \App\Http\Requests\Articles\StoreArticleRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(StoreArticleRequest $request)
	{
		$this->request               = $request;
		$this->article               = new Article();
		$this->additionalRequestData = [
			'user_id'     => Auth::id(),
			'deletion_at' => now()->addMinutes(self::DELETE_AFTER_MINUTES),
			'content'     => $this->request->get('content'),
		];
		
		// Marge additional data with request
		$this->request->merge($this->additionalRequestData);
		
		// Create new Article
		$this->article->fill($this->request->all())->save();
		
		// Store and sync tags with article
		$this->article->syncTags($this->request->tags_ids);
		
		// Store and sync images with article
		$this->article->storeImages(
			$this->request->file('images'),
			$this->request->get('is_default_img_old'),
			$this->request->get('default_img_id')
		);
		
		// Create job
		DeleteArticle::dispatch($this->article)->delay($this->request->get('deletion_at'));
		
		return response()->json($this->article->id);
	}
	
	/**
	 * @param \App\Http\Requests\Articles\EditArticleRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function edit(EditArticleRequest $request)
	{
		$this->request = $request;
		$this->article = Article::find($this->request->id);
		
		// update fillable fields
		$this->article->update($this->request->all());
		
		// Edit article tags
		$this->article->syncTags($this->request->tags_ids);
		
		// Sync old article images
		$this->article->syncOldImages(
			$this->request->get('old_images_ids'),
			$this->request->get('is_default_img_old'),
			$this->request->get('default_image_id')
		);
		
		// Store and sync new images with article
		$this->article->storeImages(
			$this->request->file('images'),
			$this->request->get('is_default_img_old'),
			$this->request->get('default_image_id')
		);
		
		return response()->json($this->article->id);
	}
	
	/**
	 * @param \App\Http\Requests\Articles\MarkArticleAsDraftRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function markArticleAsDraft(MarkArticleAsDraftRequest $request)
	{
		$this->article = Article::find($request->id);
		
		$this->article->is_draft = true;
		$this->article->save();
		
		return response()->json(true);
	}
	
	/**
	 * @param \App\Http\Requests\Articles\MarkArticleAsPublishedRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function markArticleAsPublished(MarkArticleAsPublishedRequest $request)
	{
		$this->article = Article::find($request->id);
		
		$this->article->is_draft = false;
		$this->article->save();
		
		return response()->json(true);
	}
	
	/**
	 * @param \App\Http\Requests\Articles\DeleteRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(DeleteRequest $request)
	{
		$this->article = Article::find($request->id);
		
		$this->article->forceDelete();
		
		return response()->json(true);
	}
	
	/**
	 * @param \App\Http\Requests\Articles\SearchPublishedArticlesRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function searchInPublishedArticles(SearchPublishedArticlesRequest $request)
	{
		$this->request = $request;
		
		// Find articles
		$this->articlesCollection = $this->searchArticles(false);
		$this->articlesCollection->load('headerImage');
		
		// If user choose orderBy, by oldest articles
		$this->sortByArticlesDates('created_at', $this->request->get('order_by'));
		
		// Remove columns
		$this->hideColumns(['content', 'sub_category_id', 'is_draft']);
		
		return response()->json($this->articlesCollection->toArray());
	}
	
	/**
	 * @param \App\Http\Requests\Articles\SearchDraftArticlesRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function searchInDraftArticles(SearchDraftArticlesRequest $request)
	{
		$this->request = $request;
		
		// Find articles
		$this->articlesCollection = $this->searchArticles(true);
		$this->articlesCollection->load('headerImage');
		
		// If user choose orderBy, by oldest articles
		$this->sortByArticlesDates('created_at', $this->request->get('order_by'));
		
		// Remove columns
		$this->hideColumns(['content', 'sub_category_id', 'is_draft']);
		
		return response()->json($this->articlesCollection->toArray());
	}
	
	/**
	 * @param boolean $searchInDraft
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	private function searchArticles($searchInDraft)
	{
		if ($this->request->get('sub_category_id', false)) {
			return $this->searchArticlesWithSubCategory($searchInDraft);
		}
		
		return $this->searchArticlesWithoutSubCategory($searchInDraft);
	}
	
	/**
	 * @param boolean $searchInDraft
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	private function searchArticlesWithoutSubCategory($searchInDraft)
	{
		return Article::search($this->request->get('title'))
			->where('is_draft', (int)$searchInDraft)
			->paginate(self::ARTICLES_PER_PAGE);
	}
	
	/**
	 * @param boolean $searchInDraft
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	private function searchArticlesWithSubCategory($searchInDraft)
	{
		return Article::search($this->request->get('title'))
			->where('is_draft', (int)$searchInDraft)
			->where('sub_category_id', $this->request->get('sub_category_id'))
			->paginate(self::ARTICLES_PER_PAGE);
		
	}
	
	/**
	 * @param string $columnName
	 * @param string $sortBy
	 */
	private function sortByArticlesDates($columnName, $sortBy = 'newest')
	{
		if ($sortBy === 'oldest') {
			$sortedCollection = $this->articlesCollection->sortBy($columnName)->values();
		} else {
			// newest
			$sortedCollection = $this->articlesCollection->sortByDesc($columnName)->values();
		}
		
		$this->articlesCollection->setCollection($sortedCollection);
	}
	
	/**
	 * @param array $columns
	 */
	private function hideColumns($columns)
	{
		$this->articlesCollection->transform(function ($article) use ($columns) {
			return $article->makeHidden($columns)->toArray();
		});
	}
}