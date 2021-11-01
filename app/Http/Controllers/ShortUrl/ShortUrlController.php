<?php

namespace App\Http\Controllers\ShortUrl;

use App\Models\ShortUrl\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class ShortUrlController extends Controller
{
    public function index()
    {
        $description = preg_replace("/[^a-zа-я\d_-]+/ui", '', \request('description'));
        
        $shorturls = ShortUrl::
              where('description', 'like', '%' . $description . '%')
            ->where('user_id','=', auth()->id())
            ->orderBy('id','desc')
            ->paginate(config('services.shorturl.paginate_number'));

        return view('shorturl.index', compact('shorturls', 'description'));
    }

    public function create()
    {
    }

    public function store()
    {
        $attributes = $this->validateForStoreShortUrl();

        $attributes['shorturl'] = Str::random(config('services.shorturl.char_number'));
        $attributes += ['user_id' => auth()->id()];
        ShortUrl::create($attributes);

        session()->flash('shorturl_created','Ссылка создана');
        return back();
    }

    public function show(ShortUrl $shorturl)
    {
        abort_if(auth()->user()->cannot('view', $shorturl), 403);

        return view('shorturl.view', compact('shorturl'));
    }

    public function edit(ShortUrl $shorturl)
    {
        abort_if(auth()->user()->cannot('update', $shorturl), 403);

        return view('shorturl.edit', compact('shorturl'));
    }

    public function update(Request $request, ShortUrl $shorturl)
    {
        abort_if(auth()->user()->cannot('update', $shorturl), 403);

        $attributes = $this->validateForUpdateShortUrl();

        $shorturl->description = $attributes['description'];
        $shorturl->longurl = $attributes['longurl'];
        $shorturl->shorturl = $attributes['shorturl'];
        $shorturl->save();

        session()->flash('shorturl_updated', 'Ссылка обновлена');
        return redirect()->route('shorturl.edit', $shorturl->id);
    }

    public function destroy(ShortUrl $shorturl)
    {
        abort_if(auth()->user()->cannot('delete', $shorturl), 403);

        $shorturl->delete();
        session()->flash('shorturl_deleted','Короткая ссылка удалена!');
        return redirect()->route('shorturl.index');
    }

    public function copyShortUrl(ShortUrl $shorturl){

    }

    public function getShortUrl($shorturl)
    {
        $longurl = ShortUrl::where('shorturl','=',$shorturl)->first();
        return redirect($longurl->longurl);
    }

    public function validateForStoreShortUrl()
    {
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
