<?php

namespace App\Http\Controllers;

use App\Category;
use App\Debug;
use App\Event;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        User::whereId(Auth::user()->id)
//            ->with('events', 'types', 'categories')
//            ->first();

        $events = DB::table('users')
            ->leftJoin('events', 'events.user_id','=', 'users.id')
            ->leftJoin('types','types.id','=','events.type_id')
            ->leftJoin('categories','categories.id', '=', 'events.category_id')
            ->where('users.id','=',auth()->id())
            //->select('users.*','events.*','categories.*','types.*',)
            ->select('events.id', 'categories.name as category_name',
                'events.date', 'events.description', 'events.amount', 'types.name as type_name', 'types.color')
            ->orderBy('date','desc')
            ->paginate(config('services.events.paginate_number'));
            //->get();

        // после переделать ^ используя reletions
        //$events = auth()->user()->events()->caregories;
        //$events = auth()->user()->load('events', 'types', 'categories')->toArray();
        //$events = \App\User::whereId(auth()->user()->id)->with('events', 'types', 'categories')->first();

        //echo Debug::d($events); die;
        //dd($events);

        return view('event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('user_id', '=', auth()->id() )->get();
        $types = Type::where('user_id', '=', auth()->id() )->get();
        
        //dd($categories);

        return view('event.create', compact('categories', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'category_id' => ['required','integer','min:1'],
            'type_id' => ['required','integer','min:1'],
            'date' => ['required','date'],
            'amount' => ['required','integer','min:0'],
            'description' => ['required','string','min:3','max:1111'],
        ]);

        $attributes += ['user_id' => auth()->id()];

        Event::create($attributes);

        session()->flash('event_created','Событие создано');

        return redirect('/event');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //echo Debug::d($event->toArray()); die;
        //$this->authorize('view', $event);
        //abort_if(Gate::denies('view', $event), 403);
        abort_if(auth()->user()->cannot('view', $event), 403);

        return view('event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        abort_if(auth()->user()->cannot('view', $event), 403);

        $categories = Category::where('user_id', '=', auth()->id() )->get();
        $types = Type::where('user_id', '=', auth()->id() )->get();
        $event->date = Carbon::parse($event->date)->format('d.m.Y');
        //echo Debug::d($event->date); die;
        return view('event.edit', compact('event', 'categories', 'types') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        abort_if(auth()->user()->cannot('view', $event), 403);

        $attributes = $request->validate([
            'category_id' => ['required','integer','min:1'],
            'type_id' => ['required','integer','min:1'],
            'date' => ['required','date'],
            'amount' => ['required','integer','min:0'],
            'description' => ['required','string','min:3','max:1111'],
        ]);

        $event->category_id = $attributes['category_id'];
        $event->type_id = $attributes['type_id'];
        $event->date =  $event->date = Carbon::parse( $attributes['date'])->format('Y-m-d');;
        $event->amount = $attributes['amount'];
        $event->description = $attributes['description'];
        $event->save();

        session()->flash('event_updated','Событие обновлено');

        return redirect('/event');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        abort_if(auth()->user()->cannot('view', $event), 403);

        $event->delete();
        session()->flash('event_deleted','Событие удалено!');
        return redirect('/event');
    }
}
