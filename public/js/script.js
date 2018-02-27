//GLOBAL
var page_id = null,
    comment_id = null,
    reply_id = null,
    _token = null;

$(document).ready(function() {
    _token = readCookie("token");
    if (_token != null) {
      //check validity
        ajaxCallJwt({
            type: "GET",
            data: {},
            url: "/api/auth/isvalid",
            dataType: 'json',
            token: _token
        }, function(res) {
            if (res.data.status == 200) {
                loadLoggedUser(res.data.role, _token);
            } else {
                ajaxCall({
                    url: "/login",
                    data: {},
                    type: "GET",
                    dataType: "HTML",
                    contentType: ""
                }, function(html) {
                    $("#navbar-menu").html(html);
                    loginBtn();
                }, function(err) {
                    alert(err);
                });
            }
        })
    } else {
        ajaxCall({
            url: "/login",
            data: {},
            type: "GET",
            dataType: "HTML",
            contentType: ""
        }, function(html) {
            $("#navbar-menu").html(html);
            loginBtn();
        }, function(err) {
            alert(err);
        });
    }

    $(".btn-register-user").click(function(e) {
        e.preventDefault();
        var name = $("#name").val();
        var email = $("#email").val();
        var password = $("#password").val();
        ajaxCall({
            type: "POST",
            data: {name: name, email: email, password: password},
            url: "/api/register",
            dataType: 'json'
        }, function(res) {
            if (res.data.status == 200) {
                alert("Successfully registered, you can now login.");
                $("#registerModal").modal("hide");
            } else {
                alert(res.data.error);
            }
        })

        return false;
    });

});

//Pages
function loadPage(me) {
    var id = $(me).attr("_id");
    ajaxCallJwt({
        url: "/pages/page/" + id,
        type: "GET",
        dataType: "HTML",
        token: _token
    }, function(html) {
        page_id = id;
        $(".page-content").html(html);
        listComments(page_id);
    });
}

function listPages() {
    ajaxCallJwt({
        url: "/pages/list",
        type: "GET",
        dataType: "HTML",
        token: _token
    }, function(html) {
        $(".page-content").html(html);
    });
}

//comments
function listComments(pageId) {
    ajaxCallJwt({
        url: "/comments/page",
        type: "GET",
        data: {id: pageId},
        dataType: "HTML",
        token: _token
    }, function(html) {
        $(".comments-section").html(html);
    });
}

function showCommentBox(me) {
    var _id = $(me).attr("_id");
    $("#addComment").modal("show");
    $("#addComment").attr("_id", _id);
    $("#addComment").find("textarea").val("");
}

function saveComment(me) {
    var _id = $(me).closest("#addComment").attr("_id");
    var body = $(me).closest("#addComment").find("textarea").val();
    if (body != "") {
        ajaxCallJwt({
            url: "/comments/comment",
            type: "GET",
            data: {id: _id, comment: body},
            dataType: "HTML",
            token: _token
        }, function(html) {
            $(".comments-section").html(html);
            $("#addComment").modal("hide");
        });
    } else {
        alert("Please provide a comment");
    }
}

function hideComment(me) {
    var _id = $(me).attr("_id");
    ajaxCallJwt({
        url: "/api/comments/" + _id,
        type: "PUT",
        data: {},
        dataType: "json",
        token: _token
    }, function(res) {
        if (res.data.status == 200)
            listComments(page_id);
        else
            alert(res.data.message);
    });
}

function deleteComment(me) {
    var _id = $(me).attr("_id");
    ajaxCallJwt({
        url: "/api/comments/" + _id,
        type: "DELETE",
        data: {},
        dataType: "json",
        token: _token
    }, function(res) {
        if (res.data.status == 200)
            listComments(page_id);
        else
            alert(res.data.message);
    });
}

function showCommentReplyBox(me) {
    var _id = $(me).attr("_id");
    $("#replyComment").modal("show");
    $("#replyComment").attr("_id", _id);
    $("#replyComment").find("textarea").val("");
}

function saveCommentReply(me) {
    var _id = $(me).closest("#replyComment").attr("_id");
    var body = $(me).closest("#replyComment").find("textarea").val();
    if (body != "") {
        ajaxCallJwt({
            url: "/comments/reply",
            type: "GET",
            data: {comment_id: _id, reply: body},
            dataType: "HTML",
            token: _token
        }, function(html) {
            $(".comments-section").find(".comment-replies_" + _id).html(html);
            $("#replyComment").modal("hide");
        });
    } else {
        alert("Please provide a reply");
    }
}

function hideReply(me) {
    var _id = $(me).attr("_id");
    var _c_id = $(me).attr("__id");
    ajaxCallJwt({
        url: "/api/comments/reply/" + _id,
        type: "PUT",
        data: {},
        dataType: "json",
        token: _token
    }, function(res) {
        if (res.data.status == 200)
            listReply(_c_id);
        else
            alert(res.data.message);
    });
}

function deleteReply(me) {
    var _id = $(me).attr("_id");
    var _c_id = $(me).attr("__id");
    ajaxCallJwt({
        url: "/api/comments/reply/" + _id,
        type: "DELETE",
        data: {},
        dataType: "json",
        token: _token
    }, function(res) {
        if (res.data.status == 200)
            listReply(_c_id);
        else
            alert(res.data.message);
    });
}

function listReply(c_id) {
    ajaxCallJwt({
        url: "/comments/listreply",
        type: "GET",
        data: {comment_id: c_id},
        dataType: "HTML",
        token: _token
    }, function(html) {
        $(".comments-section").find(".comment-replies_" + c_id).html(html);
    });
}
//END Comments

function loadLoggedUser(role, token) {
    var _menu = "<form class='navbar-form navbar-right'>";
    if (role == "admin") {
        _menu += "<button type='button' class='btn btn-default' onclick='loadAdmin(event)' style='margin-right: 5px'>Manage</button>";
        _menu += "<button id='logout' class='btn btn-default'>Logout</button>";
    } else {
        _menu += "<button id='logout' class='btn btn-default'>Logout</button>";
    }
    _menu += "</div>";
    $("#navbar-menu").html(_menu);

    listPages();

    $("#logout").click(function(e) {
        e.preventDefault();
          ajaxCallJwt({
              type: "GET",
              data: {},
              url: "/api/auth/token/invalidate",
              dataType: 'json',
              token: token
          }, function(res) {
              window.location.reload();
              eraseCookie("token");
          })
    });
}

function loginBtn() {
    $(".btn-sign-in").click(function(e) {
        e.preventDefault();
        var email = $("#login_email").val();
        var password = $("#login_password").val();
        ajaxCall({
            type: "GET",
            data: {},
            url: "/api/auth/token?email=" + email + "&password=" + password,
            dataType: 'json'
        }, function(res) {
            if (res.data.status == 200) {
                createCookie("token", res.data.token, 30);
                window.location.reload();
            } else {
              alert(res.data.message);
            }
        }, function(err) {
           alert(err.data.message);
        });
    });
}

//Admin
function loadAdmin(e) {
    e.preventDefault();
    ajaxCallJwt({
        url: "/admin",
        type: "GET",
        data: {},
        dataType: "HTML",
        token: _token
    }, function(html) {
        $(".page-content").html(html);
    });
}

function ajaxCallJwt(ops, callback, errorCallback) {
    $.ajax({
        method: ops.type,
        type: ops.type,
        url: base_url + ops.url,
        data: ops.data,
        contentType: ops.contentType,
        dataType: ops.dataType,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", 'Bearer '+ ops.token);
        }
    }).done(function (res) {
        if (callback)
          callback(res);
    }).fail(function (err)  {
        if (errorCallback)
          errorCallback(err);
    });
}

function ajaxCall(ops, callback, errorCallback) {
    $.ajax({
        type: ops.type,
        method: ops.type,
        url: base_url + ops.url,
        data: ops.data,
        contentType: ops.contentType,
        dataType: ops.dataType
    }).done(function (res) {
        if (callback)
          callback(res);
    }).fail(function (err) {
        if (errorCallback)
          errorCallback(err);
    });
}

function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = encodeURIComponent(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}

function splitArrayContent(arr, size) {
  	var results = [];
  	while (arr.length) {
  		results.push(arr.splice(0, size));
  	}

  	return results;
}
