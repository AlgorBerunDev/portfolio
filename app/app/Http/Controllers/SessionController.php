<?php

namespace App\Http\Controllers;

use App\Http\Resources\SessionResource;
use App\Repository\Contracts\SessionRepositoryInterface;
use App\Services\Contracts\SessionInterface;
use Illuminate\Http\Request;
use App\Exceptions\TokenFailed;
use App\Exceptions\TokenExpired;
use App\Http\Requests\SessionUpdateRequest;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

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
        $refreshSession = $this->sessionService->refresh();
        return new SessionResource($refreshSession);
    }
    public function logout() {
        $result = $this->sessionService->remove();
        return $result;
    }
    public function update(SessionUpdateRequest $request) {
        $result = $this->sessionService->updateCurrent($request->all());
        return $result;
    }

}
