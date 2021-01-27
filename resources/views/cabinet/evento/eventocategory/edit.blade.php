@extends('layouts.evento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Evento/EventoCategory/Edit</h2>

                @include('cabinet.evento.eventocategory.nav.breadcrumbs')

                <div class="d-flex">
                    @include('cabinet.evento.eventocategory.buttons.create')
                    @include('cabinet.evento.eventocategory.buttons.delete', ['eventoCategoryId' => $eventocategory->id, 'class' => 'btn-danger ml-2' ] )
                </div>

                <div class="card">
                    <div class="card-body">

                        @include('cabinet.evento._blocks.errors')
                        @include('cabinet.evento._blocks.flash_message')

                        <form action="{{ route('cabinet.evento.eventocategory.update', $eventocategory) }}" method="post" enctype="application/x-www-form-urlencoded">
                            @csrf
                            <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                            <?php //dump($eventocategory) ?>
                            <div class="form-group">
                                <label class="w-100">
                                    <b>evento_id</b>
                                    <span class="form-control w-100">{{ $evento->description }}</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="w-100">
                                    <b>category_id</b>
                                    <select name="category_id" class="form-control w-100">
                                        <option>0</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if($eventocategory->category_id == $category->id) selected @endif
                                            >{{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>

                            <div class="form-group mt-2">
                                <button class="btn btn-success" type="submit">Save</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection