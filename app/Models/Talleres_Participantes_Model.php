<?php

namespace App\Models;

use CodeIgniter\Model;


class Talleres_Participantes_Model extends Model
{

 public function getParticipantesPorCaso($id_caso)
{
    $builder = $this->db->table('public.sgc_talleres_participantes tp');
    
    $builder->select([
        'p.nombre',
        'p.apellido',
        'p.cedula',
        'b.tipo_beneficiario_nombre as tipo_beneficiario',
        'p.edad',
        'p.telefono',
        'p.sexo',
        'p.nacionalidad as t_persona',
        'tp.org_id', // Traemos el ID del organismo desde la tabla intermedia
        'o.org_nombre', // Traemos el nombre del organismo
        'est.estadonom', 
        'mun.municipionom', 
        'par.parroquianom'
    ]);

    $builder->join('public.sgc_participantes p', 'p.id = tp.participante_id');
    $builder->join('public.sgc_tipo_beneficiarios b', 'p.tipo_beneficiario = b.tipo_beneficiario_id', 'left');
    
    // Join con la tabla de organismos que proporcionaste
    $builder->join('public.sgc_org_pod_popular o', 'tp.org_id = o.org_id', 'left');
    
    $builder->join('public.sgc_estados est', 'p.estado = est.estadoid', 'left');
    $builder->join('public.sgc_municipio mun', 'p.municipio = mun.municipioid', 'left');
    $builder->join('public.sgc_parroquias par', 'p.parroquia = par.parroquiaid', 'left');

    $builder->where('tp.id_caso', $id_caso);
    $builder->orderBy('p.apellido', 'ASC');

    return $builder->get()->getResultArray();
}

    public function listar_talleres_participantes($desde = null, $hasta = null, $tipo_pi = null, $tipo_atencion_usu = null, $sexo = null, $via_atencion = null, $direcciones_caso = null, $tipo_beneficiario = 0, $atencion_cuidadano = 0, $estatus = 0, $id_estado = 0, $id_municipio = 0, $id_parroquia = 0, $edad_min = null, $edad_max = null, $detalle_atencion = 0, $org_id = 0)
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
        
        if ($org_id != '0' && $org_id != 'null') {
            $builder->where("t.org_id", $org_id);
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


    public function editar_org_taller($info_talleres)
    {
        $participante_id = (int) $info_talleres['participante_id'];
        $id = (int) $info_talleres['id'];
        $org_id = (int) $info_talleres['org_id'];
        $builder = $this->db->table('sgc_talleres_participantes');
        $builder->where('id', $id);
        $builder->where('participante_id', $participante_id);
        $data = [
            'org_id' => $org_id
        ];
        $success = $builder->update($data);
    
        return $success;
    }
    


    

}
