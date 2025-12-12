<?php

namespace Database\Seeders;

use App\Models\Park;
use Illuminate\Database\Seeder;

class ParkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slides = [
            [
                'title' => 'Крещенский парк',
                'description' => 'Горожане с нетерпением ждали долгожданное открытие Крещенского парка в Анапе и уже его посетили, а вот новые жители города не знают, где именно он находится и как сюда можно добраться.',
                'link' => '/temple',
                'link_text' => 'Узнать больше',
                'order' => 0,
                'is_active' => true,
            ],
            [
                'title' => 'Крещенский парк',
                'description' => null,
                'link' => null,
                'link_text' => 'Узнать больше',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Крещенский парк',
                'description' => null,
                'link' => null,
                'link_text' => 'Узнать больше',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Крещенский парк',
                'description' => null,
                'link' => null,
                'link_text' => 'Узнать больше',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $slideData) {
            Park::create($slideData);
        }

        $this->command->info('Созданы '.count($slides).' слайдов для парка');
    }
}
