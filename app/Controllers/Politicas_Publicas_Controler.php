<?php

namespace App\Controllers;

use App\Models\Casos;
use App\Models\Ubi_Admini_Model;


class Politicas_Publicas_Controler extends BaseController
{
    // AJAX: listar operadores por direccion administrativa (para filtro Operador)
    public function listar_operadores_politicas_publicas()
    {
        $direccion = $this->request->getGet('direccion_administrativa') ?? $this->request->getVar('direccion_administrativa');

        $usuariosModel = new \App\Models\Usuarios();
        $query = $usuariosModel->getAllUsers_filtro_Pliticas_Publicas($direccion);

        // Si el frontend pide JSON, retornamos arreglo plano
        $data = [];
        foreach ($query->getResult() as $row) {
            $data[] = [
                'id' => (string)$row->idusuopr,
                'nombre' => trim(($row->usuopnom ?? '') . ' ' . ($row->usuopape ?? '')),
            ];
        }

        return $this->response->setJSON($data);
    }

    public function vista_politicas_publicas()
    {

        if ($this->session->get('logged')) {

            $direccionesModel = new Ubi_Admini_Model();

            unset($query);
            $query = $direccionesModel->listar_direcciones_administrativas();

            $direccionesopt = '';
            if (isset($query)) {
                foreach ($query->getResult() as $row) {
                    $direccionesopt .= '<option value="' . $row->id . '">' . htmlentities($row->descripcion) . '</option>';
                }
            } else {
                $direccionesopt .= '<option value="NULL">Sin estatus</option>';
            }

            $data["direcciones"] = $direccionesopt;

            echo view('template/header');
            echo view('template/nav_bar');
            echo view('reportes/politicas_publicas/content.php', $data);
            echo view('template/footer');
            echo view('reportes/politicas_publicas/footer.php');
        } else {
            return redirect()->to('/');
        }
    }

    // Endpoint DataTables serverSide (mismo dataset/columnas que consolidado)
    public function reporte_politicas_publicas()
    {
        $request = $this->request;

        $params = [
            'draw' => $request->getVar('draw') ?? null,
            'start' => $request->getVar('start') ?? 0,
            'length' => $request->getVar('length') ?? 10,
            'search' => $request->getVar('search')['value'] ?? null,
            'order' => $request->getVar('order') ?? [],
            'desde' => $request->getVar('desde') ?? null,
            'hasta' => $request->getVar('hasta') ?? null,
            'tipo_pi' => $request->getVar('tipo_pi') ?? null,
            'tipo_atencion_usu' => $request->getVar('tipo_atencion_usu') ?? null,
            'sexo' => $request->getVar('sexo') ?? null,
            'via_atencion' => $request->getVar('via_atencion') ?? null,
            'direcciones_caso' => $request->getVar('direcciones_caso') ?? null,
            'direccion_administrativa' => $request->getVar('direccion_administrativa') ?? null,
            'usuarios' => $request->getVar('usuarios') ?? null,
            'tipo_beneficiario' => $request->getVar('tipo_beneficiario') ?? null,

            'atencion_cuidadano' => $request->getVar('atencion_cuidadano') ?? null,
            'estatus' => $request->getVar('estatus') ?? null,
            'id_pais' => $request->getVar('id_pais') ?? null,
            'id_estado' => $request->getVar('id_estado') ?? null,
            'id_municipio' => $request->getVar('id_municipio') ?? null,
            'id_parroquia' => $request->getVar('id_parroquia') ?? null,
            'edad_min' => $request->getVar('edad_min') ?? null,
            'edad_max' => $request->getVar('edad_max') ?? null,
            'detalle_atencion' => $request->getVar('detalle_atencion') ?? null,
            'org_id' => $request->getVar('org_id') ?? null,
        ];

        // Mapa índice de columna -> alias SQL (igual que consolidado)
        $columns = [
            'a.idcaso',
            'a.casofec',
            'nombre',
            'b.estnom',
            't_antusu.tipo_aten_nombre',
            'tpinte.tipo_prop_nombre',
            't_bene.tipo_beneficiario_nombre',
            'a.sexo',
        ];

        if (isset($params['order'][0]['column'])) {
            $order_index = $params['order'][0]['column'];
            if (isset($columns[$order_index])) {
                $params['order_column'] = $columns[$order_index];
                $params['order_direction'] = $params['order'][0]['dir'];
            } else {
                $params['order_column'] = 'a.idcaso';
                $params['order_direction'] = 'DESC';
            }
        } else {
            $params['order_column'] = 'a.idcaso';
            $params['order_direction'] = 'DESC';
        }

        $model = new Casos();
        // Dataset específico para Políticas Públicas
        $data = $model->getReporteData_Politicas_Publicas($params);


        $output = [
            "draw" => $params['draw'],
            "recordsTotal" => $data['recordsTotal'],
            "recordsFiltered" => $data['recordsFiltered'],
            "data" => $data['data'],
        ];

        return $this->response->setJSON($output);
    }
}

