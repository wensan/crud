<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Page;
use App\Reply;
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

    public function replyComment(Request $request) {
        $user = $this->getLogUser();
        $reply = new Reply();
        $reply->body = $request["reply"];
        $reply->user()->associate($user);
        $reply->is_hidden = false;
        $reply->comment_id = $request["comment_id"];
        $reply->save();

        $replies = Reply::where([
                              ['comment_id', $request["comment_id"]],
                              ['is_hidden', false]
                          ])
                        ->get();
        return view('comment.reply', ['replies' => $replies, 'user' => $user]);
    }

    public function hideComment($id = 0) {
        $comment = Comment::find($id);
        $comment->is_hidden = true;
        $saved = $comment->save();
        $ok = true;
        if (!$saved) {
            $ok = false;
        }
        return response()->json([
            'data' => [
                'message' => $ok ? 'Successfully updated.' : "There was an error.",
                'status' => $ok ? 200 : 500
            ]
        ]);
    }

    public function deleteComment($id = 0) {
        $comment = Comment::find($id);
        $saved = $comment->delete();
        $ok = true;
        if (!$saved) {
            $ok = false;
        }
        return response()->json([
            'data' => [
                'message' => $ok ? 'Successfully deleted.' : "There was an error.",
                'status' => $ok ? 200 : 500
            ]
        ]);
    }

    public function hideReply($id = 0) {
        $reply = Reply::find($id);
        $reply->is_hidden = true;
        $saved = $reply->save();
        $ok = true;
        if (!$saved) {
            $ok = false;
        }
        return response()->json([
            'data' => [
                'message' => $ok ? 'Successfully updated.' : "There was an error.",
                'status' => $ok ? 200 : 500
            ]
        ]);
    }

    public function deleteReply($id = 0) {
        $reply = Reply::find($id);
        $saved = $reply->delete();
        $ok = true;
        if (!$saved) {
            $ok = false;
        }
        return response()->json([
            'data' => [
                'message' => $ok ? 'Successfully deleted.' : "There was an error.",
                'status' => $ok ? 200 : 500
            ]
        ]);
    }

    public function listReplies(Request $request) {
        $user = $this->getLogUser();        
        $replies = Reply::where([
                              ['comment_id', $request["comment_id"]],
                              ['is_hidden', false]
                          ])
                        ->get();
        return view('comment.reply', ['replies' => $replies, 'user' => $user]);
    }

    private function getLogUser() {
        $user = JWTAuth::toUser();
        return $user;
    }
}
