<?php 

declare(strict_types=1);

namespace src\core;

/**
 * Class FlashMessage
 *
 * @package src\core
 */
final class FlashMessage 
{
    /**
     * Flash message content
     *
     * @var string $flashContent
     */
    private string $flashContent;

    /**
     * Flash message type (success, danger, warning, info)
     *
     * @var string $flashType
     */
    private string $flashType;

    /**
     * Get formatted flash message
     *
     * @return string
     */
    public function getFlashMessage(
        string $flashContent, 
        string $flashType
    ): string {
        return "<div class='alert alert-{$flashType} text-center' role='alert'>{$flashContent}</div>";
    }

    /**
     * Get flash content property value
     *
     * @return string 
     */
    public function getFlashContent(): string 
    {
        return $this->flashContent;
    }

    /**
     * Get flash type property value 
     *
     * @return string
     */
    public function getFlashType(): string 
    {
        return $this->flashType; 
    }
}

