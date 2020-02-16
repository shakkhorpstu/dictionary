<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChaptersController extends Controller
{
    public function show($lang, $slug)
    {
        return view('frontend.pages.chapters.show');
    }
}
