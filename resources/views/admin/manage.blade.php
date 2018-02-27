<div class="row">
      <div class="col-xs-12">
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Deleted</th>
                      <th>Created</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($users as $user)
                      <tr _id="{{ $user->id }}">
                          <td>{{ $user->id }}</td>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ $user->role }}</td>
                          <td class="_deleted">{{ $user->deleted ? "true" : "false" }}</td>
                          <td>{{ $user->created_at }}</td>
                          <td>
                            @if($user->deleted == 0)
                                <button class="btn btn-default btn-xs" _id="{{ $user->id }}" onclick="manageUser(this,'deactivate')">deactivate</button>
                            @else
                                <button class="btn btn-default btn-xs" _id="{{ $user->id }}" onclick="manageUser(this,'activate')">activate</button>
                            @endif
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
</div>
<script>
    function manageUser(me, action) {
        var _id = $(me).attr("_id");
        ajaxCallJwt({
            url: "/api/admin/" + _id,
            type: "PUT",
            data: {},
            dataType: "json",
            token: _token
        }, function(res) {
            if (res.data.status == 200) {
                $("table").find("tbody tr").each(function() {
                    if ($(this).attr("_id") == _id) {
                        console.log(action)
                        if (action == "activate") {
                            $(this).find("td._deleted").html("false");
                            $(this).find("button").attr("onclick", "manageUser(this,'deactivate')").html("deactivate");
                        } else {
                            $(this).find("td._deleted").html("true");
                            $(this).find("button").attr("onclick", "manageUser(this,'activate')").html("activate");
                        }
                    }
                });
            } else {
                alert(res.data.message);
            }
        });
    }
</script>
