<?php

namespace App\Http\Controllers;
use App\Models\News;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function news()
    {
        $news = News::orderBy("created_at", "desc")->paginate(10);
        return view('news.index', compact('news')); // view resources/views/news/index.blade.php
    }
}
