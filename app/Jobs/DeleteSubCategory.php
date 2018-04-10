<?php

namespace App\Jobs;

use App\SubCategory;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteSubCategory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subCategory;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SubCategory $subCategory)
    {
        $this->subCategory = $subCategory;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->subCategory->forceDelete();
    }
}
