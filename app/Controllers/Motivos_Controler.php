<?php

namespace App\Controllers;

use App\Models\Motivos_Model;
use CodeIgniter\API\ResponseTrait;

class Motivos_Controler extends BaseController
{
    use ResponseTrait;

    /**
     * Listar motivos filtrados por área (tipo_prop_id).
     * GET /listar_motivos_por_area/(:num)
     */
    public function listarPorArea($tipoPropId = null)
    {
        $model = new Motivos_Model();
        $query = $model->listarPorArea($tipoPropId);

        if (empty($query)) {
            return $this->response->setJSON([]);
        }
        return $this->response->setJSON($query);
    }
}
