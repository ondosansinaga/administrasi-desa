<?php

namespace App\Http\Controllers;

use App\Helpers\Constants;
use App\Services\LetterService;
use App\Services\Model\Menu;
use App\Services\NewsService;
use App\Services\RequestLetterService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\WargaService;
use App\Models\DataWarga;

class DashboardController extends Controller
{
    private UserService $userService;
    private NewsService $newsService;
    private RequestLetterService $reqLetterService;
    private LetterService $letterService;
    private WargaService $wargaService;

    public function __construct(
        UserService          $userService,
        NewsService          $newsService,
        RequestLetterService $reqLetterService,
        LetterService        $letterService,
        WargaService         $wargaService,
    )
    {
        $this->userService = $userService;
        $this->newsService = $newsService;
        $this->reqLetterService = $reqLetterService;
        $this->letterService = $letterService;
        $this->wargaService = $wargaService;
    }

    public function index(Request $request): Response|RedirectResponse
    {
        $userId = $request->session()->get(Constants::$KEY_USER_ID);
        $menu = $request->query('menu') ?? Menu::BERITA->value;
        $page = $request->query('page') ?? 1;

        $appEntity = $this->userService->getUserById($userId);

        if (!$appEntity->isStatus()) {
            return redirect('login')->with(
                [
                    'title' => 'Login',
                    'errorGlobalMessage' => 'Sesi anda telah habis. Silahkan login kembali.',
                ]
            );
        }

        $userEntity = $appEntity->getData();

        $menu = Menu::from($menu);

        $data = null;
        switch ($menu) {
            case Menu::BERITA:
                $data = $this->getNews($page);
                break;
            case Menu::WARGA:
                $data = $this->getWarga($page);
                break;
            case Menu::USERS:
                $data = $this->getUsers($page);
                break;
            case Menu::PENGAJUAN:
                $data = $this->getRequestLetters($page);
                break;
            case Menu::PROFILE:
                $data = $this->getProfile($userId);
                break;
        }

        return response()->view('dashboard', [
            'appName' => 'Aplikasi Administrasi Desa Ringin Sari',
            'user' => $userEntity,
            'activeMenu' => $menu,
            'data' => $data,
            'menus' => Menu::cases()
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget(Constants::$KEY_USER_ID);

        return redirect('/login')->with(
            [
                'title' => 'Login',
                'username' => '',
                'password' => '',
            ]
        );
    }

    private function getNews(int $page)
    {
        return $this->newsService->getNews($page);
    }

    private function getUsers(int $page)
    {
        return $this->userService->getUsers($page);
    }

    private function getRequestLetters(int $page)
    {
        return $this->reqLetterService->getRequestLetters($page);
    }

    private function getProfile(int $id)
    {
        return $this->userService->getUserById($id)->getData();
    }

    private function getWarga(int $page)
    {
        return $this->wargaService->getWarga($page);
    }


}
