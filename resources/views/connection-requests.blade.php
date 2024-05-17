
<x-app-layout>
    <div class="info-profile row justify-content-center text-white">
        <div class="friends col-9 col-md-7 col-lg-6 p- rounded-3" style="min-height: 100vh; padding-top: 100px;">
            @foreach ($connections as $friend)
            <div class="flex align-items-center justify-content-between">
                <div class="flex align-items-center gap-10 py-3">
                    @if ($friend->user_id != Auth::id())
                    <a href="{{route('user.show', $friend->user_id)}}"><div class="profile-image" style="background-image: url('{{ $friend->user->profile_picture ? asset('storage/' . $friend->user->profile_picture) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1200px-User_icon_2.svg.png' }}');"></div></a>
                    <h1>{{$friend->user->name}}</h1>
                    @else
                    <a href="{{route('user.show', $friend->friend_id)}}"><div class="profile-image" style="background-image: url('{{ $friend->friend->profile_picture ? asset('storage/' . $friend->user->profile_picture) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1200px-User_icon_2.svg.png' }}');"></div></a>
                    <h1>{{$friend->friend->name}}</h1>
                    @endif
                </div>
                <div class="flex gap-2">
                    <form action="{{route('connection.update', $friend->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-primary rounded-full">Accept</button>
                    </form>
                    <form action="{{route('connection.destroy', $friend->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-full">Reject</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
