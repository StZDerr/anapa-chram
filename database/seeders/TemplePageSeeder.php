<?php

namespace Database\Seeders;

use App\Models\TemplePage;
use Illuminate\Database\Seeder;

class TemplePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TemplePage::updateOrCreate(
            ['page_key' => 'temple_main'],
            [
                'title' => 'Храм святого равноапостольного великого князя Владимира',
                'about_text' => 'Горожане с нетерпением ждали долгожданное открытие Крещенского парка в Анапе и уже его посетили, а вот новые жители города не знают, где именно он находится и как сюда можно добраться.',
                'opening_title' => 'Открытие храма',
                'opening_text' => '1 октября 2023 года состоялось открытие Храма Святого равноапостольного Великого князя Владимира',
                'opening_details' => 'Патриарх Московский и всея Руси Кирилл освятил храм в честь святого равноапостольного князя Владимира в городе-курорте Анапа. В ходе мероприятия патриарх подарил храму образ Святой Матроны Московской.',
                'gallery_1_images' => [
                    'images/ChramSvitogo.jpg',
                    'images/derzhavnaya_ikona_bozhej_materi.jpg',
                    'images/galery.jpg'
                ],
                'gallery_2_images' => [
                    'images/ChramSvitogo.jpg',
                    'images/derzhavnaya_ikona_bozhej_materi.jpg',
                    'images/galery.jpg'
                ],
            ]
        );
    }
}
