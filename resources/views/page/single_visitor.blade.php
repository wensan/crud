<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">{{ $page->title }}
                <a href="<?php echo url('/'); ?>" class="btn btn-default pull-right">Go Back</a>
            </div>
            <div class="panel-body">
                <p>{{ $page->page_content }}</p>
            </div>
        </div>
        <div class="comments-section">
            @if(count($page->comments) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">Comments</div>
                    <div class="panel-body">
                        @foreach($page->comments as $comment)
                            <label>{{ $comment->user->name }}</label> @ <span>{{ $comment->created_at->diffForHumans() }}</span>
                            <p>{{ $comment->body }}</p>
                                <div class="comment-replies_{{ $comment->id }}">
                                    @if(count($comment->replies) > 0)
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Replies</div>
                                            <div class="panel-body">
                                                @foreach($comment->replies as $reply)
                                                    @if(!$reply->is_hidden)
                                                        <label>{{ $reply->user->name }}</label> @ <span>{{ $reply->created_at->diffForHumans() }}</span>
                                                        <p>{{ $reply->body }}</p>
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
        </div>
    </div>
</div>
