<?php

namespace App\Http\Controllers\Evento;

use App\Http\Requests\Evento\AttachmentStoreRequest;
use App\Http\Requests\Evento\AttachmentUpdateRequest;
use App\Models\Evento\Attachment;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AttachmentController extends Controller
{
    public function index()
    {
        $attachments = auth()->user()->eventoAttachments;

        return view('cabinet.evento.attachment.index', compact('attachments'));
    }

    public function create()
    {
        $eventos = auth()->user()->eventos;

        return view('cabinet.evento.attachment.create', compact('eventos'));
    }

    public function store(AttachmentStoreRequest $request)
    {
        $attributes = $request->validated();

        $attributes += ['user_id' => auth()->id()];
        $attributes += ['evento_id' => $request->get('evento_id')];

        if ($request->hasFile('file'))
        {
            $file = $request->file('file');

            $filename = auth()->id() . DIRECTORY_SEPARATOR . Str::random(40);
            $attributes['file'] = $filename;
            $attributes += ['originalname' => $file->getClientOriginalName()];
            $attributes += ['mimetype' => $file->getMimeType()];
            $attributes += ['size' => $file->getSize()];
        }

        try{
            $attachment = Attachment::create($attributes);
        }catch (QueryException $qe){
            return back()->with('error', implode(', ', [
                    'create error: ' . $qe->getCode() //, $qe->getLine(), $qe->getMessage()
                ]
            ));
        }

        if ($request->hasFile('file')){
            try{
                $file->storeAs($filename, '', ['disk' => 'local'] );
            } catch (FileException $e){

                // созданную запись нужно удалить, если файл не был сохранен
                try{
                    $attachment->delete();
                }catch (QueryException $qe){
                    return back()->with('error', implode(', ', [
                            'delete error: ' . $qe->getCode() //, $qe->getLine(), $qe->getMessage()
                        ]
                    ));
                }

                return back()->with('error', implode(', ', [
                        'file save error: ' . $e->getCode() //, $qe->getLine(), $qe->getMessage()
                    ]
                ));
            }
        }

        return back();
    }

    public function show(Attachment $attachment)
    {
        abort_if(auth()->user()->cannot('view', $attachment), 403);

        return view('cabinet.evento.attachment.show', compact('attachment'));
    }

    public function edit(Attachment $attachment)
    {
        abort_if(auth()->user()->cannot('update', $attachment), 403);

        $eventos = auth()->user()->eventos;
        $fileName = $attachment->originalname ? $attachment->originalname : "";

        return view('cabinet.evento.attachment.edit', compact('attachment','eventos', 'fileName'));
    }

    public function update(AttachmentUpdateRequest $request, Attachment $attachment)
    {
        abort_if(auth()->user()->cannot('update', $attachment), 403);

        $attributes = $request->validated();

        if ($request->hasFile('file'))
        {
            $file = $request->file('file');

            $filename = auth()->id() . DIRECTORY_SEPARATOR . Str::random(40);

            $attributes['file'] = $filename;
            $attributes['originalname'] = $file->getClientOriginalName();
            $attributes['mimetype'] = $file->getMimeType();
            $attributes['size'] = $file->getSize();
        }

        try{
            $attachment->update($attributes);
        }catch (QueryException $qe){
            return back()->with('error', implode(', ', [
                    'update error: ' . $qe->getCode() //, $qe->getLine(), $qe->getMessage()
                ]
            ));
        }

        if ($request->hasFile('file')){
            try{
                $file->storeAs($filename, '', ['disk' => 'local'] );
            } catch (FileException $e){

                // созданную запись нужно удалить, если файл не был сохранен
                try{
                    $attachment->delete();
                }catch (QueryException $qe){
                    return back()->with('error', implode(', ', [
                            'delete error: ' . $qe->getCode() //, $qe->getLine(), $qe->getMessage()
                        ]
                    ));
                }

                return back()->with('error', implode(', ', [
                        'file save error: ' . $e->getCode() //, $qe->getLine(), $qe->getMessage()
                    ]
                ));
            }
            $this->deleteFile($attachment->file);
        }

        return back();
    }

    public function destroy(Attachment $attachment)
    {
        abort_if(auth()->user()->cannot('delete', $attachment), 403);

        $attachment->delete();
        $this->deleteFile($attachment->file);

        return back();
    }

    protected function deleteFile(string $filename)
    {
        if (Storage::disk('local')->exists($filename)){
            Storage::disk('local')->delete($filename);
        }
    }

    public function download(Attachment $attachment)
    {
        if (Storage::disk('local')->exists($attachment->file)){
            return Storage::disk('local')->download($attachment->file, $attachment->originalname);
        }
        return back();
    }
}
