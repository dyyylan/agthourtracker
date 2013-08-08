<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{{ (isset($title)) ? $title . ' | ' : '' }}AGT Hour Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <link href="/assets/css/datepicker.css" rel="stylesheet">

    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="/"><img src="/assets/img/agt_globe.png" style="height: 43px" /> AGT Hour Tracker</a>
          <div class="nav-collapse collapse inverse">
            @include('layouts._navigation')
            
            @if (Auth::check())
              @include('layouts._profileControls')
            @endif
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      @if (Session::has('error'))
        <div class="alert alert-error">
          <a class="close" data-dismiss="alert" href="#">&times;</a>
          <h4>Error</h4>
          {{ Session::get('error') }}
          @if (isset($errors))
            <ul>
              @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
              @endforeach
            </ul>
          @endif
        </div>
      @endif

      @if (Session::has('notice'))
        <div class="alert alert-notice">
          <a class="close" data-dismiss="alert" href="#">&times;</a>
          <h4>Notice</h4>
          {{ Session::get('notice') }}
        </div>
      @endif

      @if (Session::has('success'))
        <div class="alert alert-success">
          <a class="close" data-dismiss="alert" href="#">&times;</a>
          <h4>Success</h4>
          {{ Session::get('success') }}
        </div>
      @endif

      @yield('content')

      <hr>

      <footer>
        <p>&copy; AGT 2013</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/assets/js/lib/jquery.js"></script>
    <script src="/assets/js/lib/bootstrap/bootstrap-transition.js"></script>
    <script src="/assets/js/lib/bootstrap/bootstrap-alert.js"></script>
    <script src="/assets/js/lib/bootstrap/bootstrap-modal.js"></script>
    <script src="/assets/js/lib/bootstrap/bootstrap-dropdown.js"></script>
    <script src="/assets/js/lib/bootstrap/bootstrap-scrollspy.js"></script>
    <script src="/assets/js/lib/bootstrap/bootstrap-tab.js"></script>
    <script src="/assets/js/lib/bootstrap/bootstrap-tooltip.js"></script>
    <script src="/assets/js/lib/bootstrap/bootstrap-popover.js"></script>
    <script src="/assets/js/lib/bootstrap/bootstrap-button.js"></script>
    <script src="/assets/js/lib/bootstrap/bootstrap-collapse.js"></script>
    <script src="/assets/js/lib/bootstrap/bootstrap-carousel.js"></script>
    <script src="/assets/js/lib/bootstrap/bootstrap-typeahead.js"></script>
    <script src="/assets/js/lib/bootstrap-datepicker/bootstrap-datepicker.js"></script>

    <script src="/assets/js/scripts.js"></script>
    <script src="/assets/js/calendar.js"></script>

  </body>
</html>
