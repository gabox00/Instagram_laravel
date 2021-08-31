var url="http://proyecto-laravel.com.devel"
var headers = {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}

window.addEventListener("load", () => {

    $('.btn-like').css('cursor','pointer')
    $('.btn-comment').css('cursor','pointer')
    $('.btn-dislike').css('cursor','pointer')
    $('.follow').css('cursor','pointer')
    $('.unfollow').css('cursor','pointer')

    like()
    dislike()
    saveComment()
    deleteComment()
    toggleComments()
    deleteImage()
    searchUsers()
    follow()
    unfollow()

    function follow(){
        $('.follow').unbind('click').click(function(){ 
            user_id = $(this).data('id')
            $(this).addClass('unfollow').removeClass('follow');
            $(this).addClass('bg-red-500').removeClass('bg-blue-500');
            $(this).html('Unfollow')
            $.ajax({
                url: url+'/follow/'+user_id,
                type: 'get',
                success: function(response){
                    console.log(response)
                    unfollow()
                }
            })
        })
    }

    function unfollow(){
        $('.unfollow').unbind('click').click(function(){ 
            user_id = $(this).data('id')
            $(this).addClass('follow').removeClass('unfollow');
            $(this).addClass('bg-blue-500').removeClass('bg-red-500');
            $(this).html('Follow')
            $.ajax({
                url: url+'/unfollow/'+user_id,
                type: 'get',
                success: function(response){
                    console.log(response)
                    follow()
                }
            })
        })
    }


    function deleteImage(){
        $('.delete-img').unbind('click').click(function(){ 
            image_id = $(this).data('id')
            $.ajax({
                url: url+'/image/delete/',
                type: 'delete',
                data: {'image_id': image_id},
                headers: headers,
                success: function(response){
                    console.log(response)
                    location.reload();
                }
            })
        })
    }

    function deleteComment(){

        $('.delete-comment').unbind('click').click(function(){
            comment_id = $(this).data('comment_id')
            image_id = $(this).data('image_id')
            $.ajax({
                url: url+'/comment/delete',
                type: 'POST',
                data: {'comment_id': comment_id},
                headers: headers,
                success: function(response){
                    decrementCount($('.comment-label[data-id = '+image_id+']'))
                    $('.comment[data-comment_id = '+comment_id+'] ').remove();
                    $('.btn-comment[data-id = '+image_id+']').attr('fill',"#262626")
                }
            })
        })
    }

    function saveComment(){
        $('.send-comment').unbind('click').click(function(){
            image_id = $(this).data('id')
            data = {
                'image_id': image_id,
                'content': $('textarea[data-id = '+image_id+']').val()
            }
            $.ajax({
                url: url+'/comment/save',
                type: 'POST',
                data: data,
                headers: headers,
                success: function(response){
                    div = `<div data-comment_id="${response.commentID}" class="comment flex items-center justify-between pt-2">
                                <div class="flex">
                                    <div class="bg-cover bg-center w-10 h-10 rounded-full mr-3" style="background-image: url(${url}/user/avatar/${response.userImage})"></div>
                                    <div>
                                        <p class="font-bold text-gray-900">&#x40;${response.userNick}</p>
                                        <p class="text-sm text-gray-700">${response.commentContent}</p>
                                    </div>
                                </div>
                                <button data-image_id="${image_id}" data-comment_id="${response.commentID}" type="button" class="delete-comment h-6 w-6 p-1 rounded-full bg-red-400 bg-opacity-25 focus:outline-none">
                                    <svg class="text-red-500 text-opacity-75" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>`  
                    $(div).appendTo( '.comments-box[data-id = '+image_id+']' );
                    $('textarea[data-id = '+image_id+']').val('')
                    $('.btn-comment[data-id = '+image_id+']').attr('fill',"blue")
                    incrementCount($('.comment-label[data-id = '+image_id+']'))
                    deleteComment()
                }
            })
        })
    }

    function toggleComments(){
        $('.btn-comment').unbind('click').click(function(){
            idBox = $(this).data('id');
            box = $('.comments-box[data-id = '+idBox+']')
            form = $('.comments-form[data-id = '+idBox+']')
            if(!box.attr('hidden')){
                box.attr("hidden",true);
                form.attr("hidden",true);
            }
            else{
                box.attr("hidden",false);
                form.attr("hidden",false);
            } 
        })
    }

    function like(){
        $('.btn-like').unbind('click').click(function(){
            id = $(this).data('id')
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).css('fill','red');
            dislike();
            $.ajax({
                url: url+'/like/'+id,
                type: 'GET',
                success: function(response){
                    incrementCount($('.like-label[data-id = '+id+']'))
                }
            })

        });
    }

    function dislike(){
        $('.btn-dislike').unbind('click').click(function(){
            id = $(this).data('id')
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).css('fill','#262626');
            like();
            $.ajax({
                url: url+'/dislike/'+id,
                type: 'GET',
                success: function(response){
                    decrementCount($('.like-label[data-id = '+id+']'))
                }
            })
        });
    }

    function incrementCount(el){
        value = el.html().split(' ')
        inValue = parseInt(value[0]) + 1
        stringValue = value[1]
        el.html(`${inValue} ${stringValue}`)
    }

    function decrementCount(el){
        value = el.html().split(' ')
        inValue = parseInt(value[0]) - 1
        stringValue = value[1]
        el.html(`${inValue} ${stringValue}`)
    }

    function searchUsers(){
        $("#buscador").submit(function(){
            $(this).attr("action",url+"/users/"+$("#search").val())
        })

    }


})