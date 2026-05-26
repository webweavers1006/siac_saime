<?php

namespace App\Controllers;

use App\Models\LineaEstrategica;
use App\Models\Auditoria_sistema_Model;

class LineaEstrategica_Controller extends BaseController
{
    public function vista_linea_estrategica()
    {
        if ($this->session->get('logged')) {
            echo view('template/header');
            echo view('template/nav_bar');
            echo view('linea_estrategica/content.php');
            echo view('template/footer');
            echo view('linea_estrategica/footer.php');
        } else {
            return redirect()->to('/');
        }
    }

    public function listar_linea_estrategica()
    {
        $model = new LineaEstrategica();
        $rows = $model->listar_linea_estrategica();

        echo json_encode($rows);
    }

    public function add_linea_estrategica()
    {
        $model = new LineaEstrategica();
        $auditoria = new Auditoria_sistema_Model();

        if ($this->session->get('logged') && $this->request->isAJAX()) {
            $datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), true);
            $descripcion = trim($datos['descripcion'] ?? '');

            if ($descripcion === '') {
                return json_encode(2);
            }

            $insert = $model->add_linea_estrategica([
                'descripcion' => $descripcion,
                'borrado' => false
            ]);

            if (isset($insert)) {
                $auditoria->agregar([
                    'audi_user_id' => session('iduser'),
                    'audi_accion' => 'INGRESA LINEA ESTRATEGICA: ' . $descripcion,
                    'audi_fecha' => date('Y-m-d'),
                    'audi_hora' => date('h:i:s A')
                ]);
                return json_encode(1);
            }

            return json_encode(2);
        }

        return redirect()->to('/');
    }

    public function edit_linea_estrategica()
    {
        $model = new LineaEstrategica();
        $auditoria = new Auditoria_sistema_Model();

        if ($this->session->get('logged') && $this->request->isAJAX()) {
            $datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), true);

            $id = (int) ($datos['id'] ?? 0);
            $descripcion = trim($datos['descripcion'] ?? '');
            $borrado = (bool) ($datos['borrado'] ?? false);

            if ($id <= 0 || $descripcion === '') {
                return json_encode(2);
            }

            $update = $model->edit_linea_estrategica([
                'id' => $id,
                'descripcion' => $descripcion,
                'borrado' => $borrado
            ]);

            if (isset($update)) {
                $auditoria->agregar([
                    'audi_user_id' => session('iduser'),
                    'audi_accion' => 'ACTUALIZA LINEA ESTRATEGICA ID: ' . $id . ' DESC: ' . $descripcion,
                    'audi_fecha' => date('Y-m-d'),
                    'audi_hora' => date('h:i:s A')
                ]);
                return json_encode(1);
            }

            return json_encode(2);
        }

        return redirect()->to('/');
    }

    public function delete_linea_estrategica()
    {
        $model = new LineaEstrategica();
        $auditoria = new Auditoria_sistema_Model();

        if ($this->session->get('logged') && $this->request->isAJAX()) {
            $datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), true);
            $id = (int) ($datos['id'] ?? 0);

            if ($id <= 0) {
                return json_encode(2);
            }

            $res = $model->eliminar_logica(['id' => $id]);

            if (isset($res)) {
                $auditoria->agregar([
                    'audi_user_id' => session('iduser'),
                    'audi_accion' => 'ELIMINA LOGICAMENTE LINEA ESTRATEGICA ID: ' . $id,
                    'audi_fecha' => date('Y-m-d'),
                    'audi_hora' => date('h:i:s A')
                ]);
                return json_encode(1);
            }

            return json_encode(2);
        }

        return redirect()->to('/');
    }
}

