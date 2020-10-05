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
        $users = User::all();
        $output_string = "Name\t\tEmail\t\t\tResumes\n";

        foreach ($users as $user) {
            $output_string .= $user->report_information . "\n";
        }


        $this->output->write($output_string);

        return 0;
    }
}
