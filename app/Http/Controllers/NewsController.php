<?php

namespace App\Http\Controllers;

use App\Helpers\Constants;
use App\Services\Model\Menu;
use App\Services\Model\NewsEntity;
use App\Services\NewsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    private NewsService $service;

    public function __construct(NewsService $service)
    {
        $this->service = $service;
    }

    public function updateNewsById(Request $request, int $id): RedirectResponse
    {
        $image = $request->file('image') ?? null;
        $title = $request->input('title') ?? null;
        $content = $request->input('content') ?? null;
        $creatorId = $request->session()->get(Constants::$KEY_USER_ID) ?? null;

        $dest = redirect('/?menu=' . Menu::BERITA->value);

        if (!$id || !is_numeric($id)) {
            return $dest;
        }

        if (!$title || !$content) {
            return $dest->with(
                [
                    'message' => [
                        'error' => 'Judul dan isi tidak boleh kosong.',
                    ],
                ]
            );
        }

        if ($image && !$image->getSize()) {
            return $dest->with(
                [
                    'message' => [
                        'error' => 'Ukuran gambar tidak boleh lebih dari 2 mb.',
                    ],
                ]
            );
        }

        if (!$creatorId) {
            return redirect('/login');
        }

        $newsAppEntity = $this->service->getNewsById($id);
        if (!$newsAppEntity->isStatus()) {
            return $dest->with(
                [
                    'message' => [
                        'error' => 'Gagal mengubah berita.',
                    ],
                ]
            );
        }

        $imageUrl = $newsAppEntity->getData()->getImageUrl();
        $imagePath = $imageUrl;

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

        if (!$appEntity->isStatus()) {
            return $dest->with(
                [
                    'message' => [
                        'error' => 'Gagal mengubah berita.',
                    ],
                ]
            );
        }

        return $dest->with(
            [
                'message' => [
                    'success' => 'Berhasil mengubah berita.',
                ],
            ]
        );
    }

    public function createNews(Request $request): RedirectResponse
    {
        $image = $request->file('image') ?? null;
        $title = $request->input('title') ?? null;
        $content = $request->input('content') ?? null;
        $creatorId = $request->session()->get(Constants::$KEY_USER_ID) ?? null;

        $dest = redirect('/?menu=' . Menu::BERITA->value);

        if (!$title || !$content) {
            return $dest->with(
                [
                    'message' => [
                        'error' => 'Judul dan isi tidak boleh kosong.',
                    ],
                ]
            );
        }

        if (!$creatorId) {
            return redirect('/login');
        }

        if ($image && !$image->getSize()) {
            return $dest->with(
                [
                    'message' => [
                        'error' => 'Ukuran gambar tidak boleh lebih dari 2 mb.',
                    ],
                ]
            );
        }

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
            imageUrl: $imagePath,
        );

        $appEntity = $this->service->createNews($newsEntity);

        if (!$appEntity->isStatus()) {
            return $dest->with(
                [
                    'message' => [
                        'error' => 'Gagal membuat berita.',
                    ],
                ]
            );
        }

        return $dest->with(
            [
                'message' => [
                    'success' => 'Berhasil membuat berita.',
                ],
            ]
        );
    }

    public function showNewsById(Request $request, int $id): RedirectResponse
    {
        $isEdit = $request->input('isEdit') ?? false;
        $dest = redirect('/?menu=' . Menu::BERITA->value);

        $isEdit = (bool)$isEdit;

        if (!$id || !is_numeric($id)) {
            return $dest;
        }

        $appEntity = $this->service->getNewsById($id);

        if (!$appEntity->isStatus()) {
            return $dest;
        }

        $news = $appEntity->getData();

        return $dest->with(
            [
                'newsValue' => $news,
                'isEdit' => $isEdit,
            ]);
    }

    public function deleteNewsById(int $id): RedirectResponse
    {
        $dest = redirect('/?menu=' . Menu::BERITA->value);

        if (!$id || !is_numeric($id)) {
            return $dest;
        }

        $appEntity = $this->service->deleteNewsById($id);

        if (!$appEntity->isStatus()) {
            return $dest->with(
                [
                    'message' =>
                        [
                            'error' => 'Gagal menghapus berita.',
                        ]
                ]
            );
        }

        return $dest->with(
            [
                'message' =>
                    [
                        'success' => 'Berhasil menghapus data',
                    ]
            ]);
    }
}
