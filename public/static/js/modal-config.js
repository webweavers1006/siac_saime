// modal-config.js
window.ModalConfig = {
  // Configuración por defecto para los puntos
  default: {
    fields: [
      { key: 'nombre_solicitante', label: 'Nombre', show: true },
      { key: 'apellido_solicitante', label: 'Apellido', show: true },
      { key: 'descripcion_caso', label: 'Descripción', show: true },
      { key: 'nombre_tipo_atencion_detalle', label: 'Tipos de ayuda', show: true },
      { key: 'correo_solicitante', label: 'Correo', show: true },
      { key: 'telefono_solicitante', label: 'Telefono', show: true },
      { key: 'nombre_estado', label: 'Estado', show: true },
      { key: 'nombre_municipio', label: 'Municipio', show: true },
      { key: 'nombre_parroquia', label: 'Parroquia', show: true },
      { key: 'puntos_cuenta', label: 'Punto de cuenta', section:true, show: true, carpet:'documentos_punto_cuenta', elements: {
        apellido: { key: 'apellido', label: 'Apellido' },
        nombre: { key: 'nombre', label: 'Nombre' },
        correo: { key: 'correo', label: 'Correo' },
        monto_aprobado: { key: 'monto_aprobado', label: 'Monto Aprobado' },
        causa_beneficio: { key: 'causa_beneficio', label: 'Causa/Beneficio' },
        documentos_pc: { key: 'documentos_pc', label: 'Documentos', grip: true, link: true, carpet: 'documentos_punto_cuenta' }
      } },
      { key: 'rutas_documentos_caso', label: 'Archivos Adjuntos', section:true, show: true, grip: true, carpet:'documentos_casos', link:true },
    ],
    showCoordinates: true,
    legend: {
      enabled: true, // Mostrar la leyenda
      field: 'nombre_tipo_atencion_detalle', // Campo por el cual se agrupa la leyenda
      colorPalette: [
        '#3388ff', // azul
        '#e67e22', // naranja
        '#27ae60', // verde
        '#8e44ad', // morado
        '#c0392b', // rojo
        '#f1c40f', // amarillo
        '#16a085', // turquesa
        '#34495e', // gris oscuro
        '#888'     // gris
      ],
      assignedColors: {}, // Se llenará dinámicamente
      nextColorIndex: 0
    }
  },
};
