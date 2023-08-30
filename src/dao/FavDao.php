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
     * Get simple Fav URL
     *
     * @param stdClass $fav
     * @return string 
     */
    public function getFavSimpleName(stdClass $fav): string
    {
        $pattern = "/^(https*:\/\/www\.)([a-zA-Z0-9\-]+)/";
        $match = preg_match($pattern, $fav->fav_url, $matches);

        if ($match) {
            return $matches[2];
        } else {
            return "";
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

        $fav->simple_name = $this->getFavSimpleName($fav);

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

