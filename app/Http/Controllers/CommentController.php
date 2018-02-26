<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Page;
use JWTAuth;

class CommentController extends Controller
{
    public function __construct() {
        $this->middleware("jwt.auth");
    }

    public function getComments(Request $request) {
        $user = $this->getLogUser();
        $id = $request["id"];
        $comments = Comment::where([['page_id', $id],['is_hidden', false]])
                            ->orderBy('created_at', 'desc')
                            ->get();
        return view('comment.comment', ['comments' => $comments, 'user' => $user]);
    }

    public function addComment(Request $request) {
        $user = $this->getLogUser();
        $comment = new Comment();
        $comment->body = $request["comment"];
        $comment->user()->associate($user);
        $comment->page_id = $request["id"];
        $comment->is_hidden = false;
        $comment->save();

        $comments = Comment::where([
                            ['page_id', $request["id"]],
                            ['is_hidden', false]])
                            ->orderBy('created_at', 'desc')
                            ->get();
        return view('comment.comment', ['comments' => $comments, 'user' => $user]);
    }

    private function getLogUser() {
        $user = JWTAuth::toUser();
        return $user;
    }
}
