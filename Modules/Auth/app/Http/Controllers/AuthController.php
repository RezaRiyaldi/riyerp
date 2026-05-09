<?php

namespace Modules\Auth\Http\Controllers;

use App\Base\BaseController;
use Illuminate\Http\Request;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Services\AuthService;

class AuthController extends BaseController
{
    protected AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request) {
        $result = $this->authService->login(
            $request->only('email', 'password'),
            $request->boolean('remember'));

        return $this->success($result, 'Login successful.');
    }

    public function register(RegisterRequest $request) {
        $result = $this->authService->register($request->validated());

        return $this->success($result, 'Registration successful.');
    }

    public function logout(Request $request) {
        $this->authService->logout($request->user());

        return $this->success(null, 'Logout successful.');
    }

    public function me(Request $request) {
        $user = $this->authService->me()?->load('roles', 'permissions');

        return $this->success([
            'user' => $user,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('auth::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('auth::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
