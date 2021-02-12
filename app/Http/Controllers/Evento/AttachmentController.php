<?php

namespace App\Http\Controllers\Evento;

use App\Http\Requests\Evento\AttachmentStoreRequest;
use App\Http\Requests\Evento\AttachmentUpdateRequest;
use App\Models\Evento\Attachment;
use App\Http\Controllers\Controller;
use App\Models\Evento\Evento;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AttachmentController extends Controller
{
    const SAVE_DIR_PREFIX = "evento_attachs" . DIRECTORY_SEPARATOR . "user_";

    protected $fileName;

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

        //
        if ( !$this->isUserHaveEventoId($request->get('evento_id'))){
            return back()->with('crud_message',['message' => 'user doesnt have evento with this id!', 'class' => 'alert alert-danger']);
        }

        if ($request->hasFile('file'))
        {
            $file = $request->file('file');

            $filename = self::SAVE_DIR_PREFIX . auth()->id() . DIRECTORY_SEPARATOR . Str::random(40) . "."
                        . $file->extension();

            $attributes['file'] = $filename;
            $attributes += ['originalname' => $file->getClientOriginalName()];
            $attributes += ['mimetype' => $file->getMimeType()];
            $attributes += ['size' => $file->getSize()];
        }

        try{
            $attachment = Attachment::create($attributes);

            if ($request->hasFile('file')){
                try{
                    $file->storeAs($filename, '', ['disk' => 'local'] );
                } catch (FileException $fe){
                    // созданную запись нужно удалить, если файл не был сохранен
                    try{
                        $attachment->delete();
                    }catch (QueryException $qe){
                        return back()->with('crud_message',['message' => 'Delete error!', 'class' => 'alert alert-danger']);
                    }
                    $this->saveToLog($fe);
                    return back()->with('crud_message',['message' => 'File save error!', 'class' => 'alert alert-danger']);
                }
            }
            session()->flash('crud_message',['message' => 'Attachment stored!', 'class' => 'alert alert-success']);
        }catch (QueryException $qe){
            $this->saveToLog($qe);
            return back()->with('crud_message',['message' => 'Create error!', 'class' => 'alert alert-danger']);
        }

        return back();
    }

    public function storeAjax(Request $request)
    {
        $file = [
            'size' => [
                'min' => 0,
                'max' => 5120
            ],
            'mimes' => [
                'jpg', 'jpeg', 'png', 'webp', 'svg', 'gif', 'ico',
                'doc', 'docx', 'xls', 'xlsx', 'pdf', 'djvu', 'txt',
                'zip', 'rar'
            ],
        ];

        $validator = Validator::make($request->all(), [
            'evento_id' => ['required', 'int', 'min:0'],
            'file' => 'required|file' .
                '|min:' . $file['size']['min'] .
                '|max:' . $file['size']['max'] .
                '|mimes:' . implode(',', $file['mimes']),
        ]);

        if ($validator->fails()){
            $rs = ['success' => 0, 'message' => 'Ошибки валидации вложения!',
                    'errors' => $validator->errors()->toArray()];
            die(json_encode($rs));
        }

        //$attributes = $request->validated();

        $attributes  = ['user_id' => auth()->id()];
        $attributes += ['evento_id' => $request->get('evento_id')];

        if ( !$this->isUserHaveEventoId($request->get('evento_id'))){
            $rs = ['success' => 0, 'message' => 'user doesnt have evento with this id!'];
            die(json_encode($rs));
        }

        if ($request->hasFile('file'))
        {
            $file = $request->file('file');

            $filename = self::SAVE_DIR_PREFIX . auth()->id() . DIRECTORY_SEPARATOR . Str::random(40) . "."
                . $file->extension();

            $attributes['file'] = $filename;
            $attributes += ['originalname' => $file->getClientOriginalName()];
            $attributes += ['mimetype' => $file->getMimeType()];
            $attributes += ['size' => $file->getSize()];
        }

        try{
            $attachment = Attachment::create($attributes);

            if ($request->hasFile('file')){
                try{
                    $file->storeAs($filename, '', ['disk' => 'local'] );
                } catch (FileException $fe){
                    // созданную запись нужно удалить, если файл не был сохранен
                    try{
                        $attachment->delete();
                    }catch (QueryException $qe){
                        return back()->with('crud_message',['message' => 'Delete error!', 'class' => 'alert alert-danger']);
                    }
                    $this->saveToLog($fe);

                    $rs = ['success' => 1, 'message' => 'File save error!'];
                    die(json_encode($rs));
                    //return back()->with('crud_message',['message' => , 'class' => 'alert alert-danger']);
                }
            }
            session()->flash('crud_message',['message' => 'Attachment stored!', 'class' => 'alert alert-success']);
        }catch (QueryException $qe){
            $this->saveToLog($qe);

            $rs = ['success' => 1, 'message' => 'Create error!'];
            die(json_encode($rs));
            //return back()->with('crud_message',['message' => 'Create error!', 'class' => 'alert alert-danger']);
        }

        $attachments = $this->getAttachmentsHtmlByEventoId($request->get('evento_id'));

        $rs = ['success' => 1, 'message' => 'row added, file saved!', 'attachments' => $attachments,
            'eventoId' => $request->get('evento_id')];
        die(json_encode($rs));
    }

    protected function getAttachmentsHtmlByEventoId($eventoId){

        $attachments = auth()->user()->eventoAttachments()->where('evento_attachments.evento_id', $eventoId)->get();

        return View::make('cabinet.evento._blocks.ajax.attachment', compact('attachments'))->render();
    }

    public function getAttachmentsByEventoIdAjax(Request $request){

        $attachments = $this->getAttachmentsHtmlByEventoId($request->get('evento_id'));

        $rs = ['success' => 1, 'message' => 'attachments here!', 'attachments' => $attachments];

        die(json_encode($rs));
    }

    protected function isUserHaveEventoId($eventoId){

        $result = Evento::where('user_id', auth()->id())->where('id', $eventoId)->count();

        return intval($result);
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

            $filename = self::SAVE_DIR_PREFIX . auth()->id() . DIRECTORY_SEPARATOR . Str::random(40) . "."
                . $file->extension();

            $attributes['file'] = $filename;
            $attributes['originalname'] = $file->getClientOriginalName();
            $attributes['mimetype'] = $file->getMimeType();
            $attributes['size'] = $file->getSize();
        }

        try{
            if (Storage::disk('local')->exists($attachment->file)){
                Storage::disk('local')->delete($attachment->file);
            }

            $attachment->update($attributes);
        }catch (QueryException $qe){
            return back()->with('crud_message',['message' => 'File update error!', 'class' => 'alert alert-danger']);
        }

        //
        if ($request->hasFile('file')){
            try{
                $file->storeAs($filename, '', ['disk' => 'local'] );
            } catch (FileException $e){

                // созданную запись нужно удалить, если файл не был сохранен
                try{
                    $attachment->delete();
                }catch (QueryException $qe){
                    $this->saveToLog($e);
                    return back()->with('crud_message',['message' => 'File delete error!', 'class' => 'alert alert-danger']);
                }

                $this->saveToLog($e);
                return back()->with('crud_message',['message' => 'File save error!', 'class' => 'alert alert-danger']);
            }
            //$this->deleteFile($attachment->file);
        }

        return back();
    }


    public function destroy($attachment)
    {
        abort_if(auth()->user()->cannot('delete', $attachment), 403);

        try{
            $savedAttachmentId = $attachment->id;
            $eventoId = $attachment->evento_id;

            $attachment->delete();
            $this->deleteFile($attachment->file);

            $rs = ['success' => 1, 'message' => 'Attachment deleted!', 'class' => 'alert alert-danger',
                'attachment_id' => $savedAttachmentId, 'evento_id' => $eventoId];
        }catch(\Exception $e){
            $this->saveToLog($e);
            $rs = ['success' => 0, ['message' => 'Attachment delete failed!', 'class' => 'alert alert-danger'] ];
        }

        return $rs;
    }

    public function destroyAndRedirect(Attachment $attachment)
    {
        $this->destroy($attachment);

        return redirect()->route('cabinet.evento.attachment.index');
    }

    public function destroyAndBack(Attachment $attachment)
    {
        $this->destroy($attachment);

        return back();
    }

    public function destroyAjax(Attachment $attachment)
    {
        die(json_encode($this->destroy($attachment)));
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

    protected function saveToLog($e){
        logger('error with ' . __METHOD__ . ' '
            . implode(' | ', [
                $e->getMessage(), $e->getLine(), $e->getCode(), $e->getFile()
            ])
        );
    }
}
