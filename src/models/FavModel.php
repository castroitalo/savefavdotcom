<?php 

declare(strict_types=1);

namespace src\models;

use src\dao\FavDao;
use src\exceptions\FavDaoException;

/**
 * Class FavModel
 * 
 * @package src\models
 */
final class FavModel
{
    /**
     * FavDao for database operations
     *
     * @var FavDao 
     */
    private FavDao $favDao;

    public function __construct()
    {
        $this->favDao = new FavDao();
    }

    /**
     * Create new fav 
     *
     * @param string $favUrl
     * @param int $userId
     * @return true|string
     */
    public function createFav(string $favUrl, int $userId): true|string 
    {
        try {
            $newFav = $this->favDao->createNewFav($favUrl, $userId);

            return $newFav;
        } catch (FavDaoException $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Get user's fav
     *
     * @param int $userId
     * @return array|string
     */
    public function getAllUserFav(int $userId): array|string 
    {
        $allFav = $this->favDao->getAllFav($userId);

        if (empty($allFav)) {
            return "You don't have any fav yet.";
        }

        return $allFav;
    }

    /**
     * Delete fav
     *
     * @param int $favId
     * @return true|string
     */
    public function deleteFav(int $favId): true|string 
    {
        try {
            $deleted = $this->favDao->deleteFav($favId);

            return $deleted;
        } catch (FavDaoException $ex) {
            return $ex->getMessage();
        }
    }
}
