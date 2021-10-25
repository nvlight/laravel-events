<?php

namespace App\Http\Controllers\Learn\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    //
    public function index(){
        $out = [];
        array_push($out, __NAMESPACE__);
        array_push($out, __CLASS__);
        array_push($out, __METHOD__);

        return implode(', ', $out);
    }

    public function create(){
        return 'create';
    }

    public function store(){
        return 'store';
    }

    public function show(){
        return 'show';
    }

    public function edit(){
        return 'edit';
    }

    public function update(){
        return 'update';
    }

    public function destroy(){
        return 'destroy';
    }

    public function getOne(){
        return 'getOne';
    }
}