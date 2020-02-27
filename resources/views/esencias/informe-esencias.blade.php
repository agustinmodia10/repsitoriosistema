@extends('esencias.plantilla')
@section('contenido')
</div>
</div>
<div class="container-fluid" id="containerresultados">
    <div class="container">
    <div class="row py-5">
            <div class="col-md-12">
                <h2 id="misEsencias">INFORME PERSONALIZADO</h2>
            </div>
        </div>
    </div>
    <div class="container py-2">
        <div class="row py-2">
            <div class="row py-3" id="rowenfoque">
                <div class="col-md-7">
                    <h2 id="Situacion">•Esencia: PINE</h2><br>
                    <h5>DOLOR DE CABEZA</h5> <h6>POR PENSAR MUCHO</h6><br>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur, error magnam eligendi optio cupiditate debitis,
                        nihil assumenda reprehenderit doloribus necessitatibus id repellendus corrupti iste ipsum similique ea! Dicta, repudiandae aliquid!</p><br>
                    <a href="#"> VER M&Aacute;S</a>
                </div>
                <div class="col-md-5">
                    <a type="button" class="btn" href="#" id="btninforme">X DESCARTAR</a>
                </div>
            </div>
            <div class="row py-5">
                <div class="col-md-9 offset-md-3" id="colsubscripcion">
                        <input type="email" class="form-control" placeholder="email" id="subscripcion" name="subscripcion">
                        <button  class="btn" class="form-control" name="botonsubscripcion" id="botonsubscripcion">ENVIAR POR EMAIL</button>
                </div>
            </div>
            <div class="row py-5">
                <div class="col-md-9 offset-md-3" id="colsubscripcion">
                        <label>o tambi&eacute;n pod&eacute;s descargarlo en tu dispositivo</label>
                        <button  class="btn" class="form-control" name="botonsubscripcion" id="botonsubscripcion">DESCARGAR</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection