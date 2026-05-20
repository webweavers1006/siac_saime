<?php

namespace App\Models;

use CodeIgniter\Model;


class Participantes_Model extends Model
{
    public function agregar_participante($participantes)
    {
        $builder = $this->db->table('sgc_participantes');
        
        try {
            $builder->insert($participantes);
            return $this->db->insertID(); // Retorna el ID del participante insertado
        } catch (\Exception $e) {
            error_log('Error al insertar participante: ' . $e->getMessage());
            return false; // Retorna false si la inserción falla
        }
    }
public function agregar_participantes_talleres($info_talleres)
{
    if (empty($info_talleres)) {
        return false;
    }

    // Usamos la conexión directa a la base de datos
    $db = \Config\Database::connect();
    
    $valores = [];
    
    // Recorremos el lote para escapar los datos manualmente y evitar inyecciones SQL
    foreach ($info_talleres as $dato) {
        $id_caso         = $db->escape($dato['id_caso']);
        $participante_id = $db->escape($dato['participante_id']);
        
        // Si org_id está vacío, seteamos NULL en duro para Postgres, sino lo escapamos
        $org_id          = !empty($dato['org_id']) ? $db->escape($dato['org_id']) : 'NULL';
        
        // Armamos la fila de valores
        $valores[] = "($id_caso, $participante_id, $org_id)";
    }

    try {
        // Construimos el query string limpio
        $sql = "INSERT INTO public.sgc_talleres_participantes (id_caso, participante_id, org_id) VALUES " . implode(', ', $valores);
        
        // 🪄 Aplicamos el candado para ignorar los que ya existen en el caso
        $sql .= " ON CONFLICT (id_caso, participante_id) DO NOTHING";

        // Ejecutamos la consulta directa
        $db->query($sql);
        
        return true; 
    } catch (\Exception $e) {
        // En caso de cualquier otro error imprevisto, se guarda en el log
        error_log('Error real en agregar_participantes_talleres: ' . $e->getMessage());
        return false; 
    }
}
    


    public function listar_participantes($idcaso)
    {
        $builder = $this->db->table('public.sgc_talleres_participantes as t');
        $builder->select("t.id as id_taller,t.org_id,p.id, p.nombre || ' ' || p.apellido as nombre_completo, p.cedula, p.nacionalidad, p.tipo_beneficiario,p.edad");
        $builder->select("p.edad, p.pais, p.estado, p.municipio, p.parroquia, p.telefono,p.sexo");
        $builder->select("p.nombre, p.apellido");
        $builder->select("b.tipo_beneficiario_nombre,");
        $builder->select("pais.paisnom,");
        $builder->select("e.estadonom,");
        $builder->select("m.municipionom ");
        $builder->select("pa.parroquianom ");
        $builder->join('public.sgc_participantes as p', 't.participante_id = p.id');
        $builder->join('public.sgc_tipo_beneficiarios as b', 'p.tipo_beneficiario = b.tipo_beneficiario_id');
        $builder->join('public.sgc_paises as pais', 'p.pais = pais.paisid'); 
        $builder->join('public.sgc_estados as e', 'p.estado = e.estadoid'); 
        $builder->join('public.sgc_municipio as m', 'p.municipio = m.municipioid'); 
        $builder->join('public.sgc_parroquias as pa', 'p.parroquia = pa.parroquiaid'); 
        $builder->where(['t.id_caso' => $idcaso]);
        $resultado = $builder->get()->getResult();
        return $resultado;
    }
    





    public function editar_participante($participante, $id_participante)
{
    
    $id_participante = (int) $id_participante;
    $builder = $this->db->table('sgc_participantes');
    $builder->where('id', $id_participante);
    $success = $builder->update($participante);
    return $success;
    
}

public function buscar_participante($cedula)
    {
        $db = \Config\Database::connect();
        $builder = $this->db->table('sgc_participantes p');
        $builder->select("p.id,p.nombre,p.apellido,p.cedula,p.nacionalidad,p.tipo_beneficiario,p.edad,p.pais,p.estado,p.municipio "); 
        $builder->select("p.parroquia, p.telefono, p.sexo");
        $builder->where(['p.cedula' => $cedula]);
        $query = $builder->get();
        $resultado = $query->getResult();
        //echo $db->getLastQuery(); 
        return $resultado;
    }



   public function Listar_Operadores()
{
    $builder = $this->db->table('public.sgc_usuario_operador as p');
    
    // Seleccionamos los campos (se eliminó la coma huérfana al final)
    $builder->select("p.usuopnom || ' ' || p.usuopape as nombre_completo, p.idusuopr");
    
    // Filtramos para que traiga tanto el rol 4 como el rol 2
    $builder->whereIn('p.idrol', [4, 2]);
    
    // Opcional: Filtro para evitar traer operadores borrados si manejas borrado lógico
    $builder->where(['p.usuopborrado' => false]);

    $resultado = $builder->get()->getResult();
    return $resultado;
}



}
