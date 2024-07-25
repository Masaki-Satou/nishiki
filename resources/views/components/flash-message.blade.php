
@if(session('message'))
    <div x-data="{ open:true }" x-show="open" class="relative p-4 m-2 text-white text-center bg-red-500">
        <div>{{ session('message') }}</div>

        <!-- @click.away="open = false"他の場所をクリックしても閉じる -->
        <button @click="open = false" type="button" class="text-2xl absolute top-0 right-2">×</button> 
    </div>

@endif