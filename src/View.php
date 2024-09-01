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
        string $templateName,
        array $params = [],
        int $statusCode = Response::HTTP_OK,
        string $contentType = Response::CONTENT_TYPE_HTML
    ): Response
    {
        extract($params);
        include self::TEMPLATE_BASE_PATH . $templateName;
        $content = ob_get_contents();

        return new Response($content, $statusCode, $contentType);
    }
}
