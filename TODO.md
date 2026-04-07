# TODO: Fix Denuncia Type 5 Not Saving to sgc_casos_denuncias

## Plan Approved ✅
**Files**: Casos_Controler.php, agregar_caso.php (JS), nuevo_caso.js

### 📋 Checklist (5 Steps)

- [x] **1. Edit Casos_Controler.php** - Add denuncia insert to `nuevoCaso()` ✅
- [x] **2. Fix JS Form** - ✅ JS already sets `bandera_denuncia=true` + all `denu_*` fields for tipo=5
- [x] **3. Debug & Fix** - ✅ Moved `$Casos_denuncias` instantiation **INSIDE** foreach if(type==5) block (matches actualizarCaso())
- [x] **4. JS Keys Fix** - ✅ `nuevo_caso.js`: `option_*` → `denu_*` keys (matches controller expectations)
- [ ] **5. Test Creation** - Create type 5 → Verify `public.sgc_casos_denuncias` insert
- [ ] **6. Verify Rollback** - Check CGR deleted (if exists)
- [ ] **7. Audit Logs** - Confirm entries
- [ ] **8. Complete** - Remove TODO.md + 🎉

**Final Test**:
```
1. /vista_agregar_caso → Tipo=5 + fill denu_* → Save
2. SELECT * FROM public.sgc_casos_denuncias WHERE denu_id_caso = [NEW_ID];
```

**¿Inserta ahora?** (Sí → ✅ Complete)

**Test Now**:
1. `/vista_agregar_caso` → Tipo **Denuncia (5)** + fill `denu_*`
2. Save → `SELECT * FROM public.sgc_casos_denuncias ORDER BY denu_id DESC LIMIT 1;`

**Status?** (Works → Next Steps | Still fails → Debug)

**Next**: Edit Casos_Controler.php → Mark [x] when done
