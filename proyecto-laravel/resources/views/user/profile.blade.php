<div class="flex flex-wrap items-center p-4 md:py-8">

    <div class="xl:pl-40 md:w-3/12 md:ml-16">
      <!-- profile image -->
      <a href="{{route('profile', $user->id)}}"><img class="w-20 h-20 md:w-40 md:h-40 object-cover rounded-full border-2 border-pink-600 p-1" src="{{ route('user.avatar', ['filename'=>isset($user->image) ? $user->image : "default.jpg"]) }}" alt="profile"></a>
    </div>

    <!-- profile meta -->
    <div class="w-8/12 md:w-7/12 ml-4">
      <div class="md:flex md:flex-wrap md:items-center mb-4">
        <h2 class="text-3xl inline-block font-light md:mr-2 mb-2 sm:mb-0">
          {{"@".$user->nick}}
        </h2>

        <!-- badge -->
        <span class="inline-block fas fa-certificate fa-lg text-blue-500 
                             relative mr-6 text-xl transform -translate-y-2" aria-hidden="true">
          <i class="fas fa-check text-white text-xs absolute inset-x-0
                             ml-1 mt-px"></i>
        </span>

        <!-- follow button -->
        @include('includes.follow')
      
      </div>

      <!-- post, following, followers list for medium screens -->
      <ul class="hidden md:flex space-x-8 mb-4">
        <li>
          <span class="font-semibold">{{count($user->images)}}</span>
          posts
        </li>

        <!--- <li>
          <span class="font-semibold">40.5k</span>
          followers
        </li>
        <li>
          <span class="font-semibold">302</span>
          following
        </li>!--->
      </ul> 

      <!-- user meta form medium screens -->
      <div class="hidden md:block">
        <h1 class="font-semibold">{{$user->name . " " . $user->surname }}</h1>
        <span>Lorem ipsum dolor, sit amet</span>
        <p>Lorem ipsum dolor sit amet consectetur</p>
      </div>

    </div>

    <!-- user meta form small screens -->
    <div class="md:hidden text-sm my-2">
      <h1 class="font-semibold">{{$user->name . " " . $user->surname }}</h1>
      <span>Lorem ipsum dolor, sit amet</span>
      <p>Lorem ipsum dolor sit amet consectetur</p>
    </div>

</div>