<?php

namespace App\Controllers;

use Model\User;
use \App\Services\EmailService;
use \App\Services\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    private $emailService;
    private $userService;

    public function __construct(EmailService $emailService, UserService $userService)
    {
        $this->emailService = $emailService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->getAllUsers($request);
        return $this->response($users, Response::HTTP_OK);
    }

    public function show(Request $request, $id)
    {
        return $this->response($this->userService->findByID($id), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        if ([$user, $email, $id ] = $this->userService->store($request)) {
            $this->emailService->send($user, $email, $id);
        }
        return $this->response(['status' => true], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        return $this->response($this->userService->update($request), Response::HTTP_OK);
    }

    public function destroy(Request $request, $id)
    {
        return $this->response($this->userService->destroy($id), Response::HTTP_OK);
    }
}
