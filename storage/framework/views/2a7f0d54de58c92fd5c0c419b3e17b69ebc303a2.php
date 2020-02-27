<?php $__env->startSection("contenido"); ?>


   

<!DOCTYPE html>
<html lang="es">
<head>
<title>Londner's</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="public/esencias/css/normalize.css" rel="stylesheet" type="text/css">
    <link href="public/esencias/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="public/esencias/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="public/esencias/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="public/esencias/css/estilos.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="public/esencias/js/jquery.min.js"></script>
    <script type="text/javascript" src="public/esencias/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800&display=swap" rel="stylesheet">
</head>
<body>
<div id="home" class="">
    <div class="container">

 
  </div>
</div>
<div class="container-fluid" id="containerresultados">
    <div class="container py-3">
        <div class="row py-3">
            <div class="col-md-12">
                <i class="fa fa-arrow-left" id="arrowleft" aria-hidden="true"></i> <a href="/index.php" id="linkvolver">volver a la b&uacute;squeda</a>
            </div>
        </div>
        <div class="row py-3" id="descripcionCuadro">
                            <div class="col-md-5">
                    <img alt="" id="imagenDescripcion" src="https://112019tm1.depcsuite.com/esencias/images/escencia.jpeg" data-holder-rendered="true"><hr><br>
                    <strong>TIPO</strong>: <span style="color:rgb(216, 208, 208)">ESCENCIA</span><br>
                    <strong>TAMAÑO</strong>: <span style="color:rgb(216, 208, 208)"><br> FRASCO 10 ML <br> </span><br>
                    <strong>SISTEMA FLORAL</strong>: <span style="color:rgb(216, 208, 208)">FLORES DE BACH</span><br>
                    <strong>S&Iacute;NTOMAS</strong>: <span style="color:rgb(216, 208, 208)">REPROCHE A UNO MISMO<br>CULPABILIDAD</span>
                </div>
                <div class="col-md-7" id="coldescripcion">
                    <h2>ORQUÍDEA ABUNDANCIA</h2><br>
                    <p>ORQUÍDEA ABUNDANCIA</p><br><br><br>
                    <a href="#">LINK ARTICULO PERIODISTICO</a><br><br>
                    BIBLIOGRAF&Iacute;A RELACIONADA<br>
                    <a href="#">LIBRO 1</a><br>
                    <a href="#">LIBRO 2</a><br><br><br>
                    <a type="button" id="buttonDescripcion" href="#" class="btn">COMPRAR</a>
                    <a type="button" id="buttonDescripcion" href="/informe" class="btn">SUMAR A TU INFORME PERSONALIZADO</a>
                </div>
                    </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make("esencias.plantilla", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>