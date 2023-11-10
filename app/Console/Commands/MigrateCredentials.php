<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MigrateCredentials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credentials:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        self::backup($this);
        return 0;
    }

    static function backup($m = null){

        $users = User::get();

        foreach ($users as $user) {

            User::where('id',$user->id)->update([
                'email_aux'=> $user->email,
                'password_aux'=> $user->password,
                'current_role'=>User::TECNICO,
            ]);

            if($m){
                $m->info($user->email);
            }


        }

    }

    static function backupByID($UserID){

        $user = User::where('id',$UserID)->first();

       if($user){
        User::where('id',$UserID)->update([
            'email_aux'=> $user->email,
            'password_aux'=> $user->password,
        ]);
       }

    }


    static function restoreByUserID($userID){

          $user = User::where('id',$userID)->first();

            User::where('id',$user->id)->update([
                'email'=> $user->email_aux,
                'password'=> $user->password_aux,
            ]);

        
    }
}
