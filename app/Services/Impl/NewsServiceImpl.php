<?php

namespace App\Services\Impl;

use App\Models\News;
use App\Services\Model\AppEntity;
use App\Services\Model\NewsEntity;
use App\Services\NewsService;
use App\Services\UserService;

class NewsServiceImpl implements NewsService
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getNews(?int $page)
    {
        $news = News::latest()->paginate(perPage: 5, page: $page);
        $news->getCollection()->transform(function ($new) {
            return NewsEntity::fromNews($new);
        });
        return $news;
    }

    public function getNewsById(?int $id): AppEntity
    {
        $news = $this->newsById($id);

        if (!$news) {
            return AppEntity::error('Berita dengan id ' . $id . ' tidak ditemukan.');
        }

        $newsEntity = NewsEntity::fromNews($news);

        return AppEntity::success('Berhasil mendapatkan data.', $newsEntity);
    }

    public function updateNews(NewsEntity $newsEntity): AppEntity
    {
        $userId = $newsEntity->getCreatorId();

        $userAppEntity = $this->userService->getUserById($userId);

        if (!$userAppEntity->isStatus()) {
            return $userAppEntity;
        }

        $newsId = $newsEntity->getId();

        $news = $this->newsById($newsId);

        if (!$news) {
            return AppEntity::error('Berita dengan id ' . $newsId . ' tidak ditemukan.');
        }

        $news->update([
            'title' => $newsEntity->getTitle(),
            'content' => $newsEntity->getContent(),
            'image_url' => $newsEntity->getImageUrl(),
            'creator_id' => $userId,
            'updated_at' => now(),
        ]);

        $newNewsEntity = NewsEntity::fromNews($news);

        return AppEntity::success('Berhasil mengubah berita.', $newNewsEntity);
    }

    public function createNews(NewsEntity $newsEntity): AppEntity
    {
        $userId = $newsEntity->getCreatorId();

        $userAppEntity = $this->userService->getUserById($userId);

        if (!$userAppEntity->isStatus()) {
            return $userAppEntity;
        }

        $news = News::create([
            'title' => $newsEntity->getTitle(),
            'content' => $newsEntity->getContent(),
            'image_url' => $newsEntity->getImageUrl(),
            'creator_id' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $newsEntity = NewsEntity::fromNews($news);

        return AppEntity::success('Berhasil membuat berita.', $newsEntity);
    }

    public function deleteNewsById(?int $id): AppEntity
    {
        $news = $this->newsById($id);

        if (!$news) {
            return AppEntity::error('Berita dengan id ' . $id . ' tidak ditemukan.');
        }

        $news->delete();

        return AppEntity::success('Berhasil menghapus berita dengan id ' . $id . '.', null);
    }

    private function newsById(?int $id): ?News
    {
        $news = News::query()
            ->where('id', $id)
            ->first();

        return $news;
    }
}
