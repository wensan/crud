<div class="row">
    @foreach($pages as $page)
        <div class="col-xs-3">
            <label>{{ $page->title }}</label>
            <p>{{ $page->page_content }}</p>
            <button _id={{ $page->id }} class="btn btn-default" onclick="loadPage(this)">Read More</button>
            @if($user->role == "admin")
                <button _id={{ $page->id }} class="btn btn-default delete-page">Delete</button>
            @endif
        </div>
    @endforeach
</div>
