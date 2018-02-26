<!doctype html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Simple CRUD from Laravel 5</title>
    <script src="{{asset('js/jquery-2.1.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/script.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/bootstrap-theme.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/style.css')}}" />
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        var base_url = '<?php echo url('/'); ?>';
    </script>
</head>
<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo url('/'); ?>">Simple CRUD</a>
      </div>
      <div id="navbar-menu" class="navbar-collapse collapse"></div>
    </div>
  </nav>
  <div class="container">
      <div class="page-content"></div>
  </div>
  <div class="modal fade" id="registerModal" role="dialog" aria-labelledby="registerModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="registerModalLabel">Register:</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                      <label for="name" class="control-label">Name:</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Name:">
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email:">
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-register-user">Save</button>
            </div>
        </div>
      </div>
  </div>
</body>
</html>
