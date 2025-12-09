<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run()
    {
        // Создадим 10 тестовых новостей
        for ($i = 1; $i <= 10; $i++) {
            News::create([
                'title' => "Тестовая новость №$i",
                'content' => "
                    <h2>Заголовок секции</h2>
                    <p>Это пример длинного HTML-контента для новости №$i. 
                    Здесь может быть <strong>жирный текст</strong>, изображения, списки, выделения 
                    и любые другие элементы.</p>
                    
                    <h3>Блок информации</h3>
                    <p>Тут может быть текст с подзаголовком.</p>

                    <ul>
                        <li>Пункт 1</li>
                        <li>Пункт 2</li>
                    </ul>

                    <p>А вот <a href='#'>ссылка</a>.</p>
                ",
                'img_preview' => 'https://placehold.co/600x400?text=Preview+'.$i,
                'status' => ['draft', 'pending', 'published'][array_rand(['draft', 'pending', 'published'])],
                'published_at' => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}
