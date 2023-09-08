<?php

declare(strict_types=1);

namespace src\core;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class Mailer
 * 
 * @package src\core
 */
final class Mailer
{
    /**
     * PHPMailer object 
     *
     * @var PHPMailer
     */
    private static PHPMailer $mailer;

    /**
     * Mailer constructor
     */
    public function __construct()
    {
        self::$mailer = new PHPMailer(true);

        // PHPMailer settings
        self::$mailer->isSMTP();
        self::$mailer->Host = $_ENV["EMAIL_HOST"];
        self::$mailer->SMTPAuth = true;
        self::$mailer->Port = $_ENV["EMAIL_PORT"];
        self::$mailer->Username = $_ENV["EMAIL_USERNAME"];
        self::$mailer->Password = $_ENV["EMAIL_PASSWORD"];
    }

    /**
     * Get template HTML from file and replace placeholders
     *
     * @param string $templateFilename
     * @param array|null $emailContent
     * @return string
     */
    public static function getEmailTemplate(
        string $templateFilename,
        ?array $emailContent = null
    ): string {
        $template = file_get_contents(CONF_VIEW_TEMPLATES . $templateFilename);

        if ($emailContent !== null) {
            foreach ($emailContent as $key => $value) {
                $template = str_replace($key, $value, $template);
            }
        }

        return $template;
    }

    /**
     * Send email to recipient
     *
     * @param string $recipientEmail
     * @param string $recipientName
     * @param string $subject
     * @param string $message
     * @param string $body
     * @return bool
     */
    public static function sendEmail(
        string $recipientEmail,
        string $recipientName,
        string $subject,
        string $message,
        string $body
    ): bool {
        self::$mailer->setFrom(CONF_MAILER_FROM, CONF_MAILER_NAME);
        self::$mailer->addAddress($recipientEmail, $recipientName);
        self::$mailer->isHTML(true);
        self::$mailer->Subject = $subject;
        self::$mailer->Body = $message;
        self::$mailer->AltBody = $body;

        return self::$mailer->send();
    }
}
