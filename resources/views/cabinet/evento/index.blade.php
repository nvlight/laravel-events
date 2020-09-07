@extends('layouts.evento')

@section('content')

    <header class="text-gray-700 body-font">
        <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
            <nav class="flex lg:w-2/5 flex-wrap items-center text-base md:ml-auto">
                <a class="mr-5 hover:text-gray-900">First Link</a>
                <a class="mr-5 hover:text-gray-900">Second Link</a>
                <a class="mr-5 hover:text-gray-900">Third Link</a>
                <a class="hover:text-gray-900">Fourth Link</a>
            </nav>
            <a class="flex order-first lg:order-none lg:w-1/5 title-font font-medium items-center text-gray-900 lg:items-center lg:justify-center mb-4 md:mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                </svg>
                <span class="ml-3 text-xl">Eventos</span>
            </a>
            <div class="lg:w-2/5 inline-flex lg:justify-end ml-5 lg:ml-0">
                <button class="inline-flex items-center bg-gray-200 border-0 py-1 px-3 focus:outline-none hover:bg-gray-300 rounded text-base mt-4 md:mt-0">Button
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <main>
        <!--
        container px-5 py-24 mx-auto flex md:items-center lg:items-start md:flex-no-wrap flex-wrap flex-col
        -->
        <div class="container px-5 py-10 mx-auto">
            <h1 class="sm:text-4xl text-5xl font-medium title-font text-center text-gray-900 mb-10">Evento/index</h1>
            <p class="flex justify-between">
                <a class="text-indigo-500" href="{{ route('cabinet.evento.create') }}">create new evento</a>
                <a class="text-indigo-500" href="{{ route('cabinet.evento.category.index') }}">category/index</a>
                <a class="text-indigo-500" href="{{ route('cabinet.evento.tag.index') }}">tag/index</a>
                <a class="text-indigo-500" href="{{ route('cabinet.evento.eventocategory.index') }}">eventoCategory/index</a>
                <a class="text-indigo-500" href="{{ route('cabinet.evento.eventotag.index') }}">eventoTag/index</a>
                <a class="text-indigo-500" href="{{ route('cabinet.evento.eventotagvalue.index') }}">eventoTagValue/index</a>
                <a class="text-indigo-500" href="{{ route('cabinet.evento.attachment.index') }}">attachment/index</a>
            </p>

            @if($eventos)
                <div class="overflow-x-auto py-10 mx-auto ">
                    <div class="container px-1">
                        <table class="table-auto w-full">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">description</th>
                                <th class="px-4 py-2">date</th>

                                <th class="px-4 py-2">actions</th>
                            </tr>
                            @foreach($eventos as $evento)
                                @php !isset($i) ? $i=1 : $i ; @endphp
                                <tr
                                    @if($i%2==0)
                                        class="bg-gray-100"
                                    @endif
                                >
                                    <td class="border px-4 py-2">{{$evento->id}}</td>
                                    <td class="border px-4 py-2">{{$evento->description}}</td>
                                    <td class="border px-4 py-2">{{$evento->date}}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('cabinet.evento.show',    $evento ) }}">show </a>
                                        <a href="{{ route('cabinet.evento.destroy', $evento ) }}" class="deleteItem">delete </a>
                                        <a href="{{ route('cabinet.evento.edit',    $evento ) }}">update </a>
                                    </td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        </table>
                    </div>
                </div>
            @endif

            @if($eventosWithAllColumns)
                <div class="overflow-x-auto">
                    <div class="container px-1">
                        <table class="table-auto ">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Description</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">categories</th>
                                <th class="px-4 py-2">tags</th>
                                <th class="px-4 py-2">tag_val</th>
                                <th class="px-4 py-2">tag_caption</th>
                                <th class="px-4 py-2">actions</th>
                            </tr>
                            @foreach($eventosWithAllColumns as $eventoWithAllColumns)
                                @php !isset($i) ? $i=1 : $i ; @endphp
                                <tr @if($i%2==0) class="bg-gray-100" @endif>
                                    <td class="border px-4 py-2">{{$eventoWithAllColumns->evento_id}}</td>
                                    <td class="border px-4 py-2">{{$eventoWithAllColumns->evento_description}}</td>
                                    <td class="border px-4 py-2">{{$eventoWithAllColumns->evento_date}}</td>
                                    <td class="border px-4 py-2">{{$eventoWithAllColumns->evento_category_name}}</td>
                                    <td class="border px-4 py-2">{{$eventoWithAllColumns->evento_tag_name}}</td>
                                    <td class="border px-4 py-2" style="background-color: {{ $eventoWithAllColumns->evento_tag_color }};">
                                        {{$eventoWithAllColumns->evento_evento_tag_value_value}}
                                    </td>
                                    <td class="border px-4 py-2">{{$eventoWithAllColumns->evento_evento_tag_value_caption}}</td>

                                    <td class="border px-4 py-2">
                                        <a href="{{ route('cabinet.evento.show',    $eventoWithAllColumns->evento_id) }}">show </a>
                                        <a href="{{ route('cabinet.evento.destroy', $eventoWithAllColumns->evento_id) }}">delete </a>
                                        <a href="{{ route('cabinet.evento.edit',    $eventoWithAllColumns->evento_id) }}">update </a>
                                    </td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        </table>
                    </div>
                </div>
            @endif
        </div>

    </main>

    <div id="main_dialog" class="hidden fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!--
              Background overlay, show/hide based on modal state.

              Entering: "ease-out duration-300"
                From: "opacity-0"
                To: "opacity-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <div class="fixed inset-0 transition-opacity">
                <div class="modalBg absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
            <!--
              Modal panel, show/hide based on modal state.

              Entering: "ease-out duration-300"
                From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                To: "opacity-100 translate-y-0 sm:scale-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100 translate-y-0 sm:scale-100"
                To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                 role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                Delete evento
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm leading-5 text-gray-500">
                                    Are you sure you want to delete your evento? All of your data will be
                                    permanently removed. This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
					<span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
						<button type="button"
                                class="deleteConfirmBtn inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
							Delete
						</button>
					</span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
						<button type="button"
                                class="cancelBtn inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
							Cancel
						</button>
					</span>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-gray-700 body-font">
        <div class="container px-5 py-24 mx-auto flex md:items-center lg:items-start md:flex-row md:flex-no-wrap flex-wrap flex-col">
            <div class="w-64 flex-shrink-0 md:mx-0 mx-auto text-center md:text-left">
                <a class="flex title-font font-medium items-center md:justify-start justify-center text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                    </svg>
                    <span class="ml-3 text-xl">Evento</span>
                </a>
                <p class="mt-2 text-sm text-gray-500">Air plant banjo lyft occupy retro adaptogen indego</p>
            </div>
            <div class="flex-grow flex flex-wrap md:pl-20 -mb-10 md:mt-0 mt-10 md:text-left text-center">
                <div class="lg:w-1/4 md:w-1/2 w-full px-4">
                    <h2 class="title-font font-medium text-gray-900 tracking-widest text-sm mb-3">CATEGORIES</h2>
                    <nav class="list-none mb-10">
                        <li>
                            <a class="text-gray-600 hover:text-gray-800">First Link</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800">Second Link</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800">Third Link</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800">Fourth Link</a>
                        </li>
                    </nav>
                </div>
                <div class="lg:w-1/4 md:w-1/2 w-full px-4">
                    <h2 class="title-font font-medium text-gray-900 tracking-widest text-sm mb-3">CATEGORIES</h2>
                    <nav class="list-none mb-10">
                        <li>
                            <a class="text-gray-600 hover:text-gray-800">First Link</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800">Second Link</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800">Third Link</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800">Fourth Link</a>
                        </li>
                    </nav>
                </div>
                <div class="lg:w-1/4 md:w-1/2 w-full px-4">
                    <h2 class="title-font font-medium text-gray-900 tracking-widest text-sm mb-3">CATEGORIES</h2>
                    <nav class="list-none mb-10">
                        <li>
                            <a class="text-gray-600 hover:text-gray-800">First Link</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800">Second Link</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800">Third Link</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800">Fourth Link</a>
                        </li>
                    </nav>
                </div>
                <div class="lg:w-1/4 md:w-1/2 w-full px-4">
                    <h2 class="title-font font-medium text-gray-900 tracking-widest text-sm mb-3">CATEGORIES</h2>
                    <nav class="list-none mb-10">
                        <li>
                            <a class="text-gray-600 hover:text-gray-800">First Link</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800">Second Link</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800">Third Link</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800">Fourth Link</a>
                        </li>
                    </nav>
                </div>
            </div>
        </div>
        <div class="bg-gray-200">
            <div class="container mx-auto py-4 px-5 flex flex-wrap flex-col sm:flex-row">
                <p class="text-gray-500 text-sm text-center sm:text-left">© <script>document.write(new Date().getFullYear())</script> Evento —
                    <a href="https://twitter.com/evento_mg" rel="noopener noreferrer" class="text-gray-600 ml-1" target="_blank">@evento_mg</a>
                </p>
                <span class="inline-flex sm:ml-auto sm:mt-0 mt-2 justify-center sm:justify-start">
        <a class="text-gray-500">
          <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
          </svg>
        </a>
        <a class="ml-3 text-gray-500">
          <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
            <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
          </svg>
        </a>
        <a class="ml-3 text-gray-500">
          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
            <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
          </svg>
        </a>
        <a class="ml-3 text-gray-500">
          <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="0" class="w-5 h-5" viewBox="0 0 24 24">
            <path stroke="none" d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"></path>
            <circle cx="4" cy="4" r="2" stroke="none"></circle>
          </svg>
        </a>
      </span>
            </div>
        </div>
    </footer>

    <script>
        var currentDeleteItemHref = null;
        let deleteItemA = document.querySelectorAll('a.deleteItem');
        if (deleteItemA.length){
            for (let i=0; i<deleteItemA.length; i++){
                deleteItemA[i].onclick = function (e) {
                    e.stopImmediatePropagation();
                    if (deleteItemA[i].hasAttribute('href')){
                        let href = deleteItemA[i].getAttribute('href');
                        currentDeleteItemHref = href;
                        //console.log(href);
                        dialogOpenBtnHandler();

                        let deleteConfirmBtn = document.querySelector('.deleteConfirmBtn');
                        if (deleteConfirmBtn){
                            deleteConfirmBtn.onclick = function () {
                                deleteConfirmBtnHandler(currentDeleteItemHref);
                            }
                        }
                    }
                    return false;
                }
            }
        }

        let openDeactivateDialog = document.querySelector('#openDeactivateDialog');
        if (openDeactivateDialog){
            let targetClass = '#main_dialog';
            // event.stopImmediatePropagation();
            // return false
            openDeactivateDialog.addEventListener('click', dialogOpenBtnHandler)
        }

        let cancelBtn = document.querySelector('.cancelBtn');
        if (cancelBtn){
            let targetClass = '#main_dialog';
            cancelBtn.addEventListener('click', dialogCloseBtnHandler);
        }

        let closeMainDialogOnDarkSide = document.querySelector('#main_dialog');
        if (closeMainDialogOnDarkSide){
            let targetClass = '#main_dialog';
            closeMainDialogOnDarkSide.onclick = function(e) {
                //console.log(e.target.classList + ' clicked ' + Math.random(100));
                let targetClass = '#main_dialog';
                let isFindTarget = document.querySelector(targetClass);

                if (e.target.classList.contains('modalBg') && isFindTarget ){
                    isFindTarget.classList.toggle('hidden');
                }
            };
        }

        function dialogOpenBtnHandler() {
            let targetClass = '#main_dialog';
            let isFindTarget = document.querySelector(targetClass);
            if (isFindTarget){
                //console.log('we in');
                //console.log(isFindTarget.classList);
                isFindTarget.classList.toggle('hidden');
            }
        }
        function dialogCloseBtnHandler() {
            let targetClass = '#main_dialog';
            let isFindTarget = document.querySelector(targetClass);
            if (isFindTarget){
                isFindTarget.classList.toggle('hidden');
            }
        }
        function deleteConfirmBtnHandler(href) {
            document.location.href = href; 
        }

    </script>

@endsection