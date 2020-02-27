
<!DOCTYPE html>
<html lang="es">
<head>
<title>Londner's</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('esencias/css/normalize.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('esencias/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('esencias/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('esencias/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('esencias/css/estilos.css') }}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{ asset('esencias/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('esencias/js/bootstrap.bundle.min.js') }}"></script>
    <link href="{{ asset('esencias/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{ asset('esencias/js/bootstrap-select.min.js') }}"></script>   
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800&display=swap" rel="stylesheet">
</head>
<body>
<div id="home" class="">
    <div class="container">
    <nav class="navbar navbar-expand-md">
   <a class="navbar-brand" href="index.php"><img src="{{ asset('esencias/images/logo.png') }}" title="Londner" class="logo"></a>
   <a class="navbar-brand" href="index.php"><img src="{{ asset('esencias/images/logo_fultena.jpg') }}" class="logo-fultena"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon fa fa-bars"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link " href="/">tienda</a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="/contacto">contacto</a>
      </li>
      <li class="nav-item">
      <a class="nav-link " href="/informe">mis esencias (<span id="cantidadDeProductos">{{ Session::get('array_carrito')? count(Session::get('array_carrito')):'0' }}</span>)</a>
     
      </li>
    </ul>
  </div>
</nav>   
@yield('contenido')
    <footer class="footer">
<div class="container">
    <div class="row py-3">
        <div class="col-md-12">
            <p id="parrafoexpl">Los productos aqu&iacute; descriptos no intentan prescribir, diagnosticar, tratar ni curar patolog&iacute;as f&iacute;sicas ni mentales.
               Las cualidades mencionadas no han sido comprobadas por medios de la ciencia convencional.
               Ante cualquier duda relacionada con su salud consulte con un profesional calificado. 
               * Títulos no oficiales emitidos y avalados por FULTENA (Fundación Latinoamericana de Terapias Naturales)</p>
        </div>
    </div>
</div>
<div class="container-fluid" id="footericonosdiv">
    <div class="container">
        <div class="row py-3">
            <div class="col-md-4" id="colfooter">
                &#169; 2019 by londer's
            </div>
            <div class="col-md-4" id="colfooter">
                <i class="fa fa-map-marker" aria-hidden="true" id="ubicacion"></i> Riobamba 118 piso 5 (1025) C.a.b.a. – Argentina <br>
                <i class="fa fa-globe" aria-hidden="true" id="website"></i> Descubrí nuestra tienda: <a href="#">www.lodners.com</a>
            </div>
            <div class="col-md-4" id="colfooter">
                <a href="#" target="_blank"><i class="fa fa-youtube-play" id="youtube"></i></a>
                <a href="#" target="_blank"><i class="fa fa-whatsapp" id="whatsapp"></i></a>
                <a href="#" target="_blank"><i class="fa fa-facebook" id="facebook"></i></a>
                <a href="#" target="_blank"><i class="fa fa-instagram" id="instagram"></i></a>
            </div>
        </div>
    </div>
</div>
</footer>
</body>
</html>