<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{

    /**
     * index
     *
     * @return void Home Page Screen
     */
    public function index()
    {
        $chapters = DB::table('chapters')
            ->where('parent_chapter_id', null)
            ->select('id', 'name', 'parent_chapter_id')
            ->get();
        return view('frontend.pages.index', compact('chapters'));
    }
}
