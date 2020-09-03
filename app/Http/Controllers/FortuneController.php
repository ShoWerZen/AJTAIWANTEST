<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Fortune;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use \App\Astro;
use Exception;

class FortuneController extends Controller
{
    private static $url = 'https://astro.click108.com.tw/';
    private static $selector = "li.STAR_01 > a, li.STAR_02 > a, li.STAR_03 > a, li.STAR_04 > a, li.STAR_05 > a, li.STAR_06 > a, li.STAR_07 > a, li.STAR_08 > a, li.STAR_09 > a, li.STAR_10 > a, li.STAR_11 > a, li.STAR_12 > a";

    public static function getTodayFortune(){
        $client = new Client();
        $response = $client->request('GET', self::$url);

        $html = (string)$response->getBody();

        $crawler = new Crawler($html);

        $results = $crawler->filter(self::$selector)->each(function (Crawler $node, $i) {
            return ["name" => $node->text(), "href" => $node->attr("href")];
        });


        foreach ($results as $result) {
            self::getFortune($result["name"], $result["href"]);
        }
    }

    protected static function getFortune($astroName, $href){
        try{
            $client = new Client();
            $response = $client->request('GET', $href);
            $html = (string)$response->getBody();
            $crawler = new Crawler($html);

            $fortuneUrl = explode('"', $crawler->filterXPath('//script')->text())[1];
            $response = $client->request('GET', $fortuneUrl);
            $html = (string)$response->getBody();
            $crawler = new Crawler($html);

            $values = $crawler->filter(".TODAY_CONTENT > p")->each(function (Crawler $node, $i) {
                return $node->text();
            });

            $overallStar = substr_count($values[0], "★");
            $overallText = $values[1];
            $loveStar = substr_count($values[2], "★");
            $loveText = $values[3];
            $careerStar = substr_count($values[4], "★");
            $careerText = $values[5];
            $wealthStar = substr_count($values[6], "★");
            $wealthText = $values[7];
            
            
            $astro = Astro::where("name", "=", $astroName)->get()[0];
            $currentDate = date("Y-m-d");

            $results = Fortune::where("dailyDate", "=", $currentDate)->where("astro_id", "=", $astro->id)->get();

            if(sizeof($results) == 0){
                $fortune = [
                    "astro_id" => $astro->id,
                    "dailyDate" => $currentDate,
                    "overallStar" => substr_count($values[0], "★"),
                    "overallText" => $values[1],
                    "loveStar" => substr_count($values[2], "★"),
                    "loveText" => $values[3],
                    "careerStar" => substr_count($values[4], "★"),
                    "careerText" => $values[5],
                    "wealthStar" => substr_count($values[6], "★"),
                    "wealthText" => $values[7],
                ];

                Fortune::createValidate($fortune);

                Fortune::create($fortune);

                echo $fortune->id . " create!\n";
            }
            else{
                $fortune = $results[0];
                $fortune->overallStar = substr_count($values[0], "★");
                $fortune->overallText = $values[1];
                $fortune->loveStar = substr_count($values[2], "★");
                $fortune->loveText = $values[3];
                $fortune->careerStar = substr_count($values[4], "★");
                $fortune->careerText = $values[5];
                $fortune->wealthStar = substr_count($values[6], "★");
                $fortune->wealthText = $values[7];
                $fortune->save();
                echo $fortune->id . " save!\n";
            }
        }
        catch(Exception $e){
            \Log::error($e->getMessage());
        }
    }
}
