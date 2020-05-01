<?php

namespace App\Http\Controllers;

use App\Models\Document\Document;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Debug;
use Illuminate\Support\Facades\Storage;
use Validator;


class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filename = \request('filename');
        $docVld = Validator::make(request()->all(), [
            'filename' => ['string','regex:/^[a-zа-я\d_-]{3,55}$/ui'], //'min:3','max:55',
        ]);
        //dd($docVld->errors());
        if ($docVld->fails()){
            $documents = new Collection();
        }else{
            $search_string = '%' . $filename . '%';
            $documents = Document::where('user_id','=',auth()->id() )
                ->where('filename', 'like', $search_string)
                ->get();
        }

        //dd($documents);

        return view('document.index', compact('documents', 'filename', 'docVld'));
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
        //dd(\request('customFile'));
        //echo Debug::d(\request('customFile'));

        //$path = Storage::put('customFiles',$request->file('customFile')); //putFile('avatars', $request->file('customFile'));
        //dd($path);

        $file_info = $request->file('uploadFile');
        //dd($file_info);
        //echo Debug::d($file_info);

        //-originalName: "[HTML Academy] Профессиональный HTML и CSS, уровень 2 [2018, RUS] [rutracker-5566310].torrent"
        //-mimeType: "application/x-bittorrent"
        //-error: 0
        //size: 270313

        //filename
        //realname
        //mime
        //size

        $saved_path = $file_info->store(config('services.documents.path2save'));
        //echo Debug::d($saved_path);

        $attributes = [];
        $attributes += ['user_id' => auth()->id()];
        $attributes += ['filename' => $file_info->getClientOriginalName()];
        $attributes += ['realname' => $saved_path];
        $attributes += ['mime' => $file_info->getMimeType()];
        $attributes += ['size' => $file_info->getSize()];
        //echo Debug::d($attributes);
        Document::create($attributes);
        //die;

        session()->flash('document_uploaded', 'Файл загружен на сервер');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Document\Document $document
     */
    public function destroy(Document $document)
    {
        abort_if(auth()->user()->cannot('delete', $document), 403);
        //abort_if($document->user_id !== auth()->id(), 403);

        $document->delete();
        session()->flash('document_deleted','Документ удален!');
        return back();
    }

    //
    public function download(Document $document)
    {
        abort_if($document->user_id !== auth()->id(), 403);

        //return $document;
        $pathToFile = storage_path()."/app/".$document->realname;
        return response()->download($pathToFile, $document->filename);
    }
}
