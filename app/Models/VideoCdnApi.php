<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VideoCdnApi
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoCdnApi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoCdnApi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoCdnApi query()
 * @mixin \Eloquent
 */
class VideoCdnApi extends Model
{
    public static $apiPrefix = "https://videocdn.tv/api/";
    public static $iframeSrcTamplate = '<iframe src="{iframeSrc}" width="640" height="480" frameborder="0" allowfullscreen></iframe>';

    /**/
    public static function getApiResponseShort(string $url)
    {
        try{
            $fgi = file_get_contents($url);
            $fgi_json = json_decode($fgi,1);
            $result = ['success' => 1, 'data' => $fgi_json];
        }catch (\Exception $e){
            $fgi_json = $e;
            $result = ['success' => 0, 'data' => $fgi_json];
        }
        //dump($fgi_json);

        return $result;
    }

}
