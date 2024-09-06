<?php

namespace App\Repository;

use App\Model\News;
use App\Repository\Exception\IdIsStringException;
use App\Repository\Exception\ItemNotFoundException;

class NewsRepository extends AbstractRepository
{
    //here is data we have, can be fetch from database, so consider it as an example
    private array $data = [
        10 => [
            'id' => 10,
            'title' => 'Fake News!',
            'content' => "Trump says you're fake news!",
        ],
        5 => [
            'id' => 5,
            'title' => 'Big News!',
            'content' => "Jay says you're big news!",
        ],
        42 => [
            'id' => 42,
            'title' => 'THE News!',
            'content' => "You can't miss it!",
        ],
    ];
    public function findAll(): array
    {
        $result = [];

        foreach ($this->data as $item) {
            $news = new News();
            $news->setId($item['id']);
            $news->setTitle($item['title']);
            $news->setContent($item['content']);
            $result[] = $news;
        }

        return $result;
    }

    /**
     * @throws ItemNotFoundException
     */
    public function findOneById(int $id): News
    {
//        if (is_string($id)) {
//            throw new IdIsStringException("Id is a string");
//        }
        $result = $this->data[$id] ?? null;

        if ($result === null) {
            throw new ItemNotFoundException("Item not found in database");
        }

        $news = new News();
        $news->setId($result['id']);
        $news->setTitle($result['title']);
        $news->setContent($result['content']);

        return $news;
    }
}
