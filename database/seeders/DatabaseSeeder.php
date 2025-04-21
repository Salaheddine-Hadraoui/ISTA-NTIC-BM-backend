<?php

namespace Database\Seeders;

use App\Models\Filiers;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        
        Filiers::insert([
            
                [
                    'name' => 'Développement Digital',
                    'description' => 'Formation aux fondamentaux du développement d\'applications web et mobile.'
                ],
                [
                    'name' => 'Développement Digital option Web Full Stack',
                    'description' => 'Spécialisation dans les technologies front-end et back-end pour les applications web.'
                ],
                [
                    'name' => 'Infrastructure Digitale',
                    'description' => 'Formation sur les bases des réseaux, systèmes, et support informatique.'
                ],
                [
                    'name' => 'Infrastructure Digitale option Systèmes et Réseaux',
                    'description' => 'Approfondissement des compétences en administration systèmes et gestion des réseaux.'
                ],
                [
                    'name' => 'Certification Microsoft Office Specialist en Excel',
                    'description' => 'Formation à l\'utilisation avancée d\'Excel avec certification officielle Microsoft.'
                ]
            ]);
    }
}
