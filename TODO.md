# TODO - Select Operador en Políticas Públicas

- [ ] Agregar en `app/Views/reportes/politicas_publicas/content.php` el select **Operador** (oculto por defecto) y el contenedor para mostrarlo según dirección administrativa.
- [ ] Agregar endpoint AJAX en `app/Controllers/Politicas_Publicas_Controler.php` (o método dentro del mismo controlador) para listar usuarios activos por `id_direccion_administrativa` usando `Usuarios->getAllUsers_filtro_Pliticas_Publicas()`.
- [ ] Ajustar `app/Models/Usuarios.php` para que `getAllUsers_filtro_Pliticas_Publicas()` acepte filtro por dirección (parámetro opcional) y mantenga `usuopborrado=false`.
- [ ] Actualizar `public/custom/js/reportes/reporte_politicas_publicas.js`:
  - [ ] Evento `change` en `#direccion_administrativa` para mostrar/ocultar el select Operador.
  - [ ] Llenar opciones (primera: “Todos”).
  - [ ] Capturar selección y enviar `usuarios` al DataTables.
- [ ] Actualizar `app/Controllers/Politicas_Publicas_Controler.php` para incluir `usuarios` en `$params`.
- [ ] Actualizar `app/Models/Casos.php` en `getReporteData_Politicas_Publicas($params)` para aplicar filtro `a.idusuopr = usuarios` cuando `usuarios != 0`.
- [ ] Ajustar también el `countSql` del mismo método para que DataTables respete el filtro por usuario.
- [ ] Probar en navegador: seleccionar dirección -> cargar operadores; consultar con “Todos” vs operador específico.

