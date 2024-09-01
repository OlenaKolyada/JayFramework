<?php

namespace App\Controller;

use App\View;

/**
 * Class AbstractController
 *
 * @package App\Controller
 * @author Jérémy GUERIBA
 */
abstract class AbstractController
{
    public function __construct(protected View $view)
    {
    }
}
