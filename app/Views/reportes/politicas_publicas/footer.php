<!-- Script -->
<script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/reportes/reporte_politicas_publicas.js"></script>

<?php
// Para los estilos en Excel y/o PDF
$path = ROOTPATH . 'public/img/cintillo_tradicional.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
?>
<script>
    var rootpath = '<?php echo ($base64); ?>'
</script>

