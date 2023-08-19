<?php 

declare(strict_types=1);

namespace src\core;

/**
 * Trait ViewData
 */
trait ViewData
{
    /**
     * Mount a view data array to View::renderView
     *
     * @param string $view
     * @param string $title
     * @param string $viewStyle
     * @param string $viewScript
     * @return array
     */
    public function createViewData(
        string $view,
        string $title,
        string $viewStyle,
        string $viewScript
    ): array {
        return [
            "view" => $view,
            "pageData" => [
                "title" => $title,
                "viewStyle" => $viewStyle,
                "viewScript" => $viewScript
            ]
        ];
    }
}

/**
 * Class BaseController
 * 
 * @package src\core
 */
abstract class BaseController 
{
    // Use ViewData trait
    use ViewData;
}
