<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\GenerateUrl;
use View;

class UrlController extends Controller
{
    public function index()
    {
        $urls = Url::orderBy('created_at', 'desc')->take(10)->get();
        return View::make('welcome')->with('urls', $urls);
    }

    public function insert(GenerateUrl $request)
    {
        Url::Create([
            'full_url' => $request->full_url,
            'short_url' => $this->generate_short_url(),
            'description' => $request->description,
            'times_used' => 0
        ]);
        return response()->json(['data'=>'success']);
    }

    public function visit(Url $url)
    {
        $url->increment('times_used');
        $url->save();
        return response()->json(['times_used'=>$url->times_used]);
    }

    public function generate_short_url()
    {
        $randomWord = $this->generate_random_word();
        $shortUrl = url('/') . '/' . $randomWord;
        $urlWords = [];
        $url = Url::where('short_url', $shortUrl)->first();
        if ($url != null) {
            array_push($urlWords, $randomWord);
            array_push($urlWords, $this->generate_random_word());
            $shortUrl = url('/') . '/' . str_shuffle(implode($urlWords));
        }
        return $shortUrl;
    }

    public function generate_random_word() 
    {
        $raw = file('https://www.eff.org/files/2016/09/08/eff_short_wordlist_2_0.txt');
        $wordsInFile = [];
        foreach ($raw as $line) {
            array_push($wordsInFile,preg_split("/[\t]/", $line)[1]);
        }
        $randomKey = array_rand($wordsInFile,1);
        $randomWord = rtrim($wordsInFile[$randomKey]);
        return $randomWord;
    }
}
