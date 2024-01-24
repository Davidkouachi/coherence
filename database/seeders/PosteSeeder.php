<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poste;

class PosteSeeder extends Seeder
{

    public function run()
    {
        Poste::create(['nom' => 'CONTRÔLEUR', 'occupe' => 'oui']);
        Poste::create(['nom' => 'OPÉRATEUR DE SAISIE', 'occupe' => 'non']);
        Poste::create(['nom' => 'ADMINISTRATEUR', 'occupe' => 'non']);
        Poste::create(['nom' => 'PRODUCTION', 'occupe' => 'non']);
        Poste::create(['nom' => 'VALIDATEUR', 'occupe' => 'non']);
    }
}
