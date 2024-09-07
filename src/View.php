<?php

namespace App;

use App\Http\Response;

/**
 * Class View
 *
 * @package App
 * @author Jérémy GUERIBA
 */
class View
{
    public const string TEMPLATE_BASE_PATH = Kernel::APP_ROOT_DIR
        . DIRECTORY_SEPARATOR
        . 'templates'
        . DIRECTORY_SEPARATOR;

    public function render(
        /** template path from template folder */
        string $templateName,
        /** params used in given template. It must be an associative array */
        array $params = [],
        /** Response status code if we need to override it */
        int $statusCode = Response::HTTP_OK,
        /** Response content type if we need to override it */
        string $contentType = Response::CONTENT_TYPE_HTML
    ): Response
    {
        // For each key in the array, create a variable where its name is the key and the value the associated value to the key
        extract($params);
        // Print template in buffer
        include self::TEMPLATE_BASE_PATH . $templateName;
        // Get buffer content. Means everything that has been print from app launch until here
        $content = ob_get_contents();

        //Create and return the response object
        return new Response($content, $statusCode, $contentType);
    }
}
