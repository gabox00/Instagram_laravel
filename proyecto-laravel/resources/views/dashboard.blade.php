<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    @isset($user)
        @include('user.profile')   
    @endisset

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @include('includes.message')
            </div>
        </div>
    </div>

    <div class="grid gap-4 grid-cols-1 justify-items-center">
        @include('includes.image')
    </div>
    <div class="flex justify-center p-10">
        {{ $paginator->links() }} 
    </div>

</x-app-layout>
