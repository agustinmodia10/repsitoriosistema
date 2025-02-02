<?php $__env->startSection('titulo', "$titulo"); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    globalId = '<?php echo isset($pagina->idpagina) && $pagina->idpagina > 0 ? $pagina->idpagina : 0; ?>';
    <?php $globalId = isset($pagina->idpagina) ? $pagina->idpagina : "0"; ?>

</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/sistema/menu">Men&uacute;</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/pagina/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/pagina/";
}
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div class="panel-body">
        <div id = "msg"></div>
        <?php
        if (isset($msg)) {
            echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
        }
        ?>
        <form id="form1" method="POST">
            <div class="row">
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="<?php echo e($globalId); ?>" required>
                <div class="form-group col-lg-6">
                    <label>Titulo:</label>
                    <input type="text" id="txtTitulo" name="txtTitulo" class="form-control" value="<?php echo e(isset($pagina->titulo) ? $pagina->titulo : ''); ?>" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Fecha de creacion:</label>
                    <input type="date" id="dateFechaCreacion" name="dateFechaCreacion" class="form-control" value="<?php echo e(date_format(date_create($pagina->fecha_creacion),'Y-m-d')); ?>" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Subtitulo:</label>
                    <input type="text" id="txtSubtitulo" name="txtSubtitulo" class="form-control" value="<?php echo e(isset($pagina->subtitulo) ? $pagina->subtitulo : ''); ?>">
                </div>
                <div class="form-group col-lg-6">
                    <label>Fecha de publicacion:</label>
                    <input type="date" id="dateFechaPublicacion" name="dateFechaPublicacion" class="form-control" value="<?php echo e(date_format(date_create($pagina->fecha_publicacion),'Y-m-d')); ?>" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Contenido:</label>
                    <input type="text" id="txtContenido" name="txtContenido" class="form-control" value="<?php echo e(isset($pagina->contenido) ? $pagina->contenido : ''); ?>">
                </div>
                 <div class="form-group col-lg-6">
                    <label>Estado:</label>
                    <select name="lstEstado" id="lstEstado" class="form-control">
                    <option selected>Seleccionar estado</option>
                    <?php for($i = 0; $i < count($array_estados); $i++): ?>
                            <?php if(isset($estado) and $array_estados[$i]->idestado == $estado->idestado): ?>
                                <option value="<?php echo e($array_estados[$i]->idestado); ?>"><?php echo e($array_estados[$i]->nombre); ?></option>
                            <?php else: ?>
                                <option value="<?php echo e($array_estados[$i]->idestado); ?>"><?php echo e($array_estados[$i]->nombre); ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
        </form>
</div>
<div class="modal fade" id="mdlEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Eliminar registro?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">¿Deseas eliminar el registro actual?</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
            <button type="button" class="btn btn-primary" onclick="eliminar();">Sí</button>
          </div>
        </div>
      </div>
    </div>
<script>

    $("#form1").validate();

    function guardar() {
        if ($("#form1").valid()) {
            modificado = false;
            form1.submit(); 
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }

    function eliminar() {
        $.ajax({
            type: "GET",
            url: "<?php echo e(asset('pagina/eliminar')); ?>",
            data: { id:globalId },
            async: true,
            dataType: "json",
            success: function (data) {
                if (data.err = "0") {
                    msgShow("Registro eliminado exitosamente.", "success");
                    $("#btnEnviar").hide();
                    $("#btnEliminar").hide();
                    $('#mdlEliminar').modal('toggle');
                } else {
                    msgShow("Error al eliminar", "success");
                }
            }
        });
    }

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>