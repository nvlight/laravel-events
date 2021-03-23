<?php

namespace App\Http\Controllers\Evento;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Evento\Tag;
use App\Models\Evento\Category;

class MainFilterController extends Controller
{

    protected function saveToLog($e){
        logger('error with ' . __METHOD__ . ' '
            . implode(' | ', [
                $e->getMessage(), $e->getLine(), $e->getCode(), $e->getFile()
            ])
        );
    }

    protected function dieJsonEncode($value){
        die(json_encode($value));
    }

    protected function getTagsRs(){
        $result = ['success' => 0];
        try{
            $query = Tag::where('user_id', auth()->id())->orderBy('created_at', 'DESC');
            $rs = $query->get()->toArray();
            $result = ['success' => 1, 'rs' => $rs];
        }catch (\Exception $e){
            $this->saveToLog($e);
        }

        return $result;
    }

    protected function getCategoriesRs(){
        $result = ['success' => 0];
        try{
            $query = Category::where('user_id', auth()->id())->orderBy('created_at', 'DESC');
            $rs = $query->get()->toArray();
            $result = ['success' => 1, 'rs' => $rs];
        }catch (\Exception $e){
            $this->saveToLog($e);
        }

        return $result;
    }

    public function getTags(){

        $tags = $this->getTagsRs();
        //dump($tags);

        $this->dieJsonEncode($tags);
    }

    public function getCategories(){

        $categories = $this->getCategoriesRs();
        //dump($categories);

        $this->dieJsonEncode($categories);
    }
}
