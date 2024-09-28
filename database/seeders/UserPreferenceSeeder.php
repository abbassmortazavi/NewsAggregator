<?php

namespace Database\Seeders;

use App\Models\Preference;
use Illuminate\Database\Seeder;

class UserPreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Preference::query()->create([
            'user_id' => 1,
            'authors' => ['John Doe', 'Jane Smith'],
            'categories' => ['Technology', 'Science'],
            'sources' => ['NewsAPI', 'BBC'],
        ]);
    }
}
