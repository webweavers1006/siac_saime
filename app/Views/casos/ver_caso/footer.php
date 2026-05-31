    <!-- jQuery -->

    <script src="<?php echo base_url(); ?>/custom/js/seguimiento/add_seguimiento.js"></script>
    <script src="<?php echo base_url(); ?>/custom/js/estatus/cambiar_estatus.js"></script>


<!-- ******ESTO ES PARA INSERTAR LA IMAGEN EN EL PDF,******* -->
<?php
$path = ROOTPATH . 'public/' . (new \Config\Assets())->cintilloPdf; //this is the image path
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
?>
<script>
    var rootpath = '<?php echo ($base64); ?>'
</script>


    </body>

    </html>