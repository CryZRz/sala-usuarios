<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class NotiTecController extends Controller
{
    public function index(){
        $html = Http::get('https://leon.tecnm.mx/category/tecnoticias_2025/')->body();

        $crawler = new Crawler($html);

        $articles = $crawler->filter('article')->each(function ($node) {
            $article = [];
            $title = $node->filter("h2");
            $image = $node->filter("img");
            $link = $node->filterXPath("//a[text() = 'Descarga']");
            $article['title'] = $title->text();
            $article['image'] = $image->attr('src');
            $article['link'] = $link->attr('href');

            return $article;
        });

        return response()->json($articles);
    }
}
