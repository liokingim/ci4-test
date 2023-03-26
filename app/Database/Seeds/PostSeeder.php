<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class PostSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 10; $i++) { //to add 10 posts. Change limit as desired
            $this->db->table('post')->insert($this->generatePost());
        }
    }

    private function generatePost(): array
    {
        $faker = Factory::create();
        return [
            'title' => $faker->sentence,
            'author' => $faker->name,
            'content' => $faker->paragraphs(4, true),
        ];
    }
}
