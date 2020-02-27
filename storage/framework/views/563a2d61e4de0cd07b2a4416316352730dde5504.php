<?php $__env->startSection('contenido'); ?>
<section>
    	<div class="row py-5">
    		<div class="col-10">
                <h1>REPERTORIO<br>ON LINE
                </h1>
    		</div>
    	</div>
        <div class="row">
            <div class="col-8">
                <p>"Primer sistema integrado que te permite reconocer y armonizar tus estados
    emocionales con las Flores de Bach y del mundo, más el aporte que en los últimos
    años han brindado cerca de diez sistemas de Esencias Vibracionales".</p>
            </div>
        </div>
    </section>
</div>
</div>
<div class="container" class="searchContainer">
    <div class="row py-5">
        
        <div class="col-md-6 text-center">
            <a class="active" name="hipervinculo" id="hipervinculo" href="#">POR ESENCIA</a>
        </div>
        <div class="col-md-6 text-center">
            <a class="active" name="hipervinculo" id="hipervinculoDerecho" href="#">POR SISTEMA DE ESENCIAS</a>
        </div>
    </div>
    <div class="row py5">
        <div class="col-md-12">
            <h2 class="tituloNegrita">¿Qu&eacute; esencia busc&aacute;s?</h2>
            


        </div>
    </div>
    <div class="row py6">
        <div class="col-md-12" id="colbuscador">
            <div  id="buscadorCol">
                <i class="fa fa-search"></i>
                <select class=" selectpicker" data-live-search="true">
                    <option value="" select disable>Buscar</option>
                    <?php $__currentLoopData = ($array_productos); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($producto->nombre); ?>"><?php echo e($producto->nombre); ?></option>  
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button name="botonSearch" id="botonSearch"><i class="fa fa-arrow-right"></i></button>
               
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" id="containerresultados">
    <div class="container">
        <div class="row py-2">
            <div class="col-md-12">
                <h2 id="resultados">Resultados</h2>
            </div>
        </div>
        <div class="row py-3">      
                <?php $__currentLoopData = ($array_productos); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3">
                        <div class="card box-shadow">
                            <div class="card-header">
                                <img class="card-img-top imagenProducto" alt="" src="/images/<?php echo e($producto->imagen); ?>" title="<?php echo e($producto->nombre); ?>">
                            </div>
                            <div class="card-body">
                                <h3><?php echo e($producto->nombre); ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="col-md-12 center">
                                    <label id="labelTipo"> <strong>TIPO:<span style="color:rgb(128, 128, 128)">
                                    <?php echo e($producto->tipoNombre); ?>

                                    </span></strong></label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button class="btn" id="buttoncardfoooter" onclick="fAgregarAlCarrito(<?php echo e($producto->idproducto); ?>);">AGREGAR</button>
                                    </div>  
                                    <div class="col-md-6">
                                        <a href="/esencia/<?php echo e($producto->idproducto); ?>" type="button" class="btn"   id="buttoncardfoooter">VER</a>  
                                    </div>                       
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               
        </div>
           


        <div class="row py-5">
            <div class="col-md-12 offset-md-3" id="colsubscripcion">
                    <input type="email" class="form-control" placeholder="email" id="subscripcion" name="subscripcion">
                    <button  class="btn" class="form-control" name="botonsubscripcion" id="botonsubscripcion">SUSCRIBETE</button>
            </div>
        </div>
    </div>
</div>

<script>
    function fAgregarAlCarrito(idProducto){
        $.ajax({
            type: "GET",
            url: "<?php echo e(asset('producto/agregarAlCarrito')); ?>",
            data: { id:idProducto },
            async: true,
            dataType: "json",
            success: function (respuesta) {
                if (respuesta.err = "0") {
                    $("#cantidadDeProductos").html(respuesta.cantidad);
                } else {
                    alert("Error");
                }
            }
        });   
    }
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('esencias.plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>