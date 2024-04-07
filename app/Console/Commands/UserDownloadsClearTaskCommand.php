<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UserDownloadsClearTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'userdownloads:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear user downloads metrics';

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
     * Check use downloads and clear them
     *
     * @return int
     */
    public function handle()
    {
        # Get all users
        $users = User::all();
        
        foreach($users as $user) {
            $user->downloaded = 0;
            $user->save();
        }
    }
}
