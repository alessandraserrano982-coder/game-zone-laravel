<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [
                'title' => 'Silent Hill 1',
                'description' => 'Adéntrate en el misterio del pueblo maldito.',
                'price' => 379.00,
                'image' => 'https://m.media-amazon.com/images/M/MV5BMVBhOTg1YzctOWViMi00Yjk3LTlmZmEtOTZhMzM1MDNkZmNhXkEyXkFqcGdeQXVyMTA0MTM5NjI2._V1_.jpg',
                'stock' => 10,
            ],
            [
                'title' => 'Silent Hill 2',
                'description' => 'Historia psicológica sobre la culpa.',
                'price' => 424.00,
                'image' => 'https://m.media-amazon.com/images/M/MV5BMjA4ODkxMzQ2MV5BMl5BanBnXkFtZTgwNTQyMjE3MDE@._V1_.jpg',
                'stock' => 10,
            ],
            [
                'title' => 'Silent Hill 3',
                'description' => 'La tétrica continuación con Heather Mason.',
                'price' => 399.00,
                'image' => 'https://m.media-amazon.com/images/M/MV5BNTBhMTk2NzEtYmIyYy00MjEwLTg5NjUtOWQ5ZmI1N2YyNDQyXkEyXkFqcGdeQXVyMTA0MTM5NjI2._V1_.jpg',
                'stock' => 10,
            ],
            [
                'title' => 'Resident Evil 1',
                'description' => 'El inicio de la leyenda del survival horror en la mansión Spencer.',
                'price' => 349.00,
                'image' => 'https://m.media-amazon.com/images/M/MV5BMjE3MjYzNjAxMl5BMl5BanBnXkFtZTcwMjE0NzEyMQ@@._V1_.jpg',
                'stock' => 10,
            ],
            [
                'title' => 'Resident Evil 2',
                'description' => 'Secuela emblemática de supervivencia en Raccoon City.',
                'price' => 399.00,
                'image' => 'https://m.media-amazon.com/images/M/MV5BMjA4ODkxMzQ2MV5BMl5BanBnXkFtZTgwNTQyMjE3MDE@._V1_.jpg',
                'stock' => 10,
            ],
            [
                'title' => 'Resident Evil 3',
                'description' => 'Escape de la persecución implacable de Némesis.',
                'price' => 419.00,
                'image' => 'https://m.media-amazon.com/images/M/MV5BMjE3MjYzNjAxMl5BMl5BanBnXkFtZTcwMjE0NzEyMQ@@._V1_.jpg',
                'stock' => 10,
            ],
            [
                'title' => 'Dino Crisis',
                'description' => 'Más acción arcade contra acción táctica.',
                'price' => 329.00,
                'image' => 'https://m.media-amazon.com/images/M/MV5BMjE3MjYzNjAxMl5BMl5BanBnXkFtZTcwMjE0NzEyMQ@@._V1_.jpg',
                'stock' => 10,
            ],
            [
                'title' => 'Dino Crisis 2',
                'description' => 'Más acción arcade contra acción táctica.',
                'price' => 349.00,
                'image' => 'https://m.media-amazon.com/images/M/MV5BMjE3MjYzNjAxMl5BMl5BanBnXkFtZTcwMjE0NzEyMQ@@._V1_.jpg',
                'stock' => 10,
            ],
            [
                'title' => 'Left 4 Dead',
                'description' => 'Cooperativo definitivo contra hordas zombis.',
                'price' => 299.00,
                'image' => 'https://m.media-amazon.com/images/M/MV5BMjE3MjYzNjAxMl5BMl5BanBnXkFtZTcwMjE0NzEyMQ@@._V1_.jpg',
                'stock' => 10,
            ], 
            [
                'title' => 'Left 4 Dead 2',
                'description' => 'Cooperativo definitivo contra hordas zombis.',
                'price' => 329.00,
                'image' => 'https://m.media-amazon.com/images/M/MV5BMjE3MjYzNjAxMl5BMl5BanBnXkFtZTcwMjE0NzEyMQ@@._V1_.jpg',
                'stock' => 10,
            ]
        ];

        foreach ($games as $game) {
            Game::create($game);
        }
    }
}