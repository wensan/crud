@if(count($comments) > 0)
    <div class="panel panel-default">
        <div class="panel-heading">Comments</div>
        <div class="panel-body">
            @foreach($comments as $comment)
                <label>{{ $comment->user->name }}</label> @ <span>{{ $comment->created_at->diffForHumans() }}</span>
                <p>{{ $comment->body }}</p>
                <button class="btn btn-default btn-sm reply-comment" _id={{ $comment->id }}>Reply</button>
                    @if($user->role == 'admin' || $user->id == $comment->user->id)
                        <button class="btn btn-default btn-sm reply-comment" _id={{ $comment->id }}>Hide</button>
                        <button class="btn btn-default btn-sm reply-comment" _id={{ $comment->id }}>Delete</button>
                    @endif
                <br/>
            @endforeach
        </div>
    </div>
@endif
