<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Session;
use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Http\Request;

class ScrapingController extends Controller
{

    private $source = 'http://www.tert.am/am/news/';

    public function index()
    {
        $this->getPageData($this->source);
        for($i = 2; $i<=100; $i++)
           $this->getPageData($this->source . "$i");

        $count = Post::count();
        if($count > 1000){
            $imgsToRemove = Post::orderBy('created_at','asc')->pluck('img')->take($count - 1000);
            $toRemove = Post::orderBy('created_at','asc')->pluck('id')->take($count - 1000);
            Post::whereIn('id',$toRemove)->delete();

            foreach ($imgsToRemove as $img){
                echo $img . "<br>";
                unlink('uploads/' . $img);
            }
        }
        Session::flash('success','Successfully scanned');

        return back();
    }

    public function getPageData($url)
    {
        $dom = HtmlDomParser::file_get_html($url);
        $pageElems = $dom->find('.news-list .news-blocks');

        $data = [];
        foreach ($pageElems as $post) {
            $data['title'] = $post->find('h4 a', 0)->innertext();
            $data['description'] = $post->find('.nl-anot a', 0)->innertext();
            $data['posted_on'] = $this->getDate($post);
            $data['url'] = $post->find('h4 a', 0)->href;
            $data['created_at'] = date('Y-m-d H:i:s',time());
            $data['updated_at'] = $data['created_at'];
            $postData = Post::firstOrNew(['url' =>$data['url'] ],$data);
            if($postData->img){
                unlink('uploads/' . $postData->img);
            }
            $imgData = $this->getImage($post);
            $postData->img_original_url = $imgData['img_original_url'];
            $postData->img = $imgData['img'];
            $postData->save();
        }
    }

    public function getImage($post)
    {
        $src = $post->find('a img',0)->src;
        $returnData['img_original_url'] = $src;
        $srcParts = explode('.',$src);
        $fileName = time().rand(10000,99999) . '.' .end($srcParts);
        $imageData = file_get_contents($src, false);
        $returnData['img'] = file_put_contents('uploads/' .$fileName , $imageData) ? $fileName : '';
       
        return $returnData;
    }

    public function getDate($post)
    {
        $text = trim($post->find('.nl-dates', 0)->plaintext);

        $text = preg_replace("/&#?[a-z0-9]+;/i","",$text);
        $text = substr($text, 0, 15);
        $text = preg_replace('/\s+/', ' ', $text);
//        $text = preg_replace('/\./', '/', $text);
        $parts = explode(' ',$text);
        $parts[1] = explode('.',$parts[1]);
        $dateString = '20' . $parts[1][2]  . '-' . $parts[1][1] . '-' . $parts[1][0] . ' ' . $parts[0] .  ':00';

        $date =  date('Y-m-d H:i:s',strtotime($dateString));
        return $date;
    }
}
