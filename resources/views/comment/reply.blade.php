@if(count($replies) > 0)
    <div class="panel panel-default">
        <div class="panel-heading">Replies</div>
        <div class="panel-body">
            @foreach($replies as $reply)
                <label>{{ $reply->user->name }}</label> @ <span>{{ $reply->created_at->diffForHumans() }}</span>
                <p>{{ $reply->body }}</p>
                    @if($user->role == 'admin' || $user->id == $reply->user->id)
                    <button class="btn btn-default btn-sm" __id="{{ $reply->comment_id }}"  _id={{ $reply->id }} onclick="hideReply(this)">Hide</button>
                    <button class="btn btn-default btn-sm" __id="{{ $reply->comment_id }}" _id={{ $reply->id }} onclick="deleteReply(this)">Delete</button>
                    @endif
                <br/>
            @endforeach
        </div>
    </div>
@endif
