<?php

namespace App\Models;

use CodeIgniter\Model;

class Punto_Cuenta_Model extends BaseModel
{




   public function Listar_Punto_Cuenta()
{
    $db = \Config\Database::connect();
    $builder = $db->table('public.sgc_punto_cuenta as p');
    $builder->select("p.nombre || ' ' || p.apellido as nombre");
    $builder->select('p.id, p.numero_punto_cuenta, p.fecha_punto_cuenta, p.monto_aprobado, p.causa_beneficio');
    $builder->select("CASE WHEN p.borrado = 'f' THEN 'Activo' ELSE 'Inactivo' END as estado"); // Cambié 'borrado' a 'estado' para ser más claro
   // $builder->where('p.borrado', false);
    $query = $builder->get();
     // echo $db->getLastQuery(); 
    $resultado = $query->getResult();
    return $resultado;
}


    //Metodo para insertar un punto de cuenta 
    public function agregar($punto_cuenta)
    {
        $builder = $this->dbconn("sgc_punto_cuenta");
        $query = $builder->insert($punto_cuenta);
        return $query;
    }

   // Metodo para actualizar un registro de Punto de Cuenta
    public function update_p_cuenta($registro_id, $punto_cuenta)
    {
        $builder = $this->dbconn("sgc_punto_cuenta");
        $query = $builder->update($punto_cuenta, ['id' => $registro_id]);
        return $query;
    }




    public function verificar_caso($inputnuevocaso)
    {
      $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos as a');
        $builder->distinct();
        $builder->select('deta.tipo_atend_nombre,d.tipo_atend_borrado, a.idcaso, a.tipo_beneficiario,a.tipo_atend_id, a.casotel, TRIM(a.casoced) AS casoced, a.casonom, a.casoape, a.casodesc');
        $builder->select('a.pais,a.caso_nacionalidad, a.idrrss, a.ofiid, a.estadoid, a.id_tipo_atencion');
        $builder->select('a.caso_org_id,a.edad, to_char(a.fecha_nacimiento, \'dd/mm/yyyy\') as fecha_nacimiento, a.fecha_nacimiento as fecha_nacimiento_normal');
        $builder->select('a.municipioid, a.parroquiaid, a.direccion, a.correo, a.ente_adscrito_id, a.profesion');
        $builder->select('CONCAT(a.caso_nacionalidad, a.casoced) AS cedula');
        $builder->select('cgr.competencia_cgr, cgr.asume_cgr');
        $builder->select('denu.denu_afecta_persona, denu.denu_afecta_comunidad, denu.denu_afecta_terceros');
        $builder->select('denu.denu_involucrados, denu.denu_fecha_hechos, denu.denu_instancia_popular');
        $builder->select('denu.denu_rif_instancia, denu.denu_ente_financiador, denu.denu_nombre_proyecto, denu.denu_monto_aprovado');
        $builder->select('CONCAT(a.casonom, \' \', a.casoape) AS nombre');
        $builder->select('CONCAT(u_ope.usuopnom, \' \', u_ope.usuopape) AS user_name');
        $builder->select('CASE WHEN sexo = \'1\' THEN \'M\' ELSE \'F\' END as sexo');
        $builder->select('to_char(a.casofec, \'dd/mm/yyyy\') as casofec, a.casofec as casofec_normal, b.estnom');
        $builder->select('tpinte.tipo_prop_nombre, tpinte.tipo_prop_id');
        $builder->select('t_antusu.tipo_aten_nombre, t_antusu.act_pro_int,t_antusu.organismo_pp,t_antusu.act_coordenadas,t_antusu.act_punto_cuenta ');
        $builder->join('sgc_estatus b', 'b.idest = a.idest');
        $builder->join('sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr');
        $builder->join('sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id');
        $builder->join('sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso', 'left');
        $builder->join('sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id', 'left');
        $builder->join('sgc_registro_cgr cgr', 'a.idcaso = cgr.id_caso', 'left');
        $builder->join('sgc_tipoatenciondetalle as d', 'a.tipo_atend_id = d.tipo_atend_id', 'left');
        $builder->join('sgc_casos_denuncias denu', 'a.idcaso = denu_id_caso', 'left');
        $builder->join('sgc_tipoatenciondetalle deta', 'a.tipo_atend_id = deta.tipo_atend_id', 'left');
        $builder->where('a.borrado', 'false');
        $builder->where('a.idcaso', $inputnuevocaso);
        $builder->orderBy('a.idcaso', 'DESC');
        $query = $builder->get();
        //echo $db->getLastQuery(); 
        return $query->getResult();
    }

    

    // Dentro de tu modelo (ej: Punto_Cuenta_Model.php)

public function cargarCasosAsociados($id_punto_cuenta)
{
    $db = \Config\Database::connect();
    $id_punto_cuenta = (int)$id_punto_cuenta; 
    $builder = $this->db->table('public.sgc_caso_punto_cuenta p');
    $builder->select('CONCAT(c.casonom, \' \', c.casoape) AS nombre');
    $builder->select('p.id_punto_cuenta,p.id_caso,p.borrado');
    $builder->select('t_antusu.tipo_aten_nombre');
    $builder->select('deta.tipo_atend_nombre');
    $builder->join('sgc_casos c', 'c.idcaso = p.id_caso', 'left');
    $builder->join('sgc_tipoatencion_usu as t_antusu', 'c.id_tipo_atencion = t_antusu.tipo_aten_id');
    $builder->join('sgc_tipoatenciondetalle as d', 'c.tipo_atend_id = d.tipo_atend_id', 'left');
    $builder->join('sgc_tipoatenciondetalle deta', 'c.tipo_atend_id = deta.tipo_atend_id', 'left');
    $builder->where('id_punto_cuenta', $id_punto_cuenta);
    $builder->where('c.borrado', false);
     //echo $db->getLastQuery(); 
     // die();
    return $builder->get()->getResult(); 
    
  
}




    public function verificar_caso_existente(int $id_punto_cuenta, int $id_caso)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_caso_punto_cuenta ');    
       
        $builder->select("*");
        $builder->where('id_punto_cuenta', $id_punto_cuenta);
        $builder ->where('id_caso', $id_caso);
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }



 public function asociar_nuevo_caso($datosAsociacion)
    {
        $builder = $this->dbconn("sgc_caso_punto_cuenta");
        $query = $builder->insert($datosAsociacion);
        return $query;
    }


 //Metodo para agregar  el nombre de los cocumentos de asosciados a los casos
    public function agregar_docu_punto_cuenta(array $documentos_punto)
    {
        
        $db = \Config\Database::connect();
        $builder = $this->dbconn('sgc_documentos_punto_cuenta');
        $query = $builder->insert($documentos_punto);
        return $query;
    }



public function buscar_documentos_por_punto($punto_id) // Recibe el ID del punto/caso
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_documentos_punto_cuenta AS p');
    $builder->select('p.docu_id_punto_cuenta, p.docu_ruta');
    $builder->where('p.docu_id_punto_cuenta', $punto_id);
    $query = $builder->get();
    // Retorna los resultados como un array de objetos para manejarlo fácilmente en el controlador.
    return $query->getResult(); 
}



public function verificar_caso_punto_cuenta($idcaso)
{
    
    $db = \Config\Database::connect();
    $idcaso = (int)$idcaso; 
    $builder = $this->db->table('public.sgc_caso_punto_cuenta p');
    $builder->select('p.id_punto_cuenta,p.id_caso,p.borrado');
    $builder->select('pc.numero_punto_cuenta');
    $builder->select('CONCAT(pc.nombre, \' \', pc.apellido) AS nombre');
    $builder->select('docu.docu_id_punto_cuenta,docu.docu_ruta');
    $builder->join('sgc_punto_cuenta pc', 'p.id_punto_cuenta = pc.id', 'left');
    $builder->join('sgc_documentos_punto_cuenta docu', 'p.id_punto_cuenta = docu.docu_id_punto_cuenta', 'left');
    $builder->where('id_caso', $idcaso);
    // $query = $builder->get();
    // echo $db->getLastQuery(); 
    //   die();
    return $builder->get()->getResult(); 

}
}