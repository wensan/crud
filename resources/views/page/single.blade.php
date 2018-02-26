<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">{{ $page->title }}
                <a href="<?php echo url('/'); ?>" class="btn btn-default pull-right">Go Back</a>
            </div>
            <div class="panel-body">
                <p>{{ $page->page_content }}</p>
                <button class="btn btn-default btn-sm comment-page" _id={{ $page->id }}>Comment</button>
            </div>
        </div>
        <div class="comments-section"></div>
    </div>
</div>
<div class="modal fade" id="addComment" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Add Comment:</h4>
          </div>
          <div class="modal-body">
              <form>
                  <div class="form-group">
                    <textarea row="5" class="form-control"></textarea>
                  </div>
              </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary btn-add-comment">Save</button>
          </div>
      </div>
    </div>
</div>
<div class="modal fade" id="replyComment" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Reply Comment:</h4>
          </div>
          <div class="modal-body">
              <form>
                  <div class="form-group">
                    <textarea row="5" class="form-control"></textarea>
                  </div>
              </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary btn-add-reply-comment">Save</button>
          </div>
      </div>
    </div>
</div>
