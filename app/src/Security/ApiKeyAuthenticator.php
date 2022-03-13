<?php

namespace App\Security;

use App\Entity\User;
use App\Model\Error;
use App\Response\ErrorCode;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class ApiKeyAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var string
     */
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function supports(Request $request): bool
    {
        return $request->headers->has('API-KEY');
    }

    public function getCredentials(Request $request): array
    {
        return [
            'apiKey' => $request->headers->get('API-KEY')
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider): User
    {
        return new User();
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return $this->apiKey === $credentials['apiKey'];
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return new JsonResponse(new Error(ErrorCode::ERROR_AUTHENTICATION, 'API key not valid!'), Response::HTTP_UNAUTHORIZED);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // todo
    }

    public function start(Request $request, AuthenticationException $authException = null): JsonResponse
    {
        $data = array(
            // you might translate this message
            'message' => 'Authentication Required'
        );

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe(): bool
    {
        return false;
    }
}
