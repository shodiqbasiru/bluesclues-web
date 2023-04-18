<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Google_Client;
use Google_Service_YouTube;

class VideosController extends Controller
{
    //
    public function index()
    {


        $channelId = 'UCIfb4X1VM8uYo5g9y6b585A';
        $maxResults = 50;

        $cacheKey = 'youtube_search_' . $channelId;
        if (Cache::has($cacheKey)) {
            $videos = Cache::get($cacheKey);
        } else {
            $client = new Google_Client();
            $client->setDeveloperKey(env('YOUTUBE_API_KEY'));


            $youtube = new Google_Service_YouTube($client);

            $response = $youtube->search->listSearch('id,snippet', [
                'channelId' => $channelId,
                'maxResults' => $maxResults,
                'type' => 'video',
            ]);

            $videos = [];

            foreach ($response->getItems() as $video) {
                $videos[] = [
                    'id' => $video->getId()->getVideoId(),
                    'title' => $video->getSnippet()->getTitle(),
                    'description' => $video->getSnippet()->getDescription(),
                    'thumbnail' => $video->getSnippet()->getThumbnails()->getMedium()->getUrl(),
                ];
            }
            

            // Cache the results for 1 hour
            Cache::put($cacheKey, $videos, now()->addHour());
        }
        

        return view('videos', [
            'title' => 'Videos',
            'videos' => $videos
        ]);
    }
}