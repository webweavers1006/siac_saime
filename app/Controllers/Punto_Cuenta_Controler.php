<?php

namespace App\Controllers;

use App\Models\Auditoria_sistema_Model;
use App\Models\Categoria_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Punto_Cuenta_Model;
use CodeIgniter\RESTful\ResourceController;

class Punto_Cuenta_Controler extends BaseController
{
	use ResponseTrait;

	//Metodo que muestra la vista de los tipos de direcciones
	public function vista_Punto_Cuenta()
	{
		if ($this->session->get('logged')) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('punto_de_cuenta/content.php');
			echo view('template/footer');
			echo view('punto_de_cuenta/footer_punto_cuenta.php');
		} else {
			return redirect()->to('/');
		}
	}

	
	public function Listar_Punto_Cuenta()
	{
		$model = new Punto_Cuenta_Model();
		$query = $model->Listar_Punto_Cuenta();
		if (empty($query)) {
			$punto = [];
		} else {
			$punto = $query;
		}
		echo json_encode($punto);
	}


	//Metodo para añadir tipo de atencion
	public function add_Punto_Cuenta()
{

    $model = new Punto_Cuenta_Model(); 
    $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
    if ($this->session->get('logged') && $this->request->isAJAX()) {
        $datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
        $punto_cuenta = [
            'numero_punto_cuenta' => $datos["numero_punto_cuenta"],
            'fecha_punto_cuenta'  => $datos["fecha_punto_cuenta"],
            'nombre'              => $datos["nombre"],
            'apellido'            => $datos["apellido"],
            'monto_aprobado'      => $datos["monto_aprobado"],
            'causa_beneficio'     => $datos["causa_beneficio"],
        ];
        $query_insertar_punto_cuenta = $model->agregar($punto_cuenta);
        
        if ($query_insertar_punto_cuenta) {
            $auditoria['audi_user_id'] = session('iduser');
            // Descripción de la auditoría clara
            $auditoria['audi_accion']  = 'INGRESO EL PUNTO DE CUENTA CON NÚMERO: ' . 
                                         '(' . $punto_cuenta["numero_punto_cuenta"] . ') para el beneficiario: ' . 
                                         $punto_cuenta["nombre"] . ' ' . $punto_cuenta["apellido"];
            
            $model_Auditoria_sistema_Model->agregar($auditoria);
            $mensaje = 1; // Éxito
            return json_encode($mensaje);
        } else {
            $mensaje = 2; // Error de inserción
            return json_encode($mensaje);
        }
    } else {
        // Si no está logueado o no es AJAX
        return redirect()->to('/');
    }
}
 // Método para asociar un caso a punto de cuenta
  
    public function asociar_casos()
{
    // 1. Inicialización de Modelos y Respuesta
    $puntoCuentaModel = new \App\Models\Punto_Cuenta_Model(); 
    $auditoriaModel = new \App\Models\Auditoria_sistema_Model(); 
    $respuesta = ['success' => false, 'message' => '']; 
    
    // 2. Comprobación de seguridad/AJAX
    if (!$this->session->get('logged') || !$this->request->isAJAX()) {
         $respuesta['message'] = 'Acceso no autorizado o sesión caducada.';
         // Devuelve 401: Unauthorized
         return $this->response->setJSON($respuesta)->setStatusCode(401); 
    }
    
    // 3. Obtener y validar datos de entrada
    $id_punto_cuenta = (int)$this->request->getPost('id_punto_cuenta');
    $id_caso = (int)$this->request->getPost('id_caso');
    
    if (empty($id_punto_cuenta) || empty($id_caso)) {
        $respuesta['message'] = 'Faltan IDs en la solicitud.';
        return $this->response->setJSON($respuesta);
    }
    
    try {
        // 4. Verificar si el caso ya está asociado
        $existe = $puntoCuentaModel->verificar_caso_existente($id_punto_cuenta, $id_caso);

        if ($existe) {
            // Ya existe
            $respuesta['message'] = 'El Caso ID: ' . $id_caso . ' ya está asociado a este Punto de Cuenta.';
            
        } else {
            // 5. Asociar nuevo caso
            $datosAsociacion = [
                'id_punto_cuenta' => $id_punto_cuenta,
                'id_caso' => $id_caso,
            ];
            
            $insertado = $puntoCuentaModel->asociar_nuevo_caso($datosAsociacion);

            if ($insertado) { 
                
                // Lógica de Auditoría
                $descripcion = "Caso ID: $id_caso asociado al Punto de Cuenta ID: $id_punto_cuenta.";
                $auditoriaModel->agregar([
                    'audi_user_id'  => $this->session->get('iduser'), // Corregido: 'iduser' no 'id_usuario'
                    'audi_accion' => $descripcion,
                ]);

                 $respuesta['success'] = true;
                 $respuesta['message'] = 'Caso ID: ' . $id_caso . ' asociado correctamente.';

            } else {
                // Falla en la inserción
                $respuesta['message'] = 'Error de base de datos al asociar el caso.';
            }
        }
    } catch (\Exception $e) {
        // Capturar cualquier excepción y loguear
        log_message('error', 'Error en asociar_casos: ' . $e->getMessage());
        $respuesta['message'] = 'Error del servidor: ' . $e->getMessage();
        return $this->response->setJSON($respuesta)->setStatusCode(500);
    }
    
    // 6. Devolver la respuesta como JSON
    return $this->response->setJSON($respuesta);

}

 // $query_insertar_punto_cuenta = $model->agregar($punto_cuenta);
        
        // if ($query_insertar_punto_cuenta) {
        //     $auditoria['audi_user_id'] = session('iduser');
        //     // Descripción de la auditoría clara
        //     $auditoria['audi_accion']  = 'INGRESO EL PUNTO DE CUENTA CON NÚMERO: ' . 
        //                                  '(' . $punto_cuenta["numero_punto_cuenta"] . ') para el beneficiario: ' . 
        //                                  $punto_cuenta["nombre"] . ' ' . $punto_cuenta["apellido"];
            
        //     $model_Auditoria_sistema_Model->agregar($auditoria);
        //     $mensaje = 1; // Éxito
        //     return json_encode($mensaje);
        // } else {
        //     $mensaje = 2; // Error de inserción
        //     return json_encode($mensaje);
        // }


	//Metodo para editar Punto de Cuenta
	public function edit_Punto_Cuenta()
{
    $model = new Punto_Cuenta_Model(); 
    $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
    if ($this->session->get('logged') && $this->request->isAJAX()) {
        $datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
        $punto_cuenta = [
            'id'                  => $datos["id"], 
            'numero_punto_cuenta' => $datos["numero_punto_cuenta"],
            'fecha_punto_cuenta'  => $datos["fecha_punto_cuenta"],
            'nombre'              => $datos["nombre"],
            'apellido'            => $datos["apellido"],
            'monto_aprobado'      => $datos["monto_aprobado"],
            'causa_beneficio'     => $datos["causa_beneficio"],
            'borrado'             => ($datos["borrado"] === 'true') ? true : false, // Convertir 'true'/'false' a booleano real si tu DB lo requiere
        ];
        
        $registro_id = $punto_cuenta['id'];
        $query_editar_punto_cuenta = $model->update_p_cuenta($registro_id, $punto_cuenta);
        if ($query_editar_punto_cuenta !== false) {
            $auditoria['audi_user_id'] = session('iduser');
            $auditoria['audi_accion']  = 'EL PUNTO DE CUENTA CON ID: ' . $punto_cuenta["id"] . 
                                         ' y NÚMERO: ' . $punto_cuenta["numero_punto_cuenta"] . 
                                         ' FUE ACTUALIZADO.';
            
            $model_Auditoria_sistema_Model->agregar($auditoria);
            
            $mensaje = 1; // Éxito
            return json_encode($mensaje);
        } else {
            $mensaje = 2; // Error de actualización o no se encontró el registro
            return json_encode($mensaje);
        }
    } else {
        // Si no está logueado o no es AJAX
        return redirect()->to('/');
    }
}


	public function cargarCasosAsociados($id_punto_cuenta=null)
	{
        
		$model = new Punto_Cuenta_Model();
		$query = $model->cargarCasosAsociados($id_punto_cuenta);
		if (empty($query)) {
			$casos_asociados = [];
		} else {
			$casos_asociados = $query;
		}
		echo json_encode($casos_asociados);
	}



	public function verificar_caso($inputnuevocaso=null)
	{
        
		$model = new Punto_Cuenta_Model();
		$query = $model->verificar_caso($inputnuevocaso);
		if (empty($query)) {
			$informacion = [];
		} else {
			$informacion = $query;
		}
		echo json_encode($informacion);
	}


	public function verificar_caso_punto_cuenta()
	{
        $datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
		$idcaso = $datos['idcaso'] ?? null;
        $model = new Punto_Cuenta_Model();
		$query = $model->verificar_caso_punto_cuenta($idcaso);
		if (empty($query)) {
			$punto = [];
		} else {
			$punto = $query;
		}
		echo json_encode($punto);
	}




// Método para subir archivos
public function upload_docu_punto_cuenta()
{
    // Carga el modelo (asumo que está correctamente configurado)
    $model = new Punto_Cuenta_Model();
    $id_punto_cuenta = $_POST['id_punto_cuenta'] ?? '';
    $archivo = $_FILES['archivo'] ?? null;

    // Si el ID no está presente, es un error crítico
    if (empty($id_punto_cuenta)) {
        return json_encode(11); // Nuevo código: ID de punto de cuenta faltante.
    }

    // LISTA BLANCA de extensiones
    $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|ods|xls|xlsx|mp4|mp3|m4a|m4v|mov|wmv|avi|mkv|swf|odt';
    $tamañoMaximo = 10 * 1024 * 1024; // 10MB en bytes

    // Verificar si se ha subido un archivo
    if ($archivo && $archivo["name"] != '' && $archivo["error"] == UPLOAD_ERR_OK) 
    {
        $nombreBase = strtolower($id_punto_cuenta . '_' . basename($archivo['name']));
        $nombreArchivo = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $nombreBase);
        $archivoTemporal = $archivo['tmp_name'];
        $targetDir = PUNTO_CUENTA_PATH; 

        
        // Esto previene que se guarden archivos en el directorio padre si la constante está mal definida
        $targetDir = rtrim($targetDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR; 
        $rutaDestino = $targetDir . $nombreArchivo; 
        $targetFile = $rutaDestino; 

        // ⚠️ 3. VERIFICAR Y CREAR EL DIRECTORIO SI NO EXISTE
        if (!is_dir($targetDir)) {
            // Usar error_reporting(0) en lugar de @ para un manejo de errores más limpio
            if (!mkdir($targetDir, 0777, true) && !is_dir($targetDir)) {
                // Devolvemos el código 10: Error al crear el directorio
                return json_encode(10); 
            }
        }
   
        // Comprobar si hay extensiones dobles o nombre de archivo sospechoso (ej. 'file.php.jpg')
        $partesArchivo = explode('.', $nombreArchivo);
        $extensionesPermitidas = explode('|', $config['allowed_types']);

        // 4. OBTENER Y VALIDAR LA EXTENSIÓN
        // Obtener la extensión del archivo (siempre la última parte)
        $fileType = strtolower(end($partesArchivo));
        
        // Si el archivo tiene más de dos partes, generalmente es 'nombre.ext1.ext2'
    if (count($partesArchivo) > 2) {
        // Devolvemos el código 8: Nombre de archivo inválido / Doble extensión
        return json_encode(8); 
    }

        // Verificar si el archivo tiene una extensión permitida
        if (!in_array($fileType, $extensionesPermitidas)) {
            return json_encode(5); // Tipo de archivo no permitido
        }

        // Verificar el tamaño del archivo
        if ($archivo["size"] > $tamañoMaximo) {
            return json_encode(1); // Archivo demasiado grande
        }

        // 5. VERIFICAR TIPO MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        // Usamos el archivo temporal que es el contenido real
        $mimeType = finfo_file($finfo, $archivoTemporal);
        finfo_close($finfo);

        $mimeTypes = [
            'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png',
            'pdf' => 'application/pdf', 
            'doc' => ['application/msword', 'application/vnd.ms-office'], 
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet', 
            'xls' => ['application/vnd.ms-excel', 'application/excel', 'application/msexcel'],
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'mp4' => 'video/mp4', 'mp3' => 'audio/mpeg',
            'm4a' => ['audio/mp4', 'audio/m4a'], 'm4v' => 'video/mp4', 
            'mov' => 'video/quicktime', 'wmv' => 'video/x-ms-wmv',
            'avi' => 'video/x-msvideo', 'mkv' => 'video/x-matroska',
            'swf' => 'application/x-shockwave-flash',
            'odt' => 'application/vnd.oasis.opendocument.text', 
        ];

        $expectedMime = $mimeTypes[$fileType] ?? null;

        if ($expectedMime === null) {
             return json_encode(6); // La extensión no tiene un MIME type esperado
        }
        
        // Verificación robusta de MIME type
        $mime_match = false;
        if (is_array($expectedMime)) {
            if (in_array($mimeType, $expectedMime)) {
                $mime_match = true;
            }
        } elseif (is_string($expectedMime)) {
            if ($expectedMime === $mimeType) {
                $mime_match = true;
            }
        }

        if (!$mime_match) {
            return json_encode(6); // Tipo de archivo no coincide con el contenido
        }
        
        // 6. OTRAS VERIFICACIONES DE SEGURIDAD
        // Verificar si el archivo ya existe (se puede modificar para sobrescribir)
        if (file_exists($targetFile)) {
            return json_encode(0); // El archivo ya existe
        }

        // Verificar contenido para imágenes (Asegura que no sea un script disfrazado)
        if (in_array($fileType, ['jpg', 'jpeg', 'png'])) {
            $img = @imagecreatefromstring(file_get_contents($archivoTemporal));
            if (!$img) {
                return json_encode(9); // El archivo no es una imagen válida
            }
            // Liberar memoria
            if ($img) imagedestroy($img);
        }

        // 7. MOVER EL ARCHIVO
        if (move_uploaded_file($archivoTemporal, $rutaDestino)) {
            $documentos_punto['docu_id_punto_cuenta'] = $id_punto_cuenta;
            // Guardar solo el nombre del archivo, ya que la ruta base la conoce la aplicación
            $documentos_punto['docu_ruta'] = $nombreArchivo; 

            // Intentar agregar la información del documento a la base de datos
            $query_docu_casos = $model->agregar_docu_punto_cuenta($documentos_punto);
            
            // Verificar si la consulta fue exitosa
            if ($query_docu_casos) {
                return json_encode(2); // Archivo subido y registrado en la base de datos
            } else {
                // 8. LIMPIEZA: Si falla la DB, eliminar el archivo subido
                if (file_exists($rutaDestino)) {
                    @unlink($rutaDestino); 
                }
                return json_encode(7); // Error al agregar a la base de datos
            }
        } else {
            // Este error puede deberse a permisos (chmod) en la carpeta de destino
            return json_encode(3); // Error al subir el archivo (falla move_uploaded_file)
        }
    } else {
        // Manejar errores de subida de PHP (ej. tamaño excedido por límite de PHP)
        if ($archivo && $archivo['error'] != UPLOAD_ERR_NO_FILE) {
             // Archivo subido, pero con error (ej. tamaño > post_max_size o upload_max_filesize de PHP.ini)
             return json_encode(12); // Nuevo código: Error de subida interno de PHP
        }
        return json_encode(4); // No se subió ningún archivo
    }
}

// Metodo para obtener documentos_puntos
public function buscar_documentos_punto()
{
   
    $model_docu_punto = new Punto_Cuenta_Model(); 
    $opt = '';
    
    if ($this->request->isAJAX() && $this->session->get('logged')) {
        
        $postData = $this->request->getPost('data');
        if (!$postData) {
             return $this->respond(["message" => "Datos de solicitud faltantes o incorrectos"], 400);
        }
        $datos = json_decode(base64_decode($postData), TRUE);
        if (!isset($datos['id'])) {
             return $this->respond(["message" => "ID del punto de cuenta no proporcionado"], 400);
        }

        $query = $model_docu_punto->buscar_documentos_por_punto($datos["id"]); // <-- Nombre del método corregido en el modelo

        if ($query && count($query) > 0) { // Verifica que el resultado no sea nulo y que tenga filas
            $opt .= '<option value="0" selected disabled>Seleccione un documento</option>';
            
            // Asume que $query ahora es un array de objetos o array de arrays, no un objeto Result
            foreach ($query as $row) {
                // Asegúrate de que 'docu_ruta' es lo que quieres mostrar
                // Y 'docu_id_punto_cuenta' es el valor del option
                $opt .= '<option value="' . esc($row->docu_id_punto_cuenta) . '">' . esc(ucfirst(strtolower($row->docu_ruta))) . '</option>';
            }
            
            // 4. Respuesta exitosa
            return $this->respond(["message" => "success", "data" => $opt], 200);
        } else {
            // 5. Respuesta si no se encuentran documentos
             $opt = '<option value="0" selected disabled>No hay documentos asociados</option>';
            
        }
    } else {
        // 6. Si no es AJAX o no está loggeado
        // Si no quieres redirigir, puedes responder con un error para la solicitud AJAX.
        return $this->respond(["message" => "Acceso no autorizado"], 403);
    }
}



}