<script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/audiencias/agregar_solicitudes.js"></script>
<script>
  $(document).ready(function() {
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    $("#fecha-recibido").val(today);
  });
</script>
</body>

</html>