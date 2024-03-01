<?php

namespace App\Http\Controllers;

use App\Helpers\Constants;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    private UserService $service;
    private RoleService $roleService;

    public function __construct(
        UserService $service,
        RoleService $roleService,
    )
    {
        $this->service = $service;
        $this->roleService = $roleService;
    }

    public function index(): Response
    {
        return response()->view('login', [
            'title' => 'Login',
            'username' => '',
            'password' => '',
        ]);
    }

    public function login(Request $request): Response|RedirectResponse
    {
        $username = $request->input('username') ?? null;
        $password = $request->input('password') ?? null;

        $errors = [];

        if (!$username) {
            $errors['username'] = 'Username tidak boleh kosong.';
        }

        if (!$password) {
            $errors['password'] = 'Password tidak boleh kosong.';
        }

        if (!empty($errors)) {
            return response()->view(
                'login',
                [
                    'title' => 'Login',
                    'username' => $username,
                    'password' => $password,
                    'errorMessage' => $errors,
                ]
            );
        }

        $appEntity = $this->service->login($username, $password);

        if (!$appEntity->isStatus()) {
            $message = $appEntity->getMessage();
            return response()->view(
                'login',
                [
                    'title' => 'Login',
                    'username' => $username,
                    'password' => $password,
                    'errorGlobalMessage' => $message,
                ]
            );
        }

        $userId = $appEntity->getData()->getId();

        $isAdmin = $this->roleService->isAdmin($userId);

        if(!$isAdmin) {
            return redirect('/login')->with([
                'errorGlobalMessage' => 'Hanya admin yang boleh masuk.'
            ]);
        }

        $request->session()->put(Constants::$KEY_USER_ID, $userId);

        return redirect('/');
    }

}
