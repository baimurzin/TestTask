<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\User;
use App\Vote;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class PostController extends BaseController
{

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function renderIndexPage()
    {
        $this->data['posts'] = Post::all();

        return view('index', $this->data);
    }

    public function renderNewPostPage()
    {
        return view('pages.newpost', $this->data);
    }

    public function renderOnePostPage($id)
    {
        if (!is_numeric($id))
            return view('errors.503');

        $post = Post::find($id);
        if (!$post)
            return view('errors.404');
        $this->data['post'] = $post;
        $this->data['comments'] = $this->allComments($id);
        return view('pages.post', $this->data);
    }

    public function getCommentsByPostId($postId)
    {
        if (!is_numeric($postId))
            return \Response::json(['message' => 'Error'], 500);

        $comments = Comment::wherePostId($postId)->get();
        foreach ($comments as $comment) {
            $comment->parent = $comment->parent_id;
        }
        return \Response::json($comments);

    }

    public function createPost()
    {
        $text = Input::get('text');
        $post = new Post();
        $post->text = $text;
        $post->user_id = $this->data['user']->id;
        $post->save();
        return redirect('/');
    }

    public function createComment($postId)
    {
        $text = Input::get('text');
        $comment = new Comment();
        $comment->post_id = $postId;
        $comment->user_id = $this->data['user']->id;
        $comment->text = $text;
        $parentId = Input::get('parent_id');
        $comment->parent_id = isset($parentId) && is_numeric($parentId) ? $parentId : null;
        $comment->save();
        return redirect()->back();
    }

    public function updateComment($postId)
    {
        $currentUser = \Auth::user();
        $commentId = Input::get('comment_id');
        $comment = Comment::whereUserIdAndPostIdAndId($currentUser->id, $postId, $commentId)->first();
        if (!$comment)
            return view('errors.503');
        $text = Input::get('text');
        $comment->text = $text;
        $comment->save();
        return redirect()->back();
    }

    public function deleteComment($postId, $commentId)
    {
        $currentUser = \Auth::user();
        $comment = Comment::whereUserIdAndPostIdAndId($currentUser->id, $postId, $commentId)->first();
        if (!$comment)
            return \Response::json(['code' => 404, 'message' => 'Comment not found'], 404);
        if ($comment->children->count() > 0) {
            foreach ($comment->children as $child) {
                $child->parent_id = $comment->parent_id;
                $child->save();
            }
        }
        $comment->delete();
        return \Response::json(['status' => 'ok'], 200);
    }

    public function upVoteComment($postId, $commentId)
    {
        $currentUser = \Auth::user();
        $oldVote = Vote::whereCommentIdAndUserId($commentId, $currentUser->id)->first();
        if ($oldVote) {
            if ($oldVote->is_positive) {
                return \Response::json(['message' => 'Already voted'], 500);
            } else {
                $oldVote->delete();
                return \Response::json($oldVote, 200);
            }
        } else {
            $vote = new Vote();
            $vote->user_id = $currentUser->id;
            $vote->is_positive = true;
            $vote->comment_id = $commentId;
            $vote->save();
            return \Response::json($vote, 200);
        }
    }

    public function downVoteComment($postId, $commentId)
    {
        $currentUser = \Auth::user();
        $oldVote = Vote::whereCommentIdAndUserId($commentId, $currentUser->id)->first();
        if ($oldVote) {
            if (!$oldVote->is_positive) {
                return \Response::json(['message' => 'Already voted'], 500);
            } else {
                $oldVote->delete();
                return \Response::json($oldVote, 200);
            }
        } else {
            $vote = new Vote();
            $vote->user_id = $currentUser->id;
            $vote->is_positive = false;
            $vote->comment_id = $commentId;
            $vote->save();
            return \Response::json($vote, 200);
        }
    }

    private function allComments($postId)
    {
        $comments = Comment::wherePostId($postId)->get();
        $comments_by_id = new Collection();

        foreach ($comments as $comment) {
            $comments_by_id->put($comment->id, $comment);
        }

        foreach ($comments as $key => $comment) {
            $comments_by_id->get($comment->id)->children = new Collection;

            if ($comment->parent_id != 0) {
                $comments_by_id->get($comment->parent_id)->children->push($comment);
                unset($comments[$key]);
            }
        }

        return $comments;
    }


}