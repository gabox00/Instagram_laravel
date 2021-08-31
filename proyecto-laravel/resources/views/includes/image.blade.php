@foreach ($images as $image)
    <div class="bg-white border rounded-sm max-w-5xl">
        <div class="flex items-center px-4 py-3 justify-between">
            <div class="flex items-center">
                @if ($image->users->image)
                <a href="{{route('profile', $image->users->id)}}"><img class="h-8 w-8 rounded-full" src="{{ route('user.avatar', ['filename'=>$image->users->image]) }}"/> </a> 
                @else
                    <img class="h-8 w-8 rounded-full" src=""/>  
                @endif
                <div class="ml-3 ">
                    <span class="text-sm font-semibold antialiased block leading-tight">&#x40;{{$image->users->nick}}</span>
                    <span class="text-gray-600 text-xs block">{{$image->users->name}} {{$image->users->name}}</span>
                </div>
            </div>
            <div class="ml-3">
                <span class="text-sm font-semibold antialiased block leading-tight">{{\FormatTime::LongTimeFilter($image->created_at)}}</span>
            </div> 
        </div>
        <img src="{{ route('image.file', ['filename'=>$image->image_path]) }}"/>
        <div class="flex items-center justify-between mx-4 mt-3 mb-2">
            <?php 
                $colorHeart = $image->likes->filter(function ($value, $key) {
                    return $value->user_id == Auth::user()->id;
                });
                $colorComment = $image->comments->filter(function ($value, $key) {
                    return $value->user_id == Auth::user()->id;
                });
            ?>
            <div class="flex gap-5">
                <svg data-id="{{$image->id}}" class="{{count($colorHeart) ? 'btn-dislike' : 'btn-like' }}" fill="{{count($colorHeart) ? 'red' : '#262626' }}" height="24" viewBox="0 0 48 48" width="24"><path d="M34.6 6.1c5.7 0 10.4 5.2 10.4 11.5 0 6.8-5.9 11-11.5 16S25 41.3 24 41.9c-1.1-.7-4.7-4-9.5-8.3-5.7-5-11.5-9.2-11.5-16C3 11.3 7.7 6.1 13.4 6.1c4.2 0 6.5 2 8.1 4.3 1.9 2.6 2.2 3.9 2.5 3.9.3 0 .6-1.3 2.5-3.9 1.6-2.3 3.9-4.3 8.1-4.3m0-3c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5.6 0 1.1-.2 1.6-.5 1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z"></path></svg>
                <svg data-id="{{$image->id}}" class="btn-comment" fill="{{count($colorComment) ? 'blue' : '#262626' }}" height="24" viewBox="0 0 48 48" width="24"><path clip-rule="evenodd" d="M47.5 46.1l-2.8-11c1.8-3.3 2.8-7.1 2.8-11.1C47.5 11 37 .5 24 .5S.5 11 .5 24 11 47.5 24 47.5c4 0 7.8-1 11.1-2.8l11 2.8c.8.2 1.6-.6 1.4-1.4zm-3-22.1c0 4-1 7-2.6 10-.2.4-.3.9-.2 1.4l2.1 8.4-8.3-2.1c-.5-.1-1-.1-1.4.2-1.8 1-5.2 2.6-10 2.6-11.4 0-20.6-9.2-20.6-20.5S12.7 3.5 24 3.5 44.5 12.7 44.5 24z" fill-rule="evenodd"></path></svg>
                <div data-id="{{$image->id}}" class="like-label font-semibold text-sm">{{count($image->likes)}} likes</div>
                <div data-id="{{$image->id}}" class="comment-label font-semibold text-sm">{{count($image->comments)}} Comentarios</div>
            </div>
            @if ($image->users->id == Auth::user()->id && isset($user))
                <button data-id="{{$image->id}}" class="delete-img bg-red-400 hover:bg-red-500 p-2 rounded-full shadow-md flex justify-center items-center">
                    <svg class="text-white toggle__lock w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>     
            @endif
        </div>
        <div class="comments-box px-4 pt-3 pb-4 border-t border-gray-300 bg-gray-300" data-id="{{$image->id}}" hidden>
            <div class="text-xs uppercase font-bold text-gray-600 tracking-wide">Comentarios:</div>
            @foreach ($image->comments as $comment)
                    <div data-comment_id="{{$comment->id}}" class="comment flex items-center justify-between pt-2">
                        <div class="flex">
                            @if ($comment->users->image)
                                <div class="bg-cover bg-center w-10 h-10 rounded-full mr-3" style="background-image: url({{ route('user.avatar', ['filename'=>$comment->users->image]) }})">
                                </div>   
                            @else
                                <div class="bg-cover bg-center w-10 h-10 rounded-full mr-3" style="background: black">
                                </div>   
                            @endif

                            <div>
                                <p class="font-bold text-gray-900">&#x40;{{$comment->users->nick}}</p>
                                <p class="text-sm text-gray-700">{{$comment->content}}</p>
                            </div>
                        </div>

                        <button data-image_id="{{$image->id}}" data-comment_id="{{$comment->id}}" type="button" class="delete-comment h-6 w-6 p-1 rounded-full bg-red-400 bg-opacity-25 focus:outline-none">
                            <svg class="text-red-500 text-opacity-75" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                    </div>
            @endforeach
        </div>   
        <div class="comments-form" data-id="{{$image->id}}" hidden>
            <div class="flex justify-center items-center">

                <textarea rows="3" class="rounded w-full" placeholder="Escribe algo..." data-id="{{$image->id}}" required></textarea>
    
                <div class="flex justify-between mx-3">
                    <button data-id="{{$image->id}}" class="send-comment px-4 py-1 bg-gray-800 text-white rounded font-light hover:bg-gray-700">Enviar</button>
                </div>
                  
            </div>
        </div> 
    </div>
@endforeach
