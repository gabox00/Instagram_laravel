<?= $flagFollowed=false ?>
@foreach (Auth::user()->follows as $follow)
    @if ($follow->following_id== $user->id)
      <?php $flagFollowed=true ?>
    @endif
@endforeach
@if (Auth::user()->id != $user->id)
  @if ($flagFollowed)
    <div data-id={{$user->id}} class="unfollow bg-red-500 px-2 py-1 
        text-white font-semibold text-sm rounded block text-center 
        sm:inline-block block">Unfollow</div>        
  @else
      <div data-id={{$user->id}} class="follow bg-blue-500 px-2 py-1 
        text-white font-semibold text-sm rounded block text-center 
        sm:inline-block block">Follow</div>        
  @endif
@endif