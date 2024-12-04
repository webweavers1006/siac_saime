<?php

namespace App\Models;

use CodeIgniter\Model;


class Talleres_Participantes_Model extends Model
{
    

    public function listar_talleres_participantes($desde = null, $hasta = null, $tipo_pi = null, $tipo_atencion_usu = null, $sexo = null, $via_atencion = null, $direcciones_caso = null, $tipo_beneficiario = 0, $atencion_cuidadano = 0, $estatus = 0,$id_estado = 0,$id_municipio = 0,$id_parroquia=0,$edad_min=null,$edad_max=null,$detalle_atencion=0)
    {

        
        $builder = $this->db->table('public.sgc_talleres_participantes as t');
        $builder->select("p.id, p.nombre || ' ' || p.apellido as nombre_completo, p.cedula, p.nacionalidad, p.tipo_beneficiario,p.edad");
        $builder->select("p.edad, p.pais, p.estado, p.municipio, p.parroquia, p.telefono,p.sexo");
        $builder->select("p.nombre, p.apellido");
        $builder->select("b.tipo_beneficiario_nombre,");
        $builder->select("pais.paisnom,");
        $builder->select("e.estadonom,");
        $builder->select("m.municipionom ");
        $builder->select("pa.parroquianom ");
        $builder->select("c.casodesc ");
        $builder->join('public.sgc_participantes as p', 't.participante_id = p.id');
        $builder->join('public.sgc_tipo_beneficiarios as b', 'p.tipo_beneficiario = b.tipo_beneficiario_id');
        $builder->join('public.sgc_paises as pais', 'p.pais = pais.paisid'); 
        $builder->join('public.sgc_estados as e', 'p.estado = e.estadoid'); 
        $builder->join('public.sgc_municipio as m', 'p.municipio = m.municipioid'); 
        $builder->join('public.sgc_parroquias as pa', 'p.parroquia = pa.parroquiaid'); 
        $builder->join('public.sgc_casos as c', 't.id_caso = c.idcaso'); 
        $builder->join('public.sgc_tipo_prop_caso as tpc', 't.id_caso = tpc.idcaso'); 

        $builder->where(['c.borrado' => false]);
        if ($desde !== null && $desde !== 'null' && $hasta !== null && $hasta !== 'null')
        {
            $builder->where("c.casofec BETWEEN '$desde' AND '$hasta'");
        }
        if ($sexo !== 'null' && $sexo!== null) {
            $builder->where("p.sexo", $sexo);
        }

        if ($tipo_beneficiario != '0' && $tipo_beneficiario != 'null') {
            $builder->where("p.tipo_beneficiario", $tipo_beneficiario);
        }
        if ($via_atencion != '0' && $via_atencion != 'null') {
            $builder->where("c.idrrss", $via_atencion);
        }
        if ($tipo_atencion_usu != '0' && $tipo_atencion_usu != 'null') {
            $builder->where("c.id_tipo_atencion", $tipo_atencion_usu);
        }


        if ($id_estado != '0' && $id_estado != 'null') {
            $builder->where("p.estado", $id_estado);
        }

        if ($id_municipio != '0' && $id_municipio != 'null') {
            $builder->where("p.municipio", $id_municipio);
        }

         if ($id_parroquia != '0' && $id_parroquia != 'null') {
            $builder->where("p.parroquia", $id_parroquia);
        }
        
        $resultado = $builder->get()->getResult();
        return $resultado;
    }

}
