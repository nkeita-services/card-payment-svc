<?php


namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use CoderCat\JWKToPEM\JWKConverter;
use Infrastructure\Api\Consumer\Authorization\OpenID\Client;

class OAuth2ClientCredentials
{

    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \CoderCat\JWKToPEM\Exception\Base64DecodeException
     * @throws \CoderCat\JWKToPEM\Exception\JWKConverterException
     */
    public function handle(Request $request, Closure $next)
    {
        $authorizationHeader = $request->header('Authorization');
        if (Str::startsWith($authorizationHeader, 'Bearer ')) {
            $accessToken = Str::substr($authorizationHeader, 7);

            $jwks = file_get_contents(sprintf(
                'https://cognito-idp.%s.amazonaws.com/%s/.well-known/jwks.json',
                'eu-west-1',
                'eu-west-1_2sIO5d6AL'
            ));

            $decodedJWKS = json_decode($jwks, true);
            $jwkConverter = new JWKConverter();

            $keySet = [
                $decodedJWKS['keys'][0]['kid'] => $jwkConverter->toPEM($decodedJWKS['keys'][0]),
                $decodedJWKS['keys'][1]['kid'] => $jwkConverter->toPEM($decodedJWKS['keys'][1])
            ];

            try {
                $decodedAccessToken = JWT::decode(
                    $accessToken,
                    $keySet,
                    ['RS256']
                );
            } catch (\Exception $exception) {
                return response()->json(
                    [
                        'status' => 'failure',
                        'statusCode' => 0,
                        'statusDescription' => $exception->getMessage()
                    ],
                    401
                );
            }

            $client = Client::createFromAccessToken(
                $decodedAccessToken
            );

            if (!$client->hasScope(
                $request->route()[1]['as']
            )) {
                return response()->json(
                    [
                        'status' => 'failure',
                        'statusCode' => 0,
                        'statusDescription' => "You don't seem to have enough permissions to perform this action"
                    ],
                    401
                );
            }

            $request->merge(
                [
                    'ApiConsumer' => $client
                ]
            );

            return $next($request);
        }

        return response()->json(
            [
                'status' => 'failure',
                'statusCode' => 0,
                'statusDescription' => 'Unauthorized'
            ],
            401
        );

    }
}
