


<!-- ChartJS -->
<!-- Script -->
<script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/reportes/estadisticas_tipo_beneficiario.js"></script>
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

</html>



