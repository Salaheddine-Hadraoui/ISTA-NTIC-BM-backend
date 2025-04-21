<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


    class EventSeeder extends Seeder
    {
    public function run(): void
    {
        Event::insert([
            [
                'title' => 'Orientation Day',
                'date' => '2025-05-01',
                'time' => '09:00:00',
                'location' => 'Main Hall',
                'description' => 'Welcome session for new students and orientation presentation.',
                'image' => 'orientation.jpg',
                'details' => 'This event provides new students with an overview of the institution, including campus resources and student support services.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Career Fair 2025',
                'date' => '2025-06-15',
                'time' => '10:00:00',
                'location' => 'Auditorium',
                'description' => 'Meet recruiters from top companies and explore job opportunities.',
                'image' => 'career_fair.jpg',
                'details' => 'Students can interact with top employers and learn about various career paths, internships, and job openings.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Hackathon',
                'date' => '2025-07-10',
                'time' => '08:00:00',
                'location' => 'Tech Lab 3',
                'description' => '48-hour coding competition with exciting prizes.',
                'image' => 'hackathon.png',
                'details' => 'Participants will have 48 hours to create innovative projects, collaborate with teammates, and present their solutions.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Cultural Day',
                'date' => '2025-08-20',
                'time' => '13:00:00',
                'location' => 'Outdoor Stage',
                'description' => 'Celebrate the diverse cultures of our students with food, music, and art.',
                'image' => 'cultural_day.jpg',
                'details' => 'A day to showcase student cultures through performances, food stalls, art exhibitions, and more.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Final Exams Begin',
                'date' => '2025-09-05',
                'time' => '08:30:00',
                'location' => 'Classrooms',
                'description' => 'Start of final exams for all departments. Check your schedule.',
                'image' => null,
                'details' => 'The exam period will begin for all students. Be sure to check your exam schedule and room assignments.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
    }
}
