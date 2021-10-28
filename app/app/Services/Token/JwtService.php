<?php

namespace App\Services\Token;

use App\Exceptions\Exceptions;
use Firebase\JWT\JWT;
use App\Services\Contracts\TokenInterface;

class JwtService implements TokenInterface {
    protected $algorithm;
    protected $secret_key;
    protected $payload = [];


    /**
     * __construct
     *
     * @return void
     */
    public function __construct(){
        $secret_key = config("jwt.secret_key");

        $options = [
            'expire' => '+60 minutes',
            'serverName' => 'Laravel',
            'serverUrl' => "http://localhost:8080",
            'algorithm' => 'HS512'
        ];

        $issuedAt   = new \DateTimeImmutable();
        $expire = $issuedAt->modify($options["expire"])->getTimestamp();
        $serverName = $options['serverName'];
        $serverUrl = $options['serverUrl'];
        $this->algorithm = $options['algorithm'];
        $this->secret_key = $secret_key;

        $this->payload = array(
            "iss" => $serverName, // строка, содержащая имя или идентификатор эмитента. Может быть доменным именем и может использоваться для удаления токенов из других приложений.
            "aud" => $serverUrl,
            "iat" => $issuedAt->getTimestamp(), // метка времени выпуска токена.
            "nbf" => $issuedAt->getTimestamp(), // отметка времени, когда токен должен считаться действительным. Должно быть равно или больше iat.
            "exp" => $expire, // отметка времени, когда токен должен перестать быть действительным. Должно быть больше iatи nbf.
        );
    }

    public function decode($token) {
        list($header, $payload, $signature) = explode (".", $token);
        $json = base64_decode($payload);
        return json_decode($json);
    }

    public function validate($token) {
        $payload = null;

        try {
            $payload = JWT::decode($token, $this->secret_key, [$this->algorithm]);
        } catch (\UnexpectedValueException $th) {
            throw new Exceptions(Exceptions::TOKEN_FAILED);
        }
        return $payload;
    }

    public function generate(array $payload) {
        return JWT::encode(
            array_merge(
                $payload,
                $this->payload //TODO: update expire date
            ),
            $this->secret_key,
            $this->algorithm
        );
    }

    public function setOptions($options) {
        $options_result = array_replace([
            'expire' => '+60 minutes',
            'serverName' => 'Laravel',
            'serverUrl' => "http://localhost:8080",
            'algorithm' => 'HS512'
        ], $options);

        $issuedAt   = new \DateTimeImmutable();
        $expire = $issuedAt->modify($options_result["expire"])->getTimestamp();
        $serverName = $options_result['serverName'];
        $serverUrl = $options_result['serverUrl'];
        $this->algorithm = $options_result['algorithm'];

        $this->payload = array(
            "iss" => $serverName, // строка, содержащая имя или идентификатор эмитента. Может быть доменным именем и может использоваться для удаления токенов из других приложений.
            "aud" => $serverUrl,
            "iat" => $issuedAt->getTimestamp(), // метка времени выпуска токена.
            "nbf" => $issuedAt->getTimestamp(), // отметка времени, когда токен должен считаться действительным. Должно быть равно или больше iat.
            "exp" => $expire, // отметка времени, когда токен должен перестать быть действительным. Должно быть больше iatи nbf.
        );
    }

    public function setSecret($secretKey) {
        $this->secret_key = $secretKey;
    }
}
