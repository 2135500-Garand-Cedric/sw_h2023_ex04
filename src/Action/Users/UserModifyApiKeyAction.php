<?php

namespace App\Action\Users;

use App\Domain\User\Service\UserView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserModifyApiKeyAction
{
    private $userView;

    public function __construct(UserView $userView)
    {
        $this->userView = $userView;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $valeurAuth = $request->getHeaderLine('Authorization');
        $token = explode(' ', $valeurAuth)[1];
        $decodedToken = base64_decode($token);
        $codeUsager = explode(' ', $decodedToken)[0] ?? '';
        $motDePasse = explode(' ', $decodedToken)[1] ?? '';

        $resultat = $this->userView->getNewApiKey($codeUsager, $motDePasse);

        $code = 200;
        if ($resultat['reponse'] == "Code d'utilisateur ou mot de passe invalide") {
            $code = 403;
        }
        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($resultat));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}
