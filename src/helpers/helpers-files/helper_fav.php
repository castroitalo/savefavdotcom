<?php 

declare(strict_types=1);

use src\dao\FavDao;

/**
 * Get fav's simple name
 *
 * @param string $fav_url
 * @return string
 */
function get_fav_simple_name(string $fav_url): string 
{
    $matches = (new FavDao())->validateFavUrl($fav_url);

    return end($matches);
}
