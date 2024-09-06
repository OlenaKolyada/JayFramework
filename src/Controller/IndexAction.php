<?php

namespace App\Controller;

/**
 * Class IndexAction
 *
 * @package App\Controller
 * @author Jérémy GUERIBA
 */
class IndexAction extends AbstractController
{
    public function __invoke(): \App\Http\Response
    {
        return $this->view->render('index.html.php');
    }
}
