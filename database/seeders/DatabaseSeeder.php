<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Filiers;
use App\Models\Module;
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

        
        // Filiers::insert([
            
        //         [
        //             'name' => 'Développement Digital',
        //             'description' => 'Formation aux fondamentaux du développement d\'applications web et mobile.'
        //         ],
        //         [
        //             'name' => 'Développement Digital option Web Full Stack',
        //             'description' => 'Spécialisation dans les technologies front-end et back-end pour les applications web.'
        //         ],
        //         [
        //             'name' => 'Infrastructure Digitale',
        //             'description' => 'Formation sur les bases des réseaux, systèmes, et support informatique.'
        //         ],
        //         [
        //             'name' => 'Infrastructure Digitale option Systèmes et Réseaux',
        //             'description' => 'Approfondissement des compétences en administration systèmes et gestion des réseaux.'
        //         ]
        //     ]);
            $modules = [
                'Front-end',
                'Back-end',
                'Sites Web Statique',
                'Sites Web Dynamiques',
                'Préparation d\'un Projet',
                'Gestion des Données',
                'Approche Agile'
            ];
    
            foreach ($modules as $module) {
                Module::create([
                    'name' => $module,
                ]);
            }

        $modules = Module::all(); 

        // Insert 10 fake courses
        foreach (range(1, 10) as $index) {
            Course::create([
                'name' => 'Course ' . $index, 
                'course_pdf' => 'https://example.com/course' . $index . '.pdf',
                'module_id' => $modules->random()->id, 
            ]);
        }
    }
}
