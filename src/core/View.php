<?php

declare(strict_types=1);

namespace src\core;

use src\exceptions\ViewException;

/**
 * Class View
 * 
 * @package src\core
 */
final class View
{
    /**
     * Validate view data passed as parameters to View::renderView
     *
     * @param array $viewData
     * @return void
     */
    public static function validateViewData(array $viewData): void
    {
        // Check if $viewData has a 'view' key
        if (!isset($viewData["view"])) {
            throw new ViewException("View::renderView \$viewData parameter do not have a 'view' key");
        }

        // Check if $viewData view file exists
        if (!file_exists(CONF_VIEW_ROOT_PATH . $viewData["view"])) {
            throw new ViewException("View {$viewData["view"]} file do not exists");
        }

        // Check if view has a title
        if (!isset($viewData["pageData"]["title"])) {
            throw new ViewException("View's title is not set");
        }

        // Check if view's title is empty
        if (empty($viewData["pageData"]["title"])) {
            throw new ViewException("View's title is empty");
        }

        // Check if view's viewStyle key is set
        if (!isset($viewData["pageData"]["viewStyle"])) {
            throw new ViewException("View's style file is missing");
        }

        // Check if view's viewScript key is set
        if (!isset($viewData["pageData"]["viewScript"])) {
            throw new ViewException("View's script file is missing");
        }
    }

    /**
     * Render controller's view
     *
     * @param array $viewData
     * @return void
     */
    public static function renderView(array $viewData): void
    {
        self::validateViewData($viewData);

        // Converts $viewData to variables
        extract($viewData);

        include_once CONF_VIEW_HEADER;
        include_once CONF_VIEW_ROOT_PATH . $view;
        include_once CONF_VIEW_FOOTER;
    }
}
