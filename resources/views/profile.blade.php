<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}
    <div class="new-post py-12 mt-20 row justify-content-center text-white">
        <div class="col-10 col-md-8 col-lg-7 col-xl-6 mx-xl-5 p-3 rounded-3">
            <form method="POST" action="{{route('post.store')}}" enctype="multipart/form-data">
                @csrf

                <div class="flex mb-3 justify-content-between">
                    <a class="rounded-circle me-2" href=""><img width="80px" height="80" src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1200px-User_icon_2.svg.png" alt=""></a>
                    <textarea name="content"></textarea>
                </div>
                <div class="flex justify-content-between">
                    <label for="image">
                        <i class="fa-solid fa-image"></i>
                        Image
                    </label>
                    <input class="d-none" type="file" name="image" id="image">
                    <button type="submit" class="btn btn-primary">Post</button>
                </div>
            </form>
        </div>
    </div>
    <div class="all-posts py-12 row justify-content-center text-white">
        @foreach ($posts as $post)

            <div class="col-10 col-md-8 col-lg-7 col-xl-6 mx-xl-5 mb-4 p-3 rounded-3">

                <div class="info flex justify-content-between mb-2">
                    <div class="flex gap-3">
                        <a class="rounded-circle" href=""><img width="80px" height="80" src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1200px-User_icon_2.svg.png" alt=""></a>
                        <h4 class="position-relative w-100">
                           <a href="">{{$post->user->name}}</a>
                        </h4>
                    </div>
                    @if (auth()->user()->id == $post->user_id)
                        {{-- <form action="{{ route('post.destroy', $post) }}" method="POST" class="me-2">
                            @csrf
                            @method('DELETE')
                            <button type='submit' class="edit"><i class="fa-solid fa-pen-to-square"></i></button>
                        </form> --}}
    
                        <!-- Edit Button -->
                        <div class="me-2">
                            <button class="edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $post->id }}"><i class="fa-solid fa-pen-to-square"></i></button>
                        </div>
                        <!-- Edit Modal -->
                        <div class="modal fade bg-black" id="editModal{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $post->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered bg-transparent" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $post->id }}">Edit Post</h5>
                                        <button type="button" class="close fs-3" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form enctype="multipart/form-data" id="editForm{{ $post->id }}" action="{{ route('post.update', $post) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <!-- Form fields for editing post content and image -->
                                            <div class="form-group">
                                                <label for="content">Content:</label>
                                                <textarea class="form-control resize-none" rows="7" id="content" name="content">{{ $post->content }}</textarea>
                                            </div>
                                            <!-- Display current image -->
                                            <div class="form-group mt-2">
                                                <label>Current Image:</label><br>
                                                <img src="{{ asset('storage/' . $post->image) }}" >
                                            </div>
                                            <div class="form-group edit-image mt-2">
                                                <label for="edit-image{{$post->id}}">
                                                    <i class="fa-solid fa-image"></i>
                                                    Other image
                                                </label>
                                                <input class="d-none" type="file" name="image" id="edit-image{{$post->id}}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
    
                        <script>
                            // Handle click event of edit button
                            $('#editModal{{ $post->id }}').on('shown.bs.modal', function () {
                                // Prepopulate form fields with current post data
                                var content = '{{ $post->content }}';
                                $('#editForm{{ $post->id }} #content').val(content);
                            });
                        </script>
    
    
                        <form action="{{ route('post.destroy', $post) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type='submit' class="delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    @endif
                </div>
                <hr class="my-3">
                <p class="my-2">{{$post->content}}</p>
                <div class="image my-2 flex justify-content-center">
                    <img class="" src="{{ asset('storage/'.$post->image)}}" alt="">
                </div>
                <div class="my-2 count-likes-comments text-gray-400 flex justify-content-between">
                    <small>{{$post->likes->count()}} Likes</small>
                    <small>{{$post->comments->count()}} Comments</small>
                </div>
                <hr>
                <div class="action my-2 flex gap-4 fs-5">
                    <a href="" class="like">
                        <i class="fa-regular fa-thumbs-up" style="transform:rotateY(180deg);"></i>
                        Like
                    </a>
                    <a href="" class="comment">
                        <i class="fa-regular fa-comments"></i>
                        Comment
                    </a>
                </div>
            </div>

        @endforeach
        {{-- <div class="col-10 col-md-8 col-lg-7 col-xl-6 mx-xl-5 mb-5 p-3 rounded-3">
            <div class="info flex gap-3 mb-2">
                <img class="rounded-circle" width="80px" height="80" src="https://images.ctfassets.net/h6goo9gw1hh6/2sNZtFAWOdP1lmQ33VwRN3/24e953b920a9cd0ff2e1d587742a2472/1-intro-photo-final.jpg?w=1200&h=992&fl=progressive&q=70&fm=jpg" alt="">
                <h4 class="position-relative w-100">
                   <a href="">Momen Ahmed</a>
                </h4>
            </div>
            <hr>
            <p class="my-2">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aperiam, perspiciatis, voluptatum minima aspernatur voluptates, autem soluta adipisci reprehenderit consequatur debitis natus excepturi dignissimos dolores nulla asperiores nemo nobis deserunt doloribus.</p>
            <img class="my-2" src="https://imgv3.fotor.com/images/blog-cover-image/10-profile-picture-ideas-to-make-you-stand-out.jpg" alt="">
            <div class="my-2 count-likes-comments text-gray-400 flex justify-content-between">
                <small>150 Likes</small>
                <small>20 Comments</small>
            </div>
            <hr>
            <div class="action my-2 flex gap-4 fs-5">
                <a href="" class="like">
                    <i class="fa-regular fa-thumbs-up" style="transform:rotateY(180deg);"></i>
                    Like
                </a>
                <a href="" class="comment">
                    <i class="fa-regular fa-comments"></i>
                    Comment
                </a>
            </div>
        </div> --}}
    </div>
</x-app-layout>
