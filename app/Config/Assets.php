<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Configuración centralizada de recursos gráficos del sistema.
 *
 * Todas las rutas de logos, cintillos, favicons e imágenes
 * se definen aquí. Para cambiarlos solo hay que modificar
 * este archivo o sobrescribir desde .env
 */
class Assets extends BaseConfig
{
	/**
	 * Ruta base de imágenes (relativa a public/).
	 * @var string
	 */
	public $imgPath = 'img/';

	/**
	 * Logo SAPI (login y emails).
	 * @var string
	 */
	public $logoSapi = 'img/saime_logo.png';

	/**
	 * Logo SIAC+SAPI (dashboard central).
	 * @var string
	 */
	public $logoSiacSapi = 'img/saime_logo.png';

	/**
	 * Favicon del sistema (pestaña del navegador).
	 * @var string
	 */
	public $logoFavicon = 'img/saime_logo.ico';

	/**
	 * Logo para correos electrónicos.
	 * @var string
	 */
	public $logoCorreo = 'img/saime_logo.png';

	/**
	 * Cintillo institucional (banner superior).
	 * @var string
	 */
	public $cintillo = 'img/cintillo_tradicional.png';

	/**
	 * Cintillo para PDFs.
	 * @var string
	 */
	public $cintilloPdf = 'img/cintillo_tradicional.png';

	/**
	 * Header para PDFs.
	 * @var string
	 */
	public $headerPdf = 'img/header.png';

	/**
	 * Bandera / mapa (menú lateral).
	 * @var string
	 */
	public $bandera = 'img/saime_logo.png';

	/**
	 * Logo del menú lateral (sidebar).
	 * @var string
	 */
	public $brandLogo = 'img/saime_logo.png';

	// ---------------------------------------------------------------
	// URLs COMPLETAS (con base_url)
	// ---------------------------------------------------------------

	/**
	 * Devuelve la URL completa de un recurso.
	 */
	public function url(string $asset): string
	{
		return base_url($asset);
	}
}
