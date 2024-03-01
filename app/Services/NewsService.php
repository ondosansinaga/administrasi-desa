<?php

namespace App\Services;

use App\Services\Model\AppEntity;
use App\Services\Model\NewsEntity;

interface NewsService
{
    public function getNews(?int $page);

    public function getNewsById(?int $id): AppEntity;

    public function updateNews(NewsEntity $newsEntity): AppEntity;

    public function createNews(NewsEntity $newsEntity): AppEntity;

    public function deleteNewsById(?int $id): AppEntity;
}
