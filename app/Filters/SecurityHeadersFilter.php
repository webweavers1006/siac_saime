<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SecurityHeadersFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
       // Definir las cabeceras de seguridad
       // header('Content-Security-Policy: default-src \'self\''); NO ME FUNCIONAN LOS SCRIPT
         header('X-Content-Type-Options: nosniff');
         header('X-Frame-Options: DENY'); // INFRAME
         header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
         header('Referrer-Policy: no-referrer');//https
         header('X-XSS-Protection: 1; mode=block');
         header('Cross-Origin-Opener-Policy: same-origin');
        /*  same-origin: Esta política indica que la página solo puede interactuar con otras páginas que tengan el mismo origen 
         (es decir, el mismo protocolo, dominio y puerto).
          Esto significa que si una página intenta abrir o comunicarse con una página de un origen diferente, se bloquearán esas interacciones. */
        
        header('Cross-Origin-Embedder-Policy: require-corp');
        header('Cross-Origin-Resource-Policy: same-origin');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $response;
    }
}