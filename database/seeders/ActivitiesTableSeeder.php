<?php

namespace Database\Seeders;

use App\Models\Activity;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ActivitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('ru_RU');

        $statuses = ['draft', 'pending', 'published'];

        $images = [
            'https://picsum.photos/seed/activity1/800/600',
            'https://picsum.photos/seed/activity2/800/600',
            'https://picsum.photos/seed/activity3/800/600',
            'https://picsum.photos/seed/activity4/800/600',
            'https://picsum.photos/seed/activity5/800/600',
        ];

        for ($i = 1; $i <= 8; $i++) {
            $title = mb_substr($faker->sentence(rand(3, 6)), 0, 255);
            $slug = Str::slug($title);

            // Обеспечим уникальность слага
            while (Activity::where('slug', $slug)->exists()) {
                $slug = Str::slug($title).'-'.rand(1000, 9999);
            }

            $img = $images[array_rand($images)];

            $content = '<figure class="image-style-align-right"><img src="'.$img.'" alt="'.e($title).'"></figure>';
            $content .= '<p>'.$faker->paragraphs(rand(2, 4), true).'</p>';
            $content .= '<p>'.$faker->paragraph.'</p>';

            $status = $statuses[array_rand($statuses)];

            $publishedAt = null;
            if ($status === 'published') {
                // опубликовано — случайная прошедшая дата
                $publishedAt = Carbon::now()->subDays(rand(0, 30))->format('Y-m-d');
            } else {
                // черновик/в ожидании — будущая дата (или можно использовать today())
                $publishedAt = Carbon::now()->addDays(rand(1, 30))->format('Y-m-d');
            }

            Activity::create([
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'img_preview' => $img,
                'status' => $status,
                'published_at' => $publishedAt,
            ]);
        }
    }
}
