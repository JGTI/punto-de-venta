


<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin Panel')</title>
  <link rel="apple-touch-icon" sizes="180x180" href="{{url('assets/img/icono.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{url('assets/img/icono.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{url('assets/img/icono.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{url('assets/css/styles.min.css')}}?v={{time()}}" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


  @yield('css')
  

</head>
<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" -sidebar-position="fixed" data-header-position="fixed">
    @include('masterpage.sidebar')
    <div class="body-wrapper">
    @include('masterpage.header')
      <br><br><br>
      <div>
          @yield('content')
          @include('masterpage.footer')
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="{{url('assets/js/sidebarmenu.js') }}"></script>
  <script src="{{url('assets/js/app.min.js') }}"></script>
  <script src="{{url('assets/libs/simplebar/dist/simplebar.js') }}"></script>
  <script src="{{url('assets/js/dashboard.js') }}?v=23"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>




  <script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('input[type="date"]').attr('type', 'text').datepicker({
            dateFormat: 'yy-mm-dd' // Formato de la fecha para guardar en la base de datos
        });
    });
</script>

  
   @yield('js')
</body>
</html>