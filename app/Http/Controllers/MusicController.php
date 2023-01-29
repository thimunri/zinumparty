<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PHPUnit\Util\Json;

class MusicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function listQueue(Request $request)
    {
        $results = DB::select("SELECT * FROM music_queue WHERE status = 'queued'");
        return new JsonResponse($results);
    }

    public function getMusicToPlay(Request $request)
    {
        $results = DB::select("SELECT * FROM music_queue WHERE status = 'queued' order by id ASC LIMIT 1");
        return $results;
    }

    public function removeMusic(Request $request)
    {
        try {
            DB::update("UPDATE music_queue SET status = 'done' WHERE music_id = ?", [$request->get('music_id')]);
            return new JsonResponse(['message' => 'ok', 'music_id' => $request->get('music_id')], 200);
        } catch(\Exception $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], 500);
        }
    }

    public function queue(Request $request)
    {

        $data = $request->all();
        try {
            DB::insert("insert into music_queue (music_id, music_name, thumbnail) VALUES (?,?,?)", [
                $request->get('music_id'),
                $request->get('music_name'),
                $request->get('thumbnail'),
            ]);
            return new JsonResponse([], 201);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }
    }

    public function search(Request $request) {
        try {
            $q = $request->get('q');
            $client = new \GuzzleHttp\Client(['base_uri' => 'https://youtube.googleapis.com/']);
            $maxResults = 20;
            $response = $client->request('GET', "youtube/v3/search?part=id&part=snippet&q={$q}&key=AIzaSyADAzSfJo76kfIgeXhhPTkKwxrDy9XIAOc&maxResults={$maxResults}");

            echo $response->getBody()->getContents();
        } catch (\Exception $e) {
            die('error');
        }

    }
}
