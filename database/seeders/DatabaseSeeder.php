<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Poste;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PosteSeeder::class);

        // Insérer des utilisateurs avec un ID de poste spécifique
        $poste1 = Poste::where('nom', 'CONTRÔLEUR')->first();

        $user = User::create([
            'name' => 'David Kouachi',
            'email' => 'david@gmail.com',
            'password' => bcrypt('12345'),
            'matricule' => 'C123456',
            'tel' => '0585782723',
            'poste_id' => $poste1->id,
        ]);

        $poste2 = Poste::where('nom', 'OPÉRATEUR DE SAISIE')->first();

        $user = User::create([
            'name' => 'Kouachi Chris',
            'email' => 'kouachi@gmail.com',
            'password' => bcrypt('12345'),
            'matricule' => 'C123457',
            'tel' => '0585782723',
            'poste_id' => $poste2->id,
        ]);
    }
}
