<?php
namespace App\Services\Session;

use App\Exceptions\Unauthorized;
use App\Http\Resources\SessionResource;
use App\Services\Contracts\TokenInterface;
use App\Services\Contracts\SessionInterface;
use App\Repository\Contracts\SessionRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

use function PHPSTORM_META\type;

class SessionService implements SessionInterface {
    private $tokenService;
    private $sessionRepository;
    private $request;

    public function __construct(TokenInterface $tokenService, SessionRepositoryInterface $sessionRepository, Request $request)
    {
        $this->tokenService = $tokenService;
        $this->tokenService->setOptions(['expire' => config("jwt.access_expired")]);
        $this->refreshService = $tokenService;
        $this->refreshService->setOptions(['expire' => config("jwt.refresh_expired")]);
        $this->sessionRepository = $sessionRepository;
        $this->request = $request;
    }
    public function getId($token = null) {
        if($token) {
            $payloadObject = $this->tokenService->decode($token);
            return $payloadObject->id;
        }

        $jwt = $this->getToken();
        if(!$jwt) {
            throw new Exception("Not finded authorization token");
        }
        $payloadObject = $this->tokenService->decode($jwt);
        return $payloadObject->id;
    }
    public function create() {
        $attributes = [
            'device' => $this->request->userAgent(),
            'ip' => $this->request->ip()
        ];

        $model = $this->sessionRepository->create($attributes);

        $payload = [
            'id' => $model->id
        ];

        $access_token = $this->tokenService->generate($payload);
        $refresh_token = $this->refreshService->generate($payload);

        $this->sessionRepository->updateById($payload['id'], [
            'access_token' => $access_token,
            'refresh_token' => $refresh_token
        ]);

        return $this->sessionRepository->findById($payload['id']);
    }

    public function validate($token = null){
        if(!$token) {
            if(!$this->getToken()) throw new Unauthorized();
            return $this->tokenService->validate($this->getToken());
        }
        return $this->tokenService->validate($token);
    }

    public function validateRefreshToken($token = null){
        if(!$token) {
            if(!$this->getToken()) throw new Unauthorized();
            return $this->refreshService->validate($this->getToken());
        }
        return $this->refreshService->validate($token);
    }

    public function setFcmToken(string $fcmToken)
    {
        $token = $this->getToken();
        $id = $this->getId($token);
        return $this->sessionRepository->updateById($id, ['fcmToken' => $fcmToken]);
    }

    public function getFcmToken(int $session_id = null)
    {
        $id = $session_id;
        if(!$id) {
            $token = $this->getToken();
            if($token) return null;
            $id = $this->getId($token);
        }

        $model = $this->sessionRepository->findById($id, ['fcmToken']);
        return $model->fcmToken;
    }

    public function getToken(): ?string {
        $bearer = $this->request->header("Authorization");
        if(!$bearer) return null;
        $token = $this->splitBearer($bearer);
        return $token;
    }

    protected function splitBearer(string $bearer): string
    {
        //TODO: validate for bearer token
        list($auth_type, $token) = explode(" ", $bearer);
        return $token;
    }

    public function refresh($token = null){
        if(!$token && !$this->getToken()) {
            throw new Unauthorized();
        }

        $payloadObject = $token? $this->validateRefreshToken($token) : $this->validateRefreshToken();
        $payload = (array) $payloadObject;
        $this->access_token =$this->tokenService->generate($payload);
        $this->refresh_token =$this->refreshService->generate($payload);
        $model = $this->sessionRepository->updateById($payload['id'], [
            'access_token' => $this->access_token,
            'refresh_token' => $this->refresh_token,
        ]);
        return $model;
    }
    public function remove($token = null){
        if(!$token && !$this->getToken()) {
            throw new Unauthorized();
        }
        $payloadObject = $token? $this->validateRefreshToken($token) : $this->validateRefreshToken($this->getToken());
        $result = $this->sessionRepository->deleteById($payloadObject->id);
        return $result;
    }
    public function updateById(int $id, array $payload)
    {
        return $this->sessionRepository->updateById($id, $payload);
    }
    public function updateCurrent(array $payload)
    {
        return $this->updateById($this->getId(), $payload);
    }
}
