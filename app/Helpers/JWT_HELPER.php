<?php

use App\Models\ModelUsers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * @throws Exception
 */
function getJWT($authHeader)
{
    if (is_null($authHeader)){
        throw new Exception("Authentication JWT failed");
    }
    return explode(" ", $authHeader)[1];
}

function validateJWT($encodedToken)
{
    $key = getenv('JWT_SECRET_KEY');
    $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));
    $modelUsers = new ModelUsers();
    $modelUsers->get_email($decodedToken->email);
}

function createJWT($email): string
{
    $timeRequest = time();
    $timeToken = getenv('JWT_TIME_TO_LIVE');
    $timeExpired = $timeRequest + $timeToken;
    $payload = [
        'email' => $email,
        'iat' => $timeRequest,
        'exp' => $timeExpired,
    ];
    return JWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS256');
}
