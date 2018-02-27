@if(count($comments) > 0)
    <div class="panel panel-default">
        <div class="panel-heading">Comments</div>
        <div class="panel-body">
            @foreach($comments as $comment)
                <label>{{ $comment->user->name }}</label> @ <span>{{ $comment->created_at->diffForHumans() }}</span>
                <p>{{ $comment->body }}</p>
                <button class="btn btn-default btn-sm" _id={{ $comment->id }} onclick="showCommentReplyBox(this)">Reply</button>
                    @if($user->role == 'admin' || $user->id == $comment->user->id)
                        <button class="btn btn-default btn-sm" _id={{ $comment->id }} onclick="hideComment(this)">Hide</button>
                        <button class="btn btn-default btn-sm" _id={{ $comment->id }} onclick="deleteComment(this)">Delete</button>
                    @endif
                    <div class="comment-replies_{{ $comment->id }}">
                        @if(count($comment->replies) > 0)
                            <div class="panel panel-default">
                                <div class="panel-heading">Replies</div>
                                <div class="panel-body">
                                    @foreach($comment->replies as $reply)
                                        @if(!$reply->is_hidden)
                                            <label>{{ $reply->user->name }}</label> @ <span>{{ $reply->created_at->diffForHumans() }}</span>
                                            <p>{{ $reply->body }}</p>
                                                @if($user->role == 'admin' || $user->id == $reply->user->id)
                                                    <button class="btn btn-default btn-sm" __id="{{ $comment->id }}"  _id={{ $reply->id }} onclick="hideReply(this)">Hide</button>
                                                    <button class="btn btn-default btn-sm" __id="{{ $comment->id }}" _id={{ $reply->id }} onclick="deleteReply(this)">Delete</button>
                                                @endif
                                            <br/>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                <br/>
            @endforeach
        </div>
    </div>
@endif
