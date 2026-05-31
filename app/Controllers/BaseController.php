<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
	/**
	 * Instance of the main Request object.
	 *
	 * @var CLIRequest|IncomingRequest
	 */
	protected $request;

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */


		protected $whitelist = 
		[
			'siac_v2.com', 
			'siac.sapi.gob.ve', 
			'atencion.sapi.gob.ve', 
			'172.16.0.39', 
			'186.167.8.181', 
			'172.16.0.186',
			'172.16.0.135',
			'172.26.112.1',
			'10.100.2.89',
			'desarrollo-siac.sapi.gob.ve', 
			'172.16.0.51',
			'salasituacional.test',
			'127.0.0.1',
			'localhost',
		];
	
		public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
		{
			// No editar esta línea
			parent::initController($request, $response, $logger);
	
			// Precargar cualquier modelo, biblioteca, etc., aquí.
			$this->session = \Config\Services::session();
			$this->cache   = \Config\Services::cache();
	
			// Verificar el origen de la solicitud
			$this->checkOrigin();
		}
	
		protected function checkOrigin()
		{
			$http_host = $_SERVER['HTTP_HOST'] ?? '';
			$remote_addr = $_SERVER['REMOTE_ADDR'] ?? '';
		
			// Verificar si el HTTP_HOST está en la whitelist
			$host_autorizado = in_array($http_host, $this->whitelist);
			
			// Verificar si la IP del cliente está en la whitelist
			$ip_autorizada = in_array($remote_addr, $this->whitelist);
		
			// Permitir acceso si cumple al menos una condición
			if (!$host_autorizado && !$ip_autorizada) {
				exit('Acceso no autorizado');
			}
		}

	/*Funcion que formatea fechas*/
	public function formatearFecha($fecha)
	{
		$date1 = explode('-', $fecha);
		$date2 = $date1[2] . "-" . $date1[1] . "-" . $date1[0];
		return $date2;
	}
	/**
	 * Metodo que permite generar tablas debidamente formateadas
	 * usando Bootstrap4
	 * 
	 *
	 * @param heading : Array  => Arreglo con las cabeceras del usuario
	 * @param data    : Array   => Los datos de la tabla puestos en un arreglo de arreglos
	 * 
	 */
}
