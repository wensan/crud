<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddPageRequest;
use App\Page;
use JWTAuth;

class PageController extends Controller
{
    public function __construct() {
        $this->middleware("jwt.auth");
    }

    public function listPages() {
        $pages = Page::orderBy('created_at', 'asc')->get();
        $user = $this->checkUser();
        foreach($pages as $page) {
            $page->page_content = $this->shortenText($page->page_content, 50);
        }
        return view('page.list', ['pages' => $pages, 'user' => $user]);
    }

    public function getSinglePage($id = null) {
        $page = Page::find($id);
        $user = $this->checkUser();
        return view('page.single', ['page' => $page, 'user' => $user]);
    }

    public function add_page(AddPageRequest $request) {
        $page = new Page();
        $page->title = $request->title;
        $page->page_content = $request->page_content;
        $page->user()->associate($request->user());
        $user = $this->checkUser();
        if ($user->role == "admin") {
            $page->save();
            return response()->json([
                'data' => [
                    'message' => 'Successfully saved.',
                    'status' => 200
                ]
            ]);
        } else {
          return response()->json([
              'data' => [
                  'status' => 404,
                  'message' => 'Unauthorized user.'
              ]
          ]);
        }
    }

    private function checkUser() {
        $user = JWTAuth::toUser();
        return $user;
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
