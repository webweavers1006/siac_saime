<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Obtener el origen de la solicitud (frontend)
        $origin = $request->getHeaderLine('Origin');

        // Orígenes permitidos institucionales
        $allowedOrigins = [
            'https://atencion.sapi.gob.ve',
            'https://siac.sapi.gob.ve',
            'http://localhost:3000', // Por si desarrollas en React/Vue localmente
        ];

        // Si el origen está en nuestra lista, lo autorizamos dinámicamente
        if (in_array($origin, $allowedOrigins, true)) {
            header("Access-Control-Allow-Origin: " . $origin);
        } else {
            // Fallback por defecto seguro si no viene cabecera Origin (petición directa)
            header("Access-Control-Allow-Origin: https://atencion.sapi.gob.ve");
        }

        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Credentials: true");

        // Responder inmediatamente a las peticiones de prueba OPTIONS (Preflight) sin pasar al controlador
        if ($request->getMethod() === 'options') {
            header("HTTP/1.1 200 OK");
            exit();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se requiere lógica posterior
    }
}