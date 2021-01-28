<?php

namespace App\Http\Controllers\Evento;

use App\Models\Evento\EventoTag;
use App\Models\Evento\Tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\Evento\TagRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = auth()->user()->eventoTags;

        return view('cabinet.evento.tag.index', compact('tags'));
    }

    public function indexAjax()
    {
        $tags = auth()->user()->eventoTags;

        $rs = ['success' => 1, 'message' => 'Тег добавлен!'];

        $tagsRender = View::make('cabinet.evento.ajax.tag_list', compact('tags'))
            ->render();

        $rs['tags'] = $tagsRender;

        die(json_encode($rs));
    }

    public function create()
    {
        return view('cabinet.evento.tag.create');
    }

    public function store(TagRequest $request)
    {
        $attributes = $request->validated();
        $attributes += ['user_id' => auth()->id()];

        try{
            if ($request->hasFile('img')){
                $savedImgPath = $request->file('img')
                    ->store(auth()->id(), ['disk' => 'local'] );
                $attributes['img'] = $savedImgPath;
            }
            Tag::create($attributes);

            $request->session()->flash('crud_message',['message' => 'Tag stored!', 'class' => 'alert alert-success']);
        }catch (\Exception $e){
            $this->saveToLog($e);
        }

        session()->flash('crud_message',['message' => 'Tag created!', 'class' => 'alert alert-success']);

        return back();
    }

    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:105', 'min:2'],
            'color' => ['required', 'string', 'regex:/^#[a-f\d]{3,6}$/ui'],
        ]);
        $customMessages = [
            '*.required' => 'Обязательное поле',
            'name.string'  => 'Введите текст',
            'name.min'  => 'Минимум 2 символа',
            'name.max'  => 'Максимум 105 символов',
            'color.string'  => 'Введите текст',
            'color.regex'  => 'Введите цвет по шаблону #ab4 или #abc531',
        ];
        $attributeNames = [
            'name' => 'имя',
            'color' => 'цвет'
        ];
        $validator->setAttributeNames($attributeNames);
        $validator->setCustomMessages($customMessages);

        if ($validator->fails()){
            $rs = ['success' => 0, 'message' => 'Ошибки валидации',
                'errors' => $validator->errors()->toArray(), 'customAttributes' => $validator->customAttributes];
            die(json_encode($rs));
        }

        $attributes = $this->validateStoreAjax();
        $rs = ['success' => 1, 'message' => 'Тег добавлен!'];
        try{
            $attributes += ['slug' => Str::slug($attributes['name'])];
            $attributes += ['user_id' => auth()->id()];

            $category = Tag::create($attributes);
            $rs['tag_name'] = $category->name;

            if ($request->hasFile('img')){
                $savedImgPath = $request->file('img')->store(auth()->id(), ['disk' => 'local'] );
                $attributes['img'] = $savedImgPath;
            }

            session()->flash('crud_message',['message' => 'Tag created with ajax!', 'class' => 'alert alert-success']);
        }catch (\Exception $e){
            $rs = ['success' => 0, 'message' => 'storeAjax error'];
            $this->saveToLog($e);
        }

        die(json_encode($rs));
    }

    public function show(Tag $tag)
    {
        abort_if(auth()->user()->cannot('view', $tag), 403);

        return view('cabinet.evento.tag.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        abort_if(auth()->user()->cannot('update', $tag), 403);

        return view('cabinet.evento.tag.edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag)
    {
        abort_if(auth()->user()->cannot('update', $tag), 403);

        $attributes = $request->validated();

        try{
            if ($request->hasFile('img')){
                $savedImgPath = $request->file('img')
                    ->store(auth()->id(), ['disk' => 'local'] );
                $attributes['img'] = $savedImgPath;

                $this->deleteImg($tag);
            }
            $tag->update($attributes);

            session()->flash('crud_message',['message' => 'Tag updated!', 'class' => 'alert alert-warning']);
        }catch (\Exception $e){
            $this->saveToLog($e);
        }

        return back();
    }

    public function destroy(Tag $tag, Request $request)
    {
        abort_if(auth()->user()->cannot('delete', $tag), 403);

        try{
            $tag->delete();
            $this->deleteImg($tag);

            session()->flash('crud_message',['message' => 'Tag deleted!', 'class' => 'alert alert-danger']);
        }catch (\Exception $e){
            $this->saveToLog($e);
        }

        return redirect()->route('cabinet.evento.tag.index');
    }

    public function destroyAjax(Tag $tag)
    {
        abort_if(auth()->user()->cannot('delete', $tag), 403);

        try{
            // теперь нужно получить id-шники, которые соответствуют таблице eventoTag
            $evIds = EventoTag::where('tag_id', $tag->id)
                ->pluck('id');

            $tag->delete();
            $this->deleteImg($tag);
            $rs = ['success' => 1, 'message' => 'Tag deleted!', 'id' => $tag->id];

            $rs['evIds'] = $evIds;

            session()->flash('crud_message',['message' => 'Tag deleted!', 'class' => 'alert alert-danger']);
        }catch (\Exception $e){
            $rs = ['success' => 0, 'message' => 'error'];
            $this->saveToLog($e);
        }

        die(json_encode($rs));
    }

    protected function deleteImg(Tag $tag)
    {
        if (Storage::disk('local')->exists($tag->img)){
            return Storage::disk('local')->delete($tag->img);
        }
        return false;
    }

    public function validateStoreAjax(){
        return \request()->validate([
            'name' => ['required', 'string', 'max:105', 'min:2'],
            'color' => ['required', 'string', 'regex:/^#[a-f\d]{3,6}$/ui'],
        ]);
    }

    protected function saveToLog($e){
        logger('error with ' . __METHOD__ . ' '
            . implode(' | ', [
                $e->getMessage(), $e->getLine(), $e->getCode(), $e->getFile()
            ])
        );
    }
}
