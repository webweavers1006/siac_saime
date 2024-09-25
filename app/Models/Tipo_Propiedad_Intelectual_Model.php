<?php namespace App\Models;
use CodeIgniter\Model;
class Tipo_Propiedad_Intelectual_Model extends BaseModel
{
     public function Listar_Propiedad_Intelectual()
     {
        $db      = \Config\Database::connect();
		$strQuery ="SELECT p_intel.tipo_prop_id,p_intel.tipo_prop_nombre "; 
		$strQuery .="FROM public.sgc_tipo_prop_intelec as p_intel WHERE p_intel.tipo_prop_borrado='false' ";
		$query = $db->query($strQuery);
		$resultado=$query->getResult(); 
		return $resultado;
     }

     public function Listar_Propiedad_Intelectual_MOD()
     {
        $db      = \Config\Database::connect();
		$strQuery ="SELECT p_intel.tipo_prop_id,p_intel.tipo_prop_nombre "; 
		$strQuery .="FROM public.sgc_tipo_prop_intelec as p_intel WHERE p_intel.tipo_prop_borrado='false' ";
        $strQuery .=" and  p_intel.tipo_prop_id !=1 ";
		$query = $db->query($strQuery);
		$resultado=$query->getResult(); 
		return $resultado;
     }



     
    }