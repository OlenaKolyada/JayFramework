<?php

namespace App\Controller;

class NewsItemAction
{
    public function __invoke($id)
    {
        echo "I have only one news! You're fake news says Trump : " . $id;
    }
}
