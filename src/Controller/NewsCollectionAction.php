<?php

namespace App\Controller;

use App\Repository\NewsRepository;

class NewsCollectionAction
{
    public function __invoke()
    {
        $repository = new NewsRepository();
        $newsCollection = $repository->findAll();

        var_dump($newsCollection);
    }
}
