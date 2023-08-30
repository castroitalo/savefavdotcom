<?php 

declare(strict_types=1);

namespace src\exceptions;

use Exception;

/**
 * Class FavDaoExceptiono
 *
 * @package src\exception
 */
final class FavDaoException extends Exception
{
    /**
     * FavDaoException constructor
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(string $message, int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

