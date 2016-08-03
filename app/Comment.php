<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    public function getScoreAttribute()
    {
        $id = $this->id;
        $votes = Vote::selectRaw('count(comment_id) as rate, is_positive')
            ->whereCommentId($id)
            ->groupBy('is_positive')
            ->lists('rate', 'is_positive');
        $plus = isset($votes[1]) ? $votes[1] : 0;
        $minus = isset($votes[0]) ? $votes[0] : 0;
        $result = +$plus - +$minus;
        return $result;
    }

    /**
     * @return null if no votes from me
     * @return t or f if upvoted or downvoted
     */
    public function getVotedAttribute() {
        $me = \Auth::user();
        $myVote = Vote::whereUserIdAndCommentId($me->id, $this->id)->first();
        if ($myVote) {
            return $myVote->is_positive ? true : false;
        }
        return null;
    }

    public function author()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    public function children()
    {
        return $this->hasMany('\App\Comment', 'parent_id', 'id');
    }
}
