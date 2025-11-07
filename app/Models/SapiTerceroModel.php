<?php

namespace App\Models;

use App\Models\BaseModel; // Asumo que BaseModel está aquí

class SapiTerceroModel extends BaseModel
{
    protected $table = 'sgc_terceros';
    protected $primaryKey = 'ter_id'; // O el nombre real de tu PK
    protected $useAutoIncrement = true;
    
    protected $allowedFields = [
        'ter_nombre',
        'ter_identificacion',
        'ter_tipo_per',
        'ter_correo',
        'ter_telefono',
        'ter_pais', 
        'ter_estado', 
        'ter_municipio', 
        'ter_parroquia',
        'ter_direccion',
    ];

	// Método para listar todos los participantes de mediacion
public function listar_participantes_Mediacion()
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_terceros'); 
    
    // CORRECCIÓN: Unir todas las columnas en una sola cadena separada por comas
    $builder->select('ter_id, ter_nombre, ter_identificacion, ter_tipo_per, ter_correo, ter_telefono, ter_pais, ter_estado, ter_municipio, ter_parroquia, ter_direccion');
    
    $query = $builder->get();
    $resultado = $query->getResult();
    
    return $resultado;
}
// Método para listar  los participantes de mediacion en funcion de la cedula 
public function buscar_datos_cedula_mediacion($cedula)
    {
        return $this->db->table('sgc_terceros')
                        ->select('ter_id, ter_nombre, ter_identificacion, ter_tipo_per, ter_correo, ter_telefono, ter_pais, ter_estado, ter_municipio, ter_parroquia, ter_direccion, ter_impre_abogado')
                        ->where('ter_identificacion', $cedula)
                        ->get()
                        ->getResult();
    }


}