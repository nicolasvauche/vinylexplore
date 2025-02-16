<?php

namespace App\Service\Match;

use App\Entity\User;
use App\Repository\Hub\AlbumRepository;
use App\Service\Match\Context\ContextService;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class SuggestService
{
    public function __construct(private AlbumRepository     $albumRepository,
                                private ContextService      $contextService,
                                private HttpClientInterface $client,
                                private string              $apiKey)
    {
    }

    /**
     * @throws \DateInvalidTimeZoneException
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \DateMalformedStringException
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function suggest(User $user)
    {
        $albums = $this->albumRepository->findAlbumsForUser($user);
        $context = $this->contextService->getContext($user);
        $context['location'] = $context['location']['name'] ?? null;

        $data = [
            'context' => $context,
            'albums' => $albums,
        ];

        try {
            $response = $this->client->request(
                'POST',
                'http://localhost:8000/recommend',
                [
                    'json' => $data,
                    'timeout' => 5,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                ]
            );

            $suggestion = $response->toArray();

            if($suggestion['id']) {
                return $this->albumRepository->find($suggestion['id']);
            }
        } catch(\Exception $e) {
            throw new \RuntimeException('Erreur lors de la communication avec l’API de recommandation : ' . $e->getMessage());
        }
    }
}
