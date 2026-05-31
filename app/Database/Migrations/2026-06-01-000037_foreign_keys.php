<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Add all Foreign Keys
 * Runs AFTER all tables are created to avoid dependency ordering issues.
 * 22 foreign keys from the original siac_v2_saime database.
 */
class ForeignKeys extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE sgc_casos ADD CONSTRAINT sgc_casos_estadoid_foreign FOREIGN KEY (estadoid) REFERENCES sgc_estados (estadoid) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_casos ADD CONSTRAINT sgc_casos_parroquiaid_foreign FOREIGN KEY (parroquiaid) REFERENCES sgc_parroquias (parroquiaid) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_casos ADD CONSTRAINT sgc_casos_idusuopr_foreign FOREIGN KEY (idusuopr) REFERENCES sgc_usuario_operador (idusuopr) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_casos ADD CONSTRAINT sgc_casos_municipioid_foreign FOREIGN KEY (municipioid) REFERENCES sgc_municipio (municipioid) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_casos ADD CONSTRAINT sgc_casos_idest_foreign FOREIGN KEY (idest) REFERENCES sgc_estatus (idest) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_casos ADD CONSTRAINT sgc_casos_idrrss_foreign FOREIGN KEY (idrrss) REFERENCES sgc_red_social (red_s_id) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_estados ADD CONSTRAINT sgc_estados_paisid_foreign FOREIGN KEY (paisid) REFERENCES sgc_paises (paisid) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_mediacion ADD CONSTRAINT fk_mediacion_apo_contra FOREIGN KEY (med_apo_contra_id) REFERENCES sgc_terceros (ter_id) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_mediacion ADD CONSTRAINT fk_mediacion_apo_sol FOREIGN KEY (med_apo_sol_id) REFERENCES sgc_terceros (ter_id) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_mediacion ADD CONSTRAINT fk_mediacion_contraparte FOREIGN KEY (med_contra_id) REFERENCES sgc_terceros (ter_id) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_municipio ADD CONSTRAINT sgc_municipio_estadoid_foreign FOREIGN KEY (estadoid) REFERENCES sgc_estados (estadoid) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_notificaciones ADD CONSTRAINT sgc_notificaciones_id_caso_autor_fkey FOREIGN KEY (id_caso_autor) REFERENCES sgc_usuario_operador (idusuopr) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_notificaciones ADD CONSTRAINT sgc_notificaciones_id_caso_fkey FOREIGN KEY (id_caso) REFERENCES sgc_casos (idcaso) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_notificaciones ADD CONSTRAINT sgc_notificaciones_id_usuario_accion_fkey FOREIGN KEY (id_usuario_accion) REFERENCES sgc_usuario_operador (idusuopr) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_notificaciones ADD CONSTRAINT sgc_notificaciones_id_usuario_destino_fkey FOREIGN KEY (id_usuario_destino) REFERENCES sgc_usuario_operador (idusuopr) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_parroquias ADD CONSTRAINT sgc_parroquias_municipioid_foreign FOREIGN KEY (municipioid) REFERENCES sgc_municipio (municipioid) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_seguimiento_caso ADD CONSTRAINT sgc_seguimiento_caso_idcaso_foreign FOREIGN KEY (idcaso) REFERENCES sgc_casos (idcaso) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_seguimiento_caso ADD CONSTRAINT sgc_seguimiento_caso_idestllam_foreign FOREIGN KEY (idestllam) REFERENCES sgc_estatus_llamadas (idestllam) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_seguimiento_caso ADD CONSTRAINT sgc_seguimiento_caso_idusuopr_foreign FOREIGN KEY (idusuopr) REFERENCES sgc_usuario_operador (idusuopr) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_tipo_prop_caso ADD CONSTRAINT sgc_tipo_prop_caso_idcaso_foreign FOREIGN KEY (idcaso) REFERENCES sgc_casos (idcaso) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_tipo_prop_caso ADD CONSTRAINT sgc_tipo_prop_caso_idtippropint_foreign FOREIGN KEY (idtippropint) REFERENCES sgc_tipo_prop_intelec (tipo_prop_id) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE sgc_usuario_operador ADD CONSTRAINT sgc_usuario_operador_idrol_foreign FOREIGN KEY (idrol) REFERENCES sgc_roles (idrol) ON DELETE CASCADE ON UPDATE CASCADE");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE sgc_usuario_operador DROP CONSTRAINT IF EXISTS sgc_usuario_operador_idrol_foreign");
        $this->db->query("ALTER TABLE sgc_tipo_prop_caso DROP CONSTRAINT IF EXISTS sgc_tipo_prop_caso_idtippropint_foreign");
        $this->db->query("ALTER TABLE sgc_tipo_prop_caso DROP CONSTRAINT IF EXISTS sgc_tipo_prop_caso_idcaso_foreign");
        $this->db->query("ALTER TABLE sgc_seguimiento_caso DROP CONSTRAINT IF EXISTS sgc_seguimiento_caso_idusuopr_foreign");
        $this->db->query("ALTER TABLE sgc_seguimiento_caso DROP CONSTRAINT IF EXISTS sgc_seguimiento_caso_idestllam_foreign");
        $this->db->query("ALTER TABLE sgc_seguimiento_caso DROP CONSTRAINT IF EXISTS sgc_seguimiento_caso_idcaso_foreign");
        $this->db->query("ALTER TABLE sgc_parroquias DROP CONSTRAINT IF EXISTS sgc_parroquias_municipioid_foreign");
        $this->db->query("ALTER TABLE sgc_notificaciones DROP CONSTRAINT IF EXISTS sgc_notificaciones_id_usuario_destino_fkey");
        $this->db->query("ALTER TABLE sgc_notificaciones DROP CONSTRAINT IF EXISTS sgc_notificaciones_id_usuario_accion_fkey");
        $this->db->query("ALTER TABLE sgc_notificaciones DROP CONSTRAINT IF EXISTS sgc_notificaciones_id_caso_fkey");
        $this->db->query("ALTER TABLE sgc_notificaciones DROP CONSTRAINT IF EXISTS sgc_notificaciones_id_caso_autor_fkey");
        $this->db->query("ALTER TABLE sgc_municipio DROP CONSTRAINT IF EXISTS sgc_municipio_estadoid_foreign");
        $this->db->query("ALTER TABLE sgc_mediacion DROP CONSTRAINT IF EXISTS fk_mediacion_contraparte");
        $this->db->query("ALTER TABLE sgc_mediacion DROP CONSTRAINT IF EXISTS fk_mediacion_apo_sol");
        $this->db->query("ALTER TABLE sgc_mediacion DROP CONSTRAINT IF EXISTS fk_mediacion_apo_contra");
        $this->db->query("ALTER TABLE sgc_estados DROP CONSTRAINT IF EXISTS sgc_estados_paisid_foreign");
        $this->db->query("ALTER TABLE sgc_casos DROP CONSTRAINT IF EXISTS sgc_casos_idrrss_foreign");
        $this->db->query("ALTER TABLE sgc_casos DROP CONSTRAINT IF EXISTS sgc_casos_idest_foreign");
        $this->db->query("ALTER TABLE sgc_casos DROP CONSTRAINT IF EXISTS sgc_casos_municipioid_foreign");
        $this->db->query("ALTER TABLE sgc_casos DROP CONSTRAINT IF EXISTS sgc_casos_idusuopr_foreign");
        $this->db->query("ALTER TABLE sgc_casos DROP CONSTRAINT IF EXISTS sgc_casos_parroquiaid_foreign");
        $this->db->query("ALTER TABLE sgc_casos DROP CONSTRAINT IF EXISTS sgc_casos_estadoid_foreign");
    }
}
