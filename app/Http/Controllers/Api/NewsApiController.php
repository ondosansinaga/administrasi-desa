<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Http\Resources\AppPagingResource;
use App\Http\Resources\AppResource;
use App\Http\Resources\NewsDataResource;
use App\Http\Resources\NewsResource;
use App\Services\Model\NewsEntity;
use App\Services\NewsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsApiController extends Controller
{

    private NewsService $service;

    public function __construct(NewsService $service)
    {
        $this->service = $service;
    }

    public function getNews(Request $request): JsonResponse
    {
        $page = $request->query('page', 1);

        $newsPagination = $this->service->getNews($page);

        $data = new NewsResource($newsPagination);

        $res = new AppPagingResource(
            $newsPagination,
            'Berhasil mendapatkan data.',
            true,
            $data
        );

        return ($res)
            ->response()
            ->setStatusCode(200);
    }

    public function getNewsById(int $id): JsonResponse
    {
        $checkNewsId = $this->checkNewsId($id);
        if ($checkNewsId) {
            return $checkNewsId;
        }

        $appEntity = $this->service->getNewsById($id);

        $res = $appEntity->getData();
        if ($res) {
            $res = new NewsDataResource($res);
        }

        return (new AppResource(
            $res,
            $appEntity->getMessage(),
            $appEntity->isStatus(),
        ))->response()->setStatusCode(200);
    }

    public function deleteNewsById($id): JsonResponse
    {
        $checkNewsId = $this->checkNewsId($id);
        if ($checkNewsId) {
            return $checkNewsId;
        }

        $appEntity = $this->service->deleteNewsById($id);

        return (new AppResource(
            null,
            $appEntity->getMessage(),
            $appEntity->isStatus(),
        ))->response()->setStatusCode(200);
    }

    public function createNews(NewsRequest $request): JsonResponse
    {
        $data = $request->validated();

        $title = $data['title'] ?? null;
        $content = $data['content'] ?? null;
        $creatorId = $data['creatorId'] ?? null;
        $image = $data['image'] ?? null;

        $imagePath = null;

        if ($image) {
            $imageName = time() . '.' . 'png';

            $image->storeAs('public/images/news', $imageName);
            $imagePath = $imageName;
        }

        $newsEntity = new NewsEntity(
            title: $title,
            content: $content,
            creatorId: $creatorId,
            imageUrl: $imagePath
        );

        $appEntity = $this->service->createNews($newsEntity);

        return (new AppResource(
            null,
            $appEntity->getMessage(),
            $appEntity->isStatus(),
        ))->response()->setStatusCode(200);
    }

    public function updateNews(NewsRequest $request, int $id): JsonResponse
    {
        $checkNewsId = $this->checkNewsId($id);
        if ($checkNewsId) {
            return $checkNewsId;
        }

        $data = $request->validated();

        $title = $data['title'] ?? null;
        $content = $data['content'] ?? null;
        $creatorId = $data['creatorId'] ?? null;
        $image = $data['image'] ?? null;

        $newsAppEntity = $this->service->getNewsById($id);
        if (!$newsAppEntity->isStatus()) {
            return (new AppResource(
                null,
                $newsAppEntity->getMessage(),
                $newsAppEntity->isStatus(),
            ))->response()->setStatusCode(200);
        }

        $imageUrl = $newsAppEntity->getData()->getImageUrl();
        $imagePath = null;

        if ($image) {
            $imageName = time() . '.' . 'png';
            if ($imageUrl) {
                $imageName = $imageUrl;
            }

            $image->storeAs('public/images/news', $imageName);
            $imagePath = $imageName;
        }

        $newsEntity = new NewsEntity(
            id: $id,
            title: $title,
            content: $content,
            creatorId: $creatorId,
            imageUrl: $imagePath
        );

        $appEntity = $this->service->updateNews($newsEntity);

        return (new AppResource(
            null,
            $appEntity->getMessage(),
            $appEntity->isStatus(),
        ))->response()->setStatusCode(200);
    }

    private function checkNewsId(?int $id): ?JsonResponse
    {
        if (!$id) {
            return (new AppResource(
                null,
                'Id berita tidak boleh kosong.',
                false,
            ))->response()->setStatusCode(200);
        }

        if (!is_numeric($id)) {
            return (new AppResource(
                null,
                'Id berita harus berupa angka.',
                false,
            ))->response()->setStatusCode(200);
        }

        return null;
    }

}
