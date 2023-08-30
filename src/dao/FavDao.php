<?php 

declare(strict_types=1);

namespace src\dao;

use src\core\DBConnection;
use src\exceptions\FavDaoException;
use stdClass;

/**
 * Class FavDao 
 *
 * @package src\dao
 */
final class FavDao extends BaseDao
{
    /**
     * FavDao constructor
     *
     * @param ?string $favTable
     */
    public function __construct(?string $favTable = null) {
        parent::__construct(
            $favTable ?? $_ENV["DB_TABLE_FAV"],
            DBConnection::getConnection()
        );
    } 

    /**
     * Validate Fav URL pattern
     *
     * @param string $favUrl
     * @return array|null
     */
    private function validateFavUrl(string $favUrl): ?array 
    {
        $pattern = "/^(https*:\/\/(www\.)*)([a-zA-Z0-9\-]+)/";
        $match = preg_match($pattern, $favUrl, $matches);

        if ($match) {
            return $matches;
        } else {
            return null;
        }
    }

    /**
     * Get a fav by it's id
     *
     * @param int $favId
     */
    public function getFavById(int $favId): object 
    {
        $fav = $this->readDataBy("WHERE fav_id=:fav_id", "fav_id={$favId}");

        // If didn't find any fav with ID
        if (!$fav) {
            throw new FavDaoException("Could not find a Fav with id {$favId}.");
        }

        $favSimpleName = end($this->validateFavUrl($fav->fav_url));
        $fav->simple_name = $favSimpleName;

        return $fav;
    }

    /**
     * Create new fav
     *
     * @param string $favUrl
     * @param int $userId
     * @return bool
     */
    public function createNewFav(string $favUrl, int $userId): bool 
    {
        // Check if fav URL is empty
        if (empty($favUrl)) {
            throw new FavDaoException("Fav URL cannot be empty.");
        }

        // Check if fav URL is valid
        if (!$this->validateFavUrl($favUrl)) {
            throw new FavDaoException("Invalid URL.");
        }

        // Mount fav data array
        $newFavData = [
            "fav_url" => $favUrl,
            "user_id" => $userId
        ];

        $result = $this->createData($newFavData);

        // Failed to create new fav in database
        if (!is_string($result)) {
            throw new FavDaoException("Failed to create new fav.");
        }

        return true;
    }
}
