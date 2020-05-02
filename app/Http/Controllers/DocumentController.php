<?php

namespace App\Http\Controllers;

use App\Models\Document\Document;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Validator;

class DocumentController extends Controller
{
    public function index()
    {
        $filename = \request('filename');
        $docVld = Validator::make(request()->all(), [
            'filename' => ['string','regex:/^[a-zа-я\d_-]{3,55}$/ui'], //'min:3','max:55',
        ]);

        if ($docVld->fails()){
            $documents = new Collection();
        }else{
            $search_string = '%' . $filename . '%';
            $documents = Document::where('user_id','=',auth()->id() )
                ->where('filename', 'like', $search_string)
                ->get();
        }
        return view('document.index', compact('documents', 'filename', 'docVld'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $file_info = $request->file('uploadFile');

        $saved_path = $file_info->store(config('services.documents.path2save'));

        $attributes = [];
        $attributes += ['user_id' => auth()->id()];
        $attributes += ['filename' => $file_info->getClientOriginalName()];
        $attributes += ['realname' => $saved_path];
        $attributes += ['mime' => $file_info->getMimeType()];
        $attributes += ['size' => $file_info->getSize()];
        Document::create($attributes);

        session()->flash('document_uploaded', 'Файл загружен на сервер');

        return back();
    }

    public function show(Document $document)
    {
        //
    }

    public function edit(Document $document)
    {
        //
    }

    public function update(Request $request, Document $document)
    {
        //
    }

    public function destroy(Document $document)
    {
        abort_if(auth()->user()->cannot('delete', $document), 403);

        $document->delete();
        session()->flash('document_deleted','Документ удален!');
        return back();
    }

    public function download(Document $document)
    {
        abort_if(auth()->user()->cannot('delete', $document), 403);

        $pathToFile = storage_path()."/app/".$document->realname;
        return response()->download($pathToFile, $document->filename);
    }
}