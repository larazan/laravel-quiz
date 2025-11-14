<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Contact;
use App\Models\User;
use App\Models\Report;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(30)->create();
        // Contact::factory(40)->create();
        // Report::factory(20)->create();
        // Article::factory(30)->create();

        $this->call([
            // CategorySeeder::class,
            // TypeSeeder::class,
            // QuizzesSeeder::class,
            // QuestionSeeder::class,
            // OptionSeeder::class,
            // QuizQuestionSeeder::class,
            // AttemptSeeder::class,
            // AnswerSeeder::class,
            // FaqSeeder::class,
            // SegmentSeeder::class,
            // SettingSeeder::class,
            // RoleSeeder::class,
            CategoryArticleSeeder::class,
        ]);
    }
}
