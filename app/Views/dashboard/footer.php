<script type="text/javascript" src="<?php echo base_url(); ?>/custom/dashboard/dashboard.js"></script>
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

<script>
var $token = "<?= base_url('session/getSesionData') ?>";
</script>


</body>

</html>