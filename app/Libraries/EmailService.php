<?php
namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * EmailService — Wrapper reutilizable para envío de correos con PHPMailer.
 *
 * Lee la configuración SMTP desde app/Config/Email.php (que a su vez
 * obtiene los valores de las variables de entorno smtp.* en .env).
 *
 * Uso:
 *   $email = new EmailService();
 *   $email->send('destino@mail.com', 'Asunto', '<p>HTML body</p>');
 */
class EmailService
{
	protected $host;
	protected $port;
	protected $user;
	protected $pass;
	protected $from;
	protected $fromName;

	public function __construct()
	{
		$config = config('Email');

		$this->host     = $config->SMTPHost;
		$this->port     = $config->SMTPPort;
		$this->user     = $config->SMTPUser;
		$this->pass     = $config->SMTPPass;
		$this->from     = $config->fromEmail;
		$this->fromName = $config->fromName;
	}

	/**
	 * Enviar un correo.
	 *
	 * @param string $to      Dirección de destino
	 * @param string $subject Asunto
	 * @param string $body    Cuerpo HTML
	 * @param array  $attachments  Archivos adjuntos (rutas absolutas)
	 * @return bool
	 * @throws Exception
	 */
	public function send(string $to, string $subject, string $body, array $attachments = []): bool
	{
		if (empty($to)) {
			return false;
		}

		$mail = new PHPMailer(true);

		// SMTP config
		$mail->isSMTP();
		$mail->Host       = $this->host;
		$mail->Port       = $this->port;
		$mail->SMTPAuth   = true;
		$mail->Username   = $this->user;
		$mail->Password   = $this->pass;
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

		// SSL options (entorno local/dev con certificados auto-firmados)
		$mail->SMTPOptions = [
			'ssl' => [
				'verify_peer'       => false,
				'verify_peer_name'  => false,
				'allow_self_signed' => true,
			],
		];

		// Remitente y destinatario
		$mail->setFrom($this->from, $this->fromName);
		$mail->addAddress($to);
		$mail->CharSet = 'UTF-8';

		// Contenido
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body    = $body;
		$mail->AltBody = strip_tags($body);

		// Adjuntos
		foreach ($attachments as $attachment) {
			if (file_exists($attachment)) {
				$mail->addAttachment($attachment);
			}
		}

		return $mail->send();
	}
}
