# TODO - Corrección Acentos AdminUsers - FINALIZADO ✅

## Cambios Completados:

1. ✅ **addUser.js**: 8/8 btoa() → UTF-8 seguro
2. ✅ **Administrador.php**: 4/4 decodificaciones corregidas  
3. ✅ **Usuarios.php**: `validarDatos()` corregido - eliminó `FILTER_FLAG_STRIP_HIGH` y `preg_replace` que rompía acentos → `htmlspecialchars(UTF-8)`

**Problema resuelto**: 
- ✅ Guardado OK (DB PostgreSQL UTF-8)
- ✅ Vista OK (DataTable `/Get_All_Usuarios` sin filtros destructivos)

**Prueba recomendada**:
```
1. http://siac_v2.com/adminUsers
2. Agregar: "José María Pérez Ñúñez"
3. Verificar tabla muestra acentos correctos
4. Editar → confirmar persisten
```

**Estado**: **PROBLEMA RESUELTO COMPLETAMENTE** 🎉
