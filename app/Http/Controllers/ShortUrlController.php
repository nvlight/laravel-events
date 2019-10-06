<?php

namespace App\Http\Controllers;

use App\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shorturls = ShortUrl::where('user_id', '=', auth()->id() ) //->get();c
            ->paginate(config('services.shorturl.paginate_number'));
        //dd($shorturls);

        return view('shorturl.index', compact('shorturls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $this->validateForStoreShortUrl();

        $attributes['shorturl'] = Str::random(config('services.shorturl.char_number'));

        $attributes += ['user_id' => auth()->id()];

        ShortUrl::create($attributes);

        session()->flash('shorturl_created','Ссылка создана');

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShortUrl  $shortUrl
     * @return \Illuminate\Http\Response
     */
    public function show(ShortUrl $shortUrl)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShortUrl  $shortUrl
     * @return \Illuminate\Http\Response
     */
    public function edit(ShortUrl $shorturl)
    {
        abort_if(auth()->user()->cannot('view', $shorturl), 403);

        //return $shorturl;
        return view('shorturl.edit', compact('shorturl'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShortUrl  $shortUrl
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShortUrl $shorturl)
    {
        abort_if(auth()->user()->cannot('view', $shorturl), 403);

        $attributes = $this->validateForUpdateShortUrl();
        //return $shorturl;

        $shorturl->description = $attributes['description'];
        $shorturl->longurl = $attributes['longurl'];
        $shorturl->shorturl = $attributes['shorturl'];
        $shorturl->save();

        session()->flash('shorturl_updated', 'Ссылка обновлена');
        return redirect('/shorturl');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShortUrl  $shortUrl
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShortUrl $shorturl)
    {
        abort_if(auth()->user()->cannot('view', $shorturl), 403);

        $shorturl->delete();
        session()->flash('shorturl_deleted','Короткая ссылка удалена!');
        return redirect('/shorturl');
    }

    //
    public function getShortUrl($shorturl){

        $longurl = ShortUrl::where('shorturl','=',$shorturl)->first();

        //dd($longurl->longurl);

        return redirect($longurl->longurl);

    }

    //
    public function validateForStoreShortUrl(){
        return \request()->validate([
            'description' => 'required|string|min:3|max:170',
            'longurl' => 'required|string|min:3|max:1111',
        ]);
    }

    public function validateForUpdateShortUrl(){
        return \request()->validate([
            'description' => 'required|string|min:3|max:170',
            'longurl' => 'required|string|min:3|max:1111',
            'shorturl' => 'required|string|min:3|max:1111',
        ]);
    }
}