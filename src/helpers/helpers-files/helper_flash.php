<?php 

declare(strict_types=1);

use src\core\FlashMessage;

/**
 * Render flash message from session 
 *
 * @param string $session_key
 * @param string $flash_type
 * @return void 
 */
function render_flash_message(string $session_key, string $flash_type): void 
{
    $message = get_session_key_value($session_key);

    delete_session_key($session_key);
    echo (new FlashMessage())->getFlashMessage($message, $flash_type);
}

