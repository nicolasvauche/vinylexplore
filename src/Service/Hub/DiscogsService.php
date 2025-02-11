<?php

namespace App\Service\Hub;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DiscogsService
{
    private const MAX_PAGES = 3;

    public function __construct(private HttpClientInterface $client, private string $apiKey)
    {
    }

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function search(string $artist, string $album): array
    {
        $genreCounts = [];
        $styleCounts = [];
        $countryCounts = [];
        $coverImages = [];
        $years = [];
        $albumTitles = [];
        $artistNames = [];

        $totalPages = $this->getTotalPages($artist, $album);
        if($totalPages === 0) {
            return [];
        }

        for($page = 1; $page <= self::MAX_PAGES && $page <= $totalPages; $page++) {
            $results = $this->fetchResults($artist, $album, $page);
            $filteredResults = $this->filterResults($results);

            foreach($filteredResults as $result) {
                $this->processResult($result, $genreCounts, $styleCounts, $countryCounts, $coverImages, $years, $albumTitles, $artistNames);
            }
        }

        return $this->compileResults($genreCounts, $styleCounts, $countryCounts, $coverImages, $years, $albumTitles, $artistNames, $album, $artist);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function getTotalPages(string $artist, string $album): int
    {
        $response = $this->client->request(
            'GET',
            'https://api.discogs.com/database/search',
            [
                'headers' => [
                    'Authorization' => 'Discogs token=' . $this->apiKey,
                ],
                'query' => [
                    'format' => 'Vinyl',
                    'type' => 'release',
                    'status' => 'official',
                    'artist' => $artist,
                    'title' => $album,
                    'sort' => 'year',
                    'sort_order' => 'asc',
                    'page' => 1,
                    'per_page' => 50,
                ],
            ]
        );

        $data = $response->toArray();
        if(sizeof($data['results']) === 0) {
            return 0;
        }

        return min($data['pagination']['pages'] ?? 1, self::MAX_PAGES);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function fetchResults(string $artist, string $album, int $page): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.discogs.com/database/search',
            [
                'headers' => [
                    'Authorization' => 'Discogs token=' . $this->apiKey,
                ],
                'query' => [
                    'format' => 'Vinyl',
                    'type' => 'release',
                    'status' => 'official',
                    'artist' => $artist,
                    'title' => $album,
                    'sort' => 'year',
                    'sort_order' => 'asc',
                    'page' => $page,
                    'per_page' => 50,
                ],
            ]
        );

        $data = $response->toArray();

        return $data['results'] ?? [];
    }

    private function filterResults(array $results): array
    {
        return array_filter($results, function($result) {
            return isset($result['country'], $result['genre'], $result['style']) &&
                $result['country'] !== 'Unknown' &&
                !str_contains($result['thumb'], 'spacer.gif') &&
                !str_contains($result['cover_image'], 'spacer.gif');
        });
    }

    private function processResult(array $result,
                                   array &$genreCounts,
                                   array &$styleCounts,
                                   array &$countryCounts,
                                   array &$coverImages,
                                   array &$years,
                                   array &$albumTitles,
                                   array &$artistNames): void
    {
        list($tempArtist, $tempTitle) = $this->extractArtistAndTitle($result['title']);
        $artistNames[] = $tempArtist;
        $albumTitles[] = $tempTitle;

        if(isset($result['year'])) {
            $years[] = $result['year'];
        }

        $this->countValues($result['genre'], $genreCounts);
        $this->countValues($result['style'], $styleCounts);

        $country = $result['country'];
        $countryCounts[$country] = ($countryCounts[$country] ?? 0) + 1;

        $coverImages[] = $result['cover_image'];
    }

    private function extractArtistAndTitle(string $title): array
    {
        $titleParts = explode(' - ', $title, 2);
        $tempArtist = trim(preg_replace('/^\(\d+\)\s*|\s*\(\d+\)$/', '', $titleParts[0]));
        $tempTitle = $titleParts[1] ?? $tempArtist;
        $tempTitle = trim(preg_replace('/^\s*-+\s*(\(\d+\)\s*)?|(\s*-+\s*)?(\(\d+\))?\s*$/', '', $tempTitle));

        return [$tempArtist, $tempTitle];
    }

    private function countValues(array $values, array &$counts): void
    {
        foreach($values as $value) {
            $counts[$value] = ($counts[$value] ?? 0) + 1;
        }
    }

    private function compileResults(array  $genreCounts,
                                    array  $styleCounts,
                                    array  $countryCounts,
                                    array  $coverImages,
                                    array  $years,
                                    array  $albumTitles,
                                    array  $artistNames,
                                    string $album,
                                    string $artist): array
    {
        arsort($genreCounts);
        $mostCommonGenre = key($genreCounts) ?: null;

        arsort($styleCounts);
        $mostCommonStyle = key($styleCounts) ?: null;

        $mostCommonCountry = $this->getMostRelevantCountry($countryCounts);
        $mostCommonYear = $this->getMostCommonValue($years) ?? null;
        $mostCommonTitle = $this->getMostCommonValue($albumTitles) ?? $album;
        $mostCommonArtistName = $this->getMostCommonValue($artistNames) ?? $artist;

        return [
            'artist' => trim($mostCommonArtistName),
            'title' => trim($mostCommonTitle),
            'year' => $mostCommonYear,
            'country' => $mostCommonCountry,
            'genre' => $mostCommonGenre,
            'style' => $mostCommonStyle,
            'covers' => array_slice(array_unique($coverImages), 0, 8),
        ];
    }

    private function getMostCommonValue(array $values): ?string
    {
        if(empty($values)) {
            return null;
        }

        $counts = array_count_values($values);
        arsort($counts);

        return key($counts);
    }

    private function getMostRelevantCountry(array $countryCounts): ?string
    {
        if(empty($countryCounts)) {
            return null;
        }

        arsort($countryCounts);
        $mostCommonCountry = key($countryCounts);
        $maxCount = reset($countryCounts);

        $total = array_sum($countryCounts);
        $percentage = ($maxCount / $total) * 100;

        if($percentage > 50) {
            return $mostCommonCountry;
        }

        $countries = array_keys($countryCounts);
        if(count($countries) > 1 && ($countryCounts[$countries[0]] - $countryCounts[$countries[1]]) < 3) {
            return "{$countries[0]}/{$countries[1]}";
        }

        return $mostCommonCountry;
    }
}
