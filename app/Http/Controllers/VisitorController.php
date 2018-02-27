<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class VisitorController extends Controller
{
    public function listPages() {
        $pages = Page::orderBy('created_at', 'asc')->get();
        foreach($pages as $page) {
            $page->page_content = $this->shortenText($page->page_content, 50);
        }
        return view('page.list', ['pages' => $pages]);
    }

    public function getSinglePage($id = 0) {
        $page = Page::find($id);
        return view('page.single_visitor', ['page' => $page]);
    }

    private function shortenText($text, $words_count) {
        if(str_word_count($text, 0) > $words_count) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$words_count]) . '...';
        }

        return $text;
    }
}
