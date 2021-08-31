<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <form id="buscador" class="flex justify-center content-center p-4" action="" method="GET">
        <input class="shadow appearance-none border border-red-500 rounded w-2/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="search">
        <input class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" value="Buscar">
    </form>

    @foreach ($users as $user)
        @include('user.profile')     
    @endforeach

    <div class="flex justify-center p-10">
        {{ $paginator->links() }} 
    </div>

</x-app-layout>
