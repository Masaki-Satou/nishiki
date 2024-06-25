
@php

    if($name==='image1'){$modal='modal-1';}
    if($name==='image2'){$modal='modal-2';}
    if($name==='image3'){$modal='modal-3';}
    if($name==='image4'){$modal='modal-4';}
    if($name==='image5'){$modal='modal-5';}
    $cImage=$currentImage ?? '';
    $cId=$currentId ?? '';

@endphp

<div class="modal micromodal-slide" id="{{ $modal }}" aria-hidden="true">
    <div class="modal__overlay z-50" tabindex="-1" data-micromodal-close>
    <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="{{ $modal }}-title">
        <header class="modal__header">
        <h2 class="text-xl text-gray-700" id="{{ $modal }}-title">
           ファイルを選択して下さい
        </h2>
        <button type="button" class="modal__close text-3xl" aria-label="Close modal" data-micromodal-close></button>
        </header>
        <main class="modal__content" id="{{ $modal }}-content">
            <div class="flex justify-center flex-wrap">
                @foreach($images as $image)

                <div class="w-2/5 md:w-1/5 border hover:border-black rounded-md p-2 m-2">

                    <div>
                        <img class="image w-full h-28 md:h-36 mx-auto object-cover" 
                         data-id="{{ $name }}_{{ $image->id }}"
                         data-file="{{ $image->filename }}"
                         data-path="{{ asset('storage/products') }}"
                         data-modal="{{ $modal }}"
                         src="{{ asset('storage/products/'.$image->filename)}}">
                    </div>

                </div>

                @endforeach
            </div>
        </main>
        <footer class="modal__footer text-end">
        <x-button type="button" class="modal__btn" data-micromodal-close aria-label="閉じる">実行</x-button>
        </footer>
    </div>
    </div>
</div>


<div class="flex justify-around items-center mb-4">
    
    <div class="flex flex-col justify-around items-center">
        <a class="p-2 m-2 border border-gray-300 rounded-md" data-micromodal-trigger="{{ $modal }}" href='javascript:;'>ファイルを選択</a>

        <x-btn.delete type="button" data-id="{{ $name }}" data-fpath="{{ asset('images/no-img.png') }}" onclick="imgDelete(this)" class="">
        削除
        </x-button>
    </div>



    <div class="w-2/4">
        <img class="w-full h-28 md:h-52 mx-auto object-cover" id="{{ $name }}_thumbnail" @if($cImage) src="{{ asset('storage/products/'.$cImage) }}" @else src="{{ asset('images/no-img.png') }}" @endif>
    </div>
    <input id="{{ $name }}_hidden" type="hidden" name="{{ $name }}" value={{ $cId }} @if($name==='image1') require @endif>

</div>
