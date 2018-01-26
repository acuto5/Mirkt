<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class ModeratorPromotion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	protected $signature = 'moderator:promote {--id= : User id.} {--name= : User name}';

    /**
     * The console command description.
     *
     * @var string
     */
	protected $description = 'Promote user to moderator role';
	
	
	/**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		if($this->option('id')){
			$id = $this->option('id');
			$user = User::findOrFail($id);
			$user->is_moderator = true;
			$user->save();
		
			$this->info($user->name . ' now have moderator role!');
		} elseif ($this->option('name')){
			$user = User::where('name', $this->option('name'))->firstOrFail();
			$user->is_moderator = true;
			$user->save();
		
			$this->info($user->name . ' now have moderator role!');
		} else{
			$this->error('Specify user id or name.');
		}
    }
}
