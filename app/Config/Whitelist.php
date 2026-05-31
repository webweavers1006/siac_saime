<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Whitelist de acceso al sistema.
 *
 * Dominios e IPs autorizados para acceder a la aplicación.
 * Se pueden agregar entradas adicionales desde el archivo .env
 * usando las variables WHITELIST_EXTRA_HOSTS y WHITELIST_EXTRA_IPS
 * (separadas por comas).
 */
class Whitelist extends BaseConfig
{
	/**
	 * Dominios autorizados.
	 *
	 * @var array
	 */
	public $hosts = [
		'siac_v2.com',
		'siac.sapi.gob.ve',
		'atencion.sapi.gob.ve',
		'desarrollo-siac.sapi.gob.ve',
	];

	/**
	 * IPs autorizadas.
	 *
	 * @var array
	 */
	public $ips = [
		'172.16.0.39',
		'186.167.8.181',
		'172.16.0.186',
		'172.16.0.135',
		'172.26.112.1',
		'10.100.2.89',
		'172.16.0.51',
	];

	/**
	 * Constructor: fusiona entradas adicionales desde .env
	 */
	public function __construct()
	{
		parent::__construct();

		// Cargar hosts extra desde .env (opcional)
		$extraHosts = env('whitelist.extra_hosts', '');
		if (! empty($extraHosts)) {
			$this->hosts = array_merge(
				$this->hosts,
				array_map('trim', explode(',', $extraHosts))
			);
		}

		// Cargar IPs extra desde .env (opcional)
		$extraIPs = env('whitelist.extra_ips', '');
		if (! empty($extraIPs)) {
			$this->ips = array_merge(
				$this->ips,
				array_map('trim', explode(',', $extraIPs))
			);
		}
	}
}
