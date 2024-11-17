<?php

namespace App\Infrastructure\ExternalServices;

use App\Domain\Repositories\GifReadRepository;
use App\Domain\ValueObjects\GifId;
use Exception;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;

class GiphyApiClient implements GifReadRepository {

    protected $apiKey;
    protected $apiUrl;

    public function __construct() {
        $this->apiKey = env('GIPHY_API_KEY');
        $this->apiUrl = env('GIPHY_API_URL');
    }
    public function findById(GifId $id) {
        return $this->fetch("v1/gifs/{$id}", ['rating' => 'g']);
    }

    public function findByPhrase(string $phrase, int $limit = 25, int $offset = 0) {
        return $this->fetch("v1/gifs/search", [
            'q' => $phrase,
            'limit' => $limit,
            'offset' => $offset,
        ]);
    }

    private function fetch(string $endpoint, array $params = []) {

            $params['api_key'] = $this->apiKey;
            $url = "{$this->apiUrl}/{$endpoint}";
            $response = Http::get($url, $params);
            if($response->successful()){
                return $response->json('data') ?? [];
            }
            $this->handleErrorResponse($response);
    }


    private function handleErrorResponse($response)
    {
        $responseBody = $response->json();
        $errorMessage = $responseBody['meta']['msg'] ?? 'An error occurred';
        $statusCode = $response->status();
        switch ($statusCode) {
            case 400:
                throw new \DomainException($errorMessage, $statusCode);
            case 404:
                throw new \DomainException($errorMessage, $statusCode);
            case 401:
                throw new \DomainException($errorMessage, $statusCode);
            case 429:
                throw new \DomainException($errorMessage, $statusCode);
            default:
                throw new Exception('Unexpected error from Giphy API.');
        }
    }
}
