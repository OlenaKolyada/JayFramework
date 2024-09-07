<?php

namespace App\Controller;

use App\Http\Response;

/**
 * Class IndexAction
 *
 * @package App\Controller
 * @author Jérémy GUERIBA
 */
class IndexAction extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->view->render('index.html.php'); // Возвращается объект Response
    }
}
