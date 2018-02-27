@if(!empty($user) && $user->role == "admin")
    <div class="row">
        <div class="col-xs-12">
            <button type="button" class="btn btn-default pull-right" onclick="showPageBox()">Add Page</button>
        </div>
    </div>
    <hr/>
@endif
<div class="row">
    @foreach($pages as $page)
        <div class="col-xs-3">
            <label>{{ $page->title }}</label>
            <p>{{ $page->page_content }}</p>
            <button _id={{ $page->id }} class="btn btn-default" onclick="loadPage(this)">Read More</button>
            @if(!empty($user) && $user->role == "admin")
                <button _id={{ $page->id }} class="btn btn-default delete-page">Delete</button>
            @endif
        </div>
    @endforeach
</div>
@if(!empty($user) && $user->role == "admin")
    <div class="modal fade" id="addPage" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title">Add Page:</h4>
              </div>
              <div class="modal-body">
                  <form>
                      <div class="form-group">
                          <label>Title:</label>
                          <input type="text" class="form-control" />
                      </div>
                      <div class="form-group">
                          <label>Body:</label>
                          <textarea rows="5" class="form-control"></textarea>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary" onclick="savePage()">Save</button>
              </div>
          </div>
        </div>
    </div>
    <script>
        function showPageBox() {
            $("#addPage").modal("show");
        }

        function savePage() {
            var title = $("#addPage").find("input").val();
            var body = $("#addPage").find("textarea").val();
            if (title == "" || body == "") {
                alert("Empty");
            } else {
                ajaxCall({
                    type: "POST",
                    data: {title: title, page_content: body},
                    url: "/api/pages",
                    dataType: 'json'
                }, function(res) {
                    if (res.data.status == 200) {
                        window.location.reload();
                    } else {
                        alert(res.data.error);
                    }
                })
            }
        }
    </script>
@endif
