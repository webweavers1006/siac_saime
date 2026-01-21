<script>
  $(function () {
    // Inicializar DataTable si hay datos
    if ($('#detallesTable').length > 0) {
      $('#detallesTable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        }
      });
    }
  });
</script>

