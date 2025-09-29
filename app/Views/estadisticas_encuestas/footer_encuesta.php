<script>
    var writePath = "<?php echo WRITEPATH; ?>";
</script>

<script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/estadistica_encuesta_sastifaccion/estadistica_encuesta_sastifaccion.js"></script>
<!-- SweetAlert2 -->
<script src="<?php echo base_url(); ?>/theme/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- <script src="<php echo base_url(); ?>/js_paginas/jquery-3.1.0.js"></script> -->
<script>
    $(document).ready(function() {
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day);
        $("#fecha-recibido").val(today);
    });
</script>

<!-- ******ESTO ES PARA INSERTAR LA IMAGEN EN EL PDF,******* -->
<?php
$path = ROOTPATH . 'public/img/cintillo_tradicional.png'; //this is the image path
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
?>
<script>
    var rootpath = '<?php echo ($base64); ?>'
</script>
<!-- footer_encuesta.php -->
<script>
    var url_encuestas = "<?php echo $url_encuestas; ?>";
</script>

</body>

</html>