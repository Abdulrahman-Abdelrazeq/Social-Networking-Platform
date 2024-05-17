
<x-app-layout>
    <div class="info-profile row justify-content-center text-white">
        <div class="friends col-9 col-md-7 col-lg-6 p- rounded-3" style="min-height: 100vh; padding-top: 100px;">
            @foreach ($users as $user)
            <div class="flex align-items-center justify-content-between">
                <div class="flex align-items-center gap-10 py-3">
                    <a href="{{route('user.show', $user->id)}}"><div class="profile-image" style="background-image: url('{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1200px-User_icon_2.svg.png' }}');"></div></a>
                    <a href="{{route('user.show', $user->id)}}"><h1>{{$user->name}}</h1></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
