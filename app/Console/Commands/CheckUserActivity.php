<?php

use Illuminate\Console\Command;
use App\Events\UserInactive;
use App\Models\User;
use Carbon\Carbon;

class CheckUserActivity extends Command
{
    protected $signature = 'user:check-activity';

    protected $description = 'Check user activity and trigger event if inactive';

    public function handle()
    {
        // Récupérer les utilisateurs inactifs depuis un certain temps (par exemple, 30 minutes)
        $inactiveUsers = User::where('last_activity', '<=', Carbon::now()->subMinutes(10))->get();

        foreach ($inactiveUsers as $user) {
            // Déclencher l'événement UserInactive pour chaque utilisateur inactif
            event(new UserInactive());
        }

        $this->info('User activity checked successfully!');
    }
}
