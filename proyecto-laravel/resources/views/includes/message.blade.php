@if (session('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Genial!</strong>
        <span class="block sm:inline">{{session('message')}}</span>
    </div>
@endif