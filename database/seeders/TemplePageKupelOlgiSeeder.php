<?php

namespace Database\Seeders;

use App\Models\TemplePage;
use Illuminate\Database\Seeder;

class TemplePageKupelOlgiSeeder extends Seeder
{
    public function run()
    {
        TemplePage::updateOrCreate(
            ['page_key' => 'kupel-olgi'],
            [
                'title' => 'Купель святой равноапостольной княгини Ольги',
                'about_text' => 'Купель княгини Ольги — одно из благословенных мест, куда приходят за духовным укреплением, молитвой и очищением. Здесь каждый может окунуться в святую воду, помолиться и получить утешение.',
                'opening_title' => 'История и значение купели',
                'opening_text' => 'Купель освящена в честь святой равноапостольной княгини Ольги и является одним из почитаемых мест для омовений и молитвы.',
                'opening_details' => 'Святая Ольга стала первой правительницей, принявшей христианство. Купель, названная в её честь, символизирует духовное очищение, укрепление веры и обновление души.',
                'gallery_1_images' => [
                    'images/kupel_olgi_1.jpg',
                    'images/kupel_olgi_2.jpg',
                    'images/kupel_olgi_3.jpg',
                ],
                'gallery_2_images' => [
                    'images/kupel_olgi_4.jpg',
                    'images/kupel_olgi_5.jpg',
                    'images/kupel_olgi_6.jpg',
                ],
            ]
        );
    }
}
