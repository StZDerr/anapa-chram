<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParkRulesSeeder extends Seeder
{
    public function run()
    {
        DB::table('park_rules')->insert([
            'allowed_title' => 'Правила посещения 123',
            'allowed_subtitle' => 'на территории парка крещения руси',
            'prohibited_title' => 'Запрещается11223',
            'prohibited_subtitle' => 'на территории парка крещения руси',
            'items' => json_encode([
                [
                    'id' => '230f2c8a-af14-44b2-ac61-5204669bc57b',
                    'svg' => null,
                    'order' => 0,
                    'title' => 'Соблюдайте общепринятые нормы поведения, не наносите повреждений имуществу парка.',
                    'category' => 'allowed',
                ],
                [
                    'id' => 'd54461be-92c2-46b8-9982-2b22ef9025a6',
                    'svg' => null,
                    'order' => 1,
                    'title' => 'Соблюдайте правила пользования детскими и спортивными площадками.',
                    'category' => 'allowed',
                ],
                [
                    'id' => '27a6499e-b460-444e-9977-58a86518e077',
                    'svg' => null,
                    'order' => 2,
                    'title' => 'Соблюдайте правила пожарной безопасности.',
                    'category' => 'allowed',
                ],
                [
                    'id' => '16408a4d-ef8e-4c13-a338-2bc5da2bbafb',
                    'svg' => null,
                    'order' => 3,
                    'title' => 'В случае обнаружения вещей без присмотра, пакетов, сумок и т.д. которые могут влиять на безопасность посетителей на территории парка, сообщить сотрудникам парка.',
                    'category' => 'allowed',
                ],
                [
                    'id' => '3bed7d0e-6be2-444b-925b-17589869c9a8',
                    'svg' => 'park-rules/VGFhHM4gWEcmF1VSwXiZmYt02RBhDIL2byWeuOM9.svg',
                    'order' => 4,
                    'title' => 'Запрещается курение и распитие спиртных напитков на территории парка.',
                    'category' => 'prohibited',
                ],
                [
                    'id' => '498153e3-847f-48ef-8f38-217753596552',
                    'svg' => 'park-rules/TCH2wIFxmFdsQW8fCxitzB5QPVkKaqKOmAZDGfFl.svg',
                    'order' => 5,
                    'title' => 'Запрещается проезд на велосипедах, роликах, самокатах, скутерах.',
                    'category' => 'prohibited',
                ],
                [
                    'id' => '9f234227-3aa4-44ff-8b4e-fdb8cdfdc41a',
                    'svg' => 'park-rules/DJCqS15FC78YGGnC7XVi03EvdZzWd2MJkxrvKfx9.svg',
                    'order' => 6,
                    'title' => 'Запрещается оставлять детей без присмотра.',
                    'category' => 'prohibited',
                ],
                [
                    'id' => 'a175a3b8-3ece-4f25-b603-073464e10a57',
                    'svg' => 'park-rules/1mehTmGByFJB5KuX8FXkeKRamdEgrXNAmw5lqfOe.png',
                    'order' => 7,
                    'title' => 'В случае обнаружения вещей без присмотра, пакетов, сумок и т.д. которые могут влиять на безопасность посетителей на территории парка, сообщить сотрудникам парка.',
                    'category' => 'allowed',
                ],
                [
                    'id' => '4d9ecff3-4965-4856-9a61-ea79d953cd69',
                    'svg' => null,
                    'order' => 8,
                    'title' => 'Запрещается оставлять детей без присмотра.',
                    'category' => 'prohibited',
                ],
                [
                    'id' => '58035124-c6c3-42ca-9c5e-0a963c973c16',
                    'svg' => null,
                    'order' => 9,
                    'title' => '123',
                    'category' => 'prohibited',
                ],
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
