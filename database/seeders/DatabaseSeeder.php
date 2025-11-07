<?php

namespace Database\Seeders;

use App\Models\Contact;
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
        User::factory(30)->create();
        Contact::factory(40)->create();

        $this->call([
            CategorySeeder::class,
            TypeSeeder::class,
            QuizzesSeeder::class,
            QuestionSeeder::class,
            OptionSeeder::class,
            QuizQuestionSeeder::class,
            AttemptSeeder::class,
            AnswerSeeder::class,
            FaqSeeder::class,
            SegmentSeeder::class,
        ]);
    }
}
