<?php

namespace App\Jobs;

use App\Tag;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteTag implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $tag;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }
	
	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
    {
		$this->tag->forceDelete();
    }
}
