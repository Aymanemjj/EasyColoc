<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="py-12 ">
        @if (auth()->user()->notReserved())
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __('You have no house') }}
                    </div>
                </div>
            </div>
        @else
            @foreach (auth()->user()->house as $house)
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col">
                            @if($house->pivot->is_owner)
                                <small class="bg-yellow-500 p-2 rounded-md">Owner</small>
                            @endif

                            <x-nav-link :href="route('house.index',$house)">{{ $house->title }}</x-nav-link>

                            <small class="bg-gray-500 dark:bg-slate-700 rounded-md p-2">{{$house->description}}</small>
                            
                        </div>
                    </div>
                </div>
            @endforeach

        @endif


    </div>
</x-app-layout>
