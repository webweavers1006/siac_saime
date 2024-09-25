<?php
require('UserInfo.php');
?>
<input type="hidden" id="direccion_ip" name="" value="<?= UserInfo::get_ip(); ?>">
<input type="hidden" id="dispositivo" name="" value="<?= UserInfo::get_device(); ?>">
<script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/auditoria/auditoria_sistemas.js"></script>
<!-- ******ESTO ES PARA INSERTAR LA IMAGEN EN EL PDF,******* -->
<?php
$path = ROOTPATH . 'public/img/header.png'; //this is the image path
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
?>
<script>
    var rootpath = '<?php echo ($base64); ?>'
</script>

</body>

</html>