<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Google_Client;
use Carbon\CarbonInterval;
use Google_Service_YouTube;
use Illuminate\Support\Facades\Http;

class VideosController extends Controller
{
    //
    public function index()
    {


        $channelId = 'UCIfb4X1VM8uYo5g9y6b585A';
        $maxResults = 100;

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
                // 'order' => 'date',
            ]);

            $videos = [];

            foreach ($response->getItems() as $video) {
                $videoId = $video->getId()->getVideoId();

                // Retrieve video details including duration
                $videoResponse = $youtube->videos->listVideos('contentDetails', [
                    'id' => $videoId
                ]);

                //get duration of the video with ISO 8601 format
                $duration = $videoResponse->getItems()[0]->getContentDetails()->getDuration();

                //convert duration from ISO 8601 format to seconds
                $interval = new CarbonInterval($duration);
                $durationInSeconds = $interval->seconds + ($interval->minutes * 60) + ($interval->hours * 3600);

                // Check if duration is less than 3 minutes (180 seconds)
                if ($durationInSeconds < 120) {
                    continue; // Skip this video and move to the next one
                }

                //format duration to HH:MM:SS
                $durationFormatted = gmdate('H:i:s', $durationInSeconds);


                $title = preg_replace('/\s*#\S+\s*/', '', $video->getSnippet()->getTitle());

                $videos[] = [
                    'id' => $videoId,
                    'title' => $title,
                    'description' => $video->getSnippet()->getDescription(),
                    'thumbnail' => $video->getSnippet()->getThumbnails()->getMedium()->getUrl(),
                    'duration' => $durationFormatted,
                ];
            }


            // Cache the results for 1 hour
            // Cache::put($cacheKey, $videos, now()->addHour());
        }

        return response()->json($videos);
    }

    public function showVideos()
    {
        $appUrl = env('APP_URL');
        $response =  HTTP::get($appUrl.'videos-data');// Call the index() method to retrieve the JSON response
        $videosData = $response->json(); // Convert the JSON response to an array

        // Pass the videos data to the view
        return view('videos', [
            'title' => 'Videos',
            'videos' => $videosData,  
        ]);
    }
}
