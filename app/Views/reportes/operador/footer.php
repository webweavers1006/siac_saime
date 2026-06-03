
<!-- Script -->
<script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/reportes/reporte_operador.js"></script><!-- Para los estilos en Excel     -->
<!-- <script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.1/js/buttons.html5.styles.min.js"></script> -->

<!-- ******ESTO ES PARA INSERTAR LA IMAGEN EN EL PDF (COMENTADO) ******* -->
<?php /*
$path = ROOTPATH . 'public/' . (new \Config\Assets())->cintilloPdf; //this is the image path
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
*/ ?>
<script>
    var rootpath = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
</script>