<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class FetchUserInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get pertinent deets on all users';

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
     * @return int
     */
    public function handle()
    {
        // I want to show all users, their emails, a count of their resumes
        while(true) {
            $headers = ['Name', 'Email', 'Resumes', 'Joined', 'Last Active', 'TS'];
            $userArray = [];

            foreach (User::with('resumes')->cursor() as $user) {
                array_push($userArray, [$user->fullName, $user->email, count($user->resumes), $user->created_at, $user->last_active_date, $user->last_active_timestamp]);
            }

            system('clear');

            $userArray = collect($userArray)->sortBy(function($user) {
                return $user[5]; // order by last active timestamp attribute
            }, SORT_DESC);
            
            $this->table($headers, $userArray);

            $this->info('Press ctrl + c to quit');

            sleep(5);
        }

        return 0;
    }
}
