<?php

namespace Database\Seeders;

use App\Models\TemplePage;
use Illuminate\Database\Seeder;

class DerzhavnayaIkonaSeeder extends Seeder
{
    public function run()
    {
        TemplePage::updateOrCreate(
            ['page_key' => 'derzhavnaya-ikona'],
            [
                'title' => 'Державная икона Божией Матери',
                'about_text' => 'Державная икона Божией Матери является одной из самых почитаемых святынь Русской Православной Церкви. Образ явился 2 марта 1917 года и стал символом небесного покровительства Богородицы над нашей землёй.',
                'opening_title' => 'Явление иконы',
                'opening_text' => 'По преданию, икона явилась в деревне Коломенском в дни великих потрясений России, указывая на особое покровительство Царицы Небесной.',
                'opening_details' => 'Образ был обретён в Красном Селе и перенесён в храм Вознесения Господня. Икона символизирует духовную власть Богородицы и её заботу о народе. Многие верующие приходят с молитвами и получают утешение и помощь.',
                'gallery_1_images' => [
                    'images/derzhavnaya_1.jpg',
                    'images/derzhavnaya_2.jpg',
                    'images/derzhavnaya_3.jpg',
                ],
                'gallery_2_images' => [
                    'images/derzhavnaya_4.jpg',
                    'images/derzhavnaya_5.jpg',
                    'images/derzhavnaya_6.jpg',
                ],
            ]
        );
    }
}
