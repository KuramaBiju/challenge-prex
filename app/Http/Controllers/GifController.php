<?php

namespace App\Http\Controllers;

use App\Application\UseCases\SaveGifUseCase;
use App\Application\UseCases\SearchGifsfByPhraseUseCase;
use App\Application\UseCases\SearchGifByIdUseCase;
use App\Http\Requests\SaveGifRequest;
use App\Http\Requests\SearchGifsByPhraseRequest;
use App\Infrastructure\Persistence\GifRepositoryEloquent;
use App\Infrastructure\ExternalServices\GiphyApiClient;
use App\Jobs\CreateLogService;
use Illuminate\Http\Request;

class GifController extends Controller
{


    public function findById(Request $request)
    {
        try {
            $parsedId = $request->id;
            $findByIdUseCase = new SearchGifByIdUseCase(new GiphyApiClient());
            $gifFound = $findByIdUseCase->execute($parsedId);
            return response()->json($gifFound, 200);
        } catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (\Throwable $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function findByPhrase(SearchGifsByPhraseRequest $request)
    {
        try {
            $query = $request->query('query');
            $limit = $request->query('limit', 10);
            $offset = $request->query('offset', 0);
            $findByPhraseUseCase = new SearchGifsfByPhraseUseCase(new GiphyApiClient());
            $gifs = $findByPhraseUseCase->execute($query, $limit, $offset);
            return response()->json($gifs, 200);
        } catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (\Throwable $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function save(SaveGifRequest $request)
    {
        try {
            $saveGifUseCase = new SaveGifUseCase(new GifRepositoryEloquent());
            $saveGifUseCase->execute($request->user_id, $request->gif_id, $request->alias);
            return response()->json(['message' => 'Gif saved successfully'], 201);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
