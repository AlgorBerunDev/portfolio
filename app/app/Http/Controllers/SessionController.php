<?php

namespace App\Http\Controllers;

use App\Exceptions\Exceptions;
use App\Http\Resources\SessionResource;
use App\Repository\Contracts\SessionRepositoryInterface;
use App\Services\Contracts\SessionInterface;
use App\Http\Requests\SessionUpdateRequest;
use Exception;
use App\Exceptions\RenderableException;
use App\Http\Resources\SessionUpdateResource;

class SessionController extends Controller
{
    private $sessionService;
    private $sessionRepository;

    public function __construct(SessionInterface $sessionService, SessionRepositoryInterface $sessionRepository)
    {
        $this->sessionService = $sessionService;
        $this->sessionRepository = $sessionRepository;
    }

    public function create() {
        $model = $this->sessionService->create();
        return new SessionResource($model);
    }
    public function refresh() {
        $refreshSession = null;
        try {
            $refreshSession = $this->sessionService->refresh();

        } catch (Exception $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => $th->getCode()
            ],400);
        }
        return new SessionResource($refreshSession);
    }
    public function logout() {
        $this->sessionService->remove();
        return response()->json([
            'message' => "Successfully logout",
            'code' => 0
        ]);
    }
    public function update(SessionUpdateRequest $request) {
        return new SessionUpdateResource($this->sessionService->updateCurrent($request->validated()));
    }

}
