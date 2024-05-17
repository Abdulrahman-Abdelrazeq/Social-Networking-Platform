<x-app-layout>

    <div class="new-post py-12 mt-20 row justify-content-center text-white">
        <div class="col-10 col-md-8 col-lg-7 col-xl-6 mx-xl-5 p-3 rounded-3">
            <form method="POST" action="{{route('post.store')}}" enctype="multipart/form-data">
                @csrf

                <div class="flex mb-3 justify-content-between">
                    <a href="{{route('user.show', auth()->user()->id)}}"><div class="profile-image" style="background-image: url('{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1200px-User_icon_2.svg.png' }}');"></div></a>
                    <textarea name="content" placeholder="Create a new post..."></textarea>
                </div>
                <div class="flex justify-content-between">
                    <label for="new-post-image">
                        <i class="fa-solid fa-image"></i>
                        Image
                    </label>
                    <input class="d-none" type="file" name="image" id="new-post-image">
                    <button onclick="localStorage.setItem('scrollPosition', 0);" type="submit" class="btn btn-primary">Post</button>
                </div>
            </form>
        </div>
    </div>
    <div class="all-posts py-12 row justify-content-center text-white">
        @foreach ($posts as $post)
        <div class="col-10 col-md-8 col-lg-7 col-xl-6 mx-xl-5 mb-4 p-3 rounded-3">

            <div class="info flex justify-content-between mb-2">
                <a href="{{route('user.show', $post->user->id)}}"><div class="profile-image" style="background-image: url('{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1200px-User_icon_2.svg.png' }}');"></div></a>
                <div class="flex flex-1">
                    <div class="flex gap3 flex-1">
                        <h4 class="position-relative w-100">
                           <a href="{{route('user.show', $post->user->id)}}">
                            @php
                            $nameParts = explode(' ', $post->user->name);
                            $firstTwoWords = implode(' ', array_slice($nameParts, 0, 2));
                            @endphp
                            {{ $firstTwoWords }}
                            </a>
                        </h4>
                    </div>
                    <p class="pe-3">{{$post->created_at->format('F j, Y \a\t g:i A')}}</p>
                </div>
                @if (auth()->user()->id == $post->user_id)

                    <!-- Edit Button -->
                    <div class="me-2">
                        <button class="edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $post->id }}"><i class="fa-solid fa-pen-to-square"></i></button>
                    </div>
                    <!-- Edit Modal -->
                    <div class="modal fade bg-transparent" id="editModal{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="editpost{{ $post->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered bg-transparent" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editpost{{ $post->id }}">Edit Post</h5>
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
                                            <label for="edit-content">Content:</label>
                                            <textarea class="form-control resize-none" rows="7" id="edit-content" name="content">{{ $post->content }}</textarea>
                                        </div>
                                        <!-- Display current image -->
                                        <div class="form-group mt-2">
                                            <label>Current Image:</label><br>
                                            @if($post->image != null)
                                                <img src="{{ asset('storage/'.$post->image) }}" >
                                            @endif
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


                    <form class="delete-post-form" action="{{ route('post.destroy', $post) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type='button' class="delete" data-bs-toggle="modal" data-bs-target="#deletepost{{$post->id}}"><i class="fa-solid fa-trash"></i></button>
                        <!-- Modal for delete -->
                        <div class="modal fade bg-transparent" id="deletepost{{$post->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered bg-transparent">
                            <div class="modal-content" style="background-color: var(--main-color);">
                                <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Delete post</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                Are you sure?
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Yes</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
            <hr class="my-3">
            <p class="my-2">{{$post->content}}</p>
            <div class="image my-2 flex justify-content-center">
                <img class="" src="{{ asset('storage/'.$post->image)}}" alt="">
            </div>
            <div class="my-2 count-likes-comments text-gray-400 flex justify-content-between">

                <!-- Button trigger modal for Likes -->
                <a class="like-count cursor-pointer" data-post-id="{{ $post->id }}" data-bs-toggle="modal" data-bs-target="#likedUsersModal{{$post->id}}">{{ $post->likes()->count() }} Likes</a>

                <small>{{$post->comments->count()}} Comments</small>
            </div>
            <hr>
            <div class="action my-2 flex gap-4 fs-5">
                <a href="" class="like btn-like{{ $post->isLikedBy(auth()->user()) ? ' active' : '' }}" data-post-id="{{ $post->id }}"> 
                    <i class="fa-regular fa-thumbs-up" style="transform:rotateY(180deg);"></i>
                    Like
                </a>
                
                <a class="comment">
                    <i class="fa-regular fa-comments"></i>
                    Comment
                </a>
            </div>

            
            <!-- Modal For Likes -->
            <div class="modal fade bg-transparent" id="likedUsersModal{{$post->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered bg-transparent">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">People who like it</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body liked-users-list"></div>
                </div>
                </div>
            </div>


            <div class="new-comment mt-4 text-white">
                <div class="rounded-3">
                    <form class="comment-form flex align-items-center position-relative" method="POST" action="{{route('comment.store')}}" enctype="multipart/form-data">
                        @csrf
                        <!-- Hidden input field for post_id -->
                        <input type="hidden" name="post_id" value="{{ $post->id }}">

                        <div class="flex align-items-center flex-1">
                            <a href="{{route('user.show', auth()->user()->id)}}"><div class="profile-image" style="background-image: url('{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1200px-User_icon_2.svg.png' }}');"></div></a>
                            <textarea name="content" placeholder="Write a comment..." style="padding-right: 80px;"></textarea>
                        </div>
                        <div class="flex align-items-center position-absolute right-0 h-100 bg-transparent">
                            <label for="comment-image{{$post->id}}" class="bg-transparent border-0">
                                <i class="fa-solid fa-image"></i>
                                Image
                            </label>
                            <input class="d-none" type="file" name="image" id="comment-image{{$post->id}}">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Container to display comments -->
            <div class="comments-container" {{-- style="display: none;" --}}>
                @foreach ($comments as $comment)
                    @if ($comment->post_id == $post->id)
                        <div class="flex justify-content-between align-items-center bg-gray-700 rounded-top mt-4">
                            <div class="flex flex-1 gap3 mt-3 align-items-center">
                                <a href="{{route('user.show', $comment->user->id)}}"><div class="profile-image" style="background-image: url('{{ $comment->user->profile_picture ? asset('storage/' . $comment->user->profile_picture) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1200px-User_icon_2.svg.png' }}');"></div></a>
                                <h6 class="position-relative">
                                    <a href="{{route('user.show', $comment->user->id)}}">
                                        @php
                                        $nameParts = explode(' ', $comment->user->name);
                                        $firstTwoWords = implode(' ', array_slice($nameParts, 0, 2));
                                        @endphp
                                        {{ $firstTwoWords }}
                                    </a>
                                </h6>
                            </div>
                            <div class="flex me-3">
                                <p class="pe-3"><small>{{$comment->created_at->format('F j, Y \a\t g:i A')}}</small></p>

                                @if (auth()->user()->id == $comment->user->id)
                                <form class="delete-comment-form" action="{{ route('comment.destroy', $comment) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <!-- Button trigger modal -->
                                    <button type='button' class="delete" data-bs-toggle="modal" data-bs-target="#deletecomment{{$comment->id}}"><i class="fa-solid fa-trash"></i></button>
                                    
                                    <!-- Modal for delete -->
                                    <div class="modal fade bg-transparent" id="deletecomment{{$comment->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered bg-transparent">
                                        <div class="modal-content testttt" style="background-color: var(--main-color);">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Delete comment</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            Are you sure?
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Yes</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </form>
                                @endif
                            </div>
                        </div>
                        <div class="bg-gray-700 rounded-bottom p-3">
                            {{$comment->content}}
                            <div class="image my-2 flex justify-content-center w-75">
                                <img class="" src="{{ asset('storage/'.$comment->image)}}" alt="">
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>
        @endforeach
            <script>

                
                $(document).ready(function() {
                    // Restore scroll position after page reload
                    setTimeout(() => {
                        if($(document).scrollTop() == 0){
                            var scrollPosition = localStorage.getItem('scrollPosition');
                            if (scrollPosition !== null) {
                                $(window).scrollTop(scrollPosition);
                            }
                        }
                    }, 300);

                        
                    $('.like-count').on('click', function(e) {
                        e.preventDefault();
                        var postId = $(this).data('post-id');
                        
                        
                        // Make AJAX request to fetch liked users
                        $.ajax({
                            type: 'GET',
                            url: '/posts/' + postId + '/liked-users',
                            success: function(response) {
                                var likedUsersList = $('.liked-users-list');
                                likedUsersList.empty(); // Clear previous list
                                
                                // Populate modal with liked users
                                $.each(response.users, function(index, user) {
                                    console.log('User:', user);
                                    likedUsersList.append('<div class=flex align-items-center mb-2" style="gap: 10px;" ><a class="rounded-circle" href=""><img width="80px" height="80" src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1200px-User_icon_2.svg.png" alt=""></a><h4 class="position-relative flex align-items-center w-100"><a href="">' + user.user.name + '</a></h4></div>');
                                });
                                
                                // Open the modal
                                $('#likedUsersModal').modal('show');
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    });
                    
                    
                    $('.btn-like').on('click', function() {
                        var postId = $(this).data('post-id');
                        var button = $(this);

                        // Store scroll position before page reload
                        var scrollPosition = $(window).scrollTop();
                        localStorage.setItem('scrollPosition', scrollPosition);

                        $.ajax({
                            type: 'POST',
                            url: '/posts/' + postId + '/like',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    if (response.liked) {
                                        button.addClass('active');
                                    } else {
                                        button.removeClass('active');
                                    }
                                    window.location.reload();
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });

                    });




                    // Handle Enter key press event in the comment form
                    $('.comment-form textarea').on('keypress', function(event) {
                        if (event.keyCode === 13 && !event.shiftKey) { // Enter key pressed
                            event.preventDefault(); // Prevent form submission
                            var form = $(this).closest('form');

                            // Store scroll position before page reload
                            var scrollPosition = $(window).scrollTop();
                            localStorage.setItem('scrollPosition', scrollPosition);

                            // Access postId from the data attribute of the form
                            postId = form.data('post-id');
                            var formData = new FormData(form[0]); // Create FormData object from form data
                            // Make AJAX request to submit the comment
                            $.ajax({
                                type: 'POST',
                                url: form.attr('action'),
                                data: formData,
                                contentType: false, // Prevent jQuery from setting content type
                                processData: false, // Prevent jQuery from processing the data
                                success: function(response) {
                                    // Clear the comment textarea after successful submission
                                    form.find('textarea[name="content"]').val('');
                                    // Append the new comment to the DOM under the corresponding post
                                    var commentsContainer = $('#commentsContainer' + postId);
                                    commentsContainer.append('<div class="comment">' + response.comment.content + '</div>');

                                    window.location.reload();

                                    // Restore scroll position
                                    // var scrollPosition = localStorage.getItem('scrollCommentPosition');
                                    // if (scrollPosition !== null) {
                                    //     $(window).scrollTop(scrollPosition);
                                    //     localStorage.removeItem('scrollCommentPosition'); // Clear stored scroll position
                                    // }
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            });
                        }
                    });


                    // Event listener for comment delete buttons
                    $('.delete-comment-form').submit(function(event) {
                        // Store the current scroll position
                        var scrollPosition = $(window).scrollTop();
                        localStorage.setItem('scrollPosition', scrollPosition);

                        // Continue with the form submission
                        return true;
                    });

                    // Event listener for post delete buttons
                    $('.delete-post-form').submit(function(event) {
                        // Store the current scroll position
                        var scrollPosition = $(window).scrollTop();
                        localStorage.setItem('scrollPosition', scrollPosition);

                        // Continue with the form submission
                        return true;
                    });



                });
            </script>

    </div>
</x-app-layout>
