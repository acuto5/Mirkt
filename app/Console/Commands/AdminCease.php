<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class AdminCease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	protected $signature = 'admin:cease {--id= : User id.} {--name= : User name}';
	
	
	/**
     * The console command description.
     *
     * @var string
     */
	protected $description = 'Remove admin role';
	
	
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
			$user->is_admin = false;
			$user->save();
		
			$this->info($user->name . ' admin role removed!');
		} elseif ($this->option('name')){
			$user = User::where('name', $this->option('name'))->firstOrFail();
			$user->is_admin = false;
			$user->save();
		
			$this->info($user->name . ' admin role removed!');
		} else{
			$this->error('Specify user id or name.');
		}
    }
}
