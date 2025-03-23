<style>
    .single_comment_area .reply-btn {
        background-color: #007bff; /* Custom background color */
        color: #fff; /* Custom text color */
        padding: 10px 20px; /* Adjust padding */
        border-radius: 5px; /* Adjust border radius */
        border: none;
    }

    .single_comment_area .reply-btn:hover {
        background-color: #0056b3; /* Custom hover color */
    }
</style>

<section class="gazette-post-discussion-area section_padding_100 bg-gray">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Comment Area Start -->
                <div class="comment_area section_padding_50 clearfix">
                    <div class="gazette-heading">
                        <h4 class="font-bold">Discussion</h4>
                    </div>

                    <ol>
                        @foreach($comments as $comment)
                            <!-- Single Comment Area -->
                            <li class="single_comment_area">
                                @if($comment->parent_id == null)
                                    <div class="comment-wrapper d-md-flex align-items-start">
                                        <!-- Comment Meta -->
                                        <div class="comment-author">
                                            <img src="{{ $comment->user->photo->path ? asset('assets/img/' . $comment->user->photo->path) : asset('assets/frontend/img/core-img/favicon.ico') }}" alt="">
                                        </div>
                                        <!-- Comment Content -->
                                        <div class="comment-content">
                                            <h5>{{ $comment->user->name }}</h5>
                                            <span
                                                class="comment-date font-pt">{{ $comment->created_at->format('F j, Y') }}
                                            </span>
                                            <div>
                                                @if(isset($comment->parent->user))
                                                    <strong>
                                                        <span class="text-blue-500">@ {{ $comment->parent->user->name }}</span>
                                                    </strong>
                                                @endif
                                            </div>
                                            <p>
                                                {{ $comment->body }}
                                            </p>
                                            @auth
                                                <a class="reply-btn btn btn-primary" href="javascript:void(0);" data-comment-id="{{ $comment->id }}">
                                                    Reply <i class="fa fa-reply"></i>
                                                </a>

                                                {{--Edit Button--}}
                                                @if(auth()->id() === $comment->user_id)
                                                    <a class="edit-btn btn btn-success" href="javascript:void(0);" data-comment-id="{{ $comment->id }}">
                                                        Edit <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif

                                                <!-- Reply Form (Initially Hidden) -->
                                                <div class="reply-form" id="reply-form-{{ $comment->id }}" style="display: none; margin-left: 20px;">
                                                    <form action="{{ route('comments.store', $post->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                        <div class="form-group">
                                                            <textarea class="form-control" name="message" cols="30" rows="3" placeholder="Write your reply..."></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-sm">Submit Reply</button>
                                                        <button type="button" class="btn btn-secondary btn-sm cancel-reply" data-comment-id="{{ $comment->id }}">Cancel</button>
                                                    </form>
                                                </div>

                                                {{--Edit Form--}}
                                                @if(auth()->id() === $comment->user_id)
                                                    <div class="edit-form border p-2" id="edit-form-{{ $comment->id }}" style="display: none;">
                                                        <form action="{{ route('comments.update', ['post' => $post->id, 'comment' => $comment->id]) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="form-group">
                                                                <textarea class="form-control" name="body" rows="3">{{ $comment->body }}</textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                                            <button type="button" class="btn btn-secondary btn-sm cancel-edit" data-comment-id="{{ $comment->id }}">Cancel</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            @endauth

                                        </div>
                                    </div>
                                @endif
                                @if($comment->children->isNotEmpty())
                                    <ol class="children">
                                        @foreach($comment->children as $child)
                                            @include('components.frontend.comments.comment', ['comment' => $child, 'depth' => 0])
                                        @endforeach
                                    </ol>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>

                <!-- Leave A Comment -->
                <div class="leave-comment-area clearfix">
                    <div class="comment-form">
                        <div class="gazette-heading">
                            <h4 class="font-bold">leave a comment</h4>
                        </div>
                        <!-- Comment Form -->
                        @auth
                            <form action=" {{ route('comments.store', $post->id) }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <textarea class="form-control" name="message" id="message" cols="30" rows="10"
                                              placeholder="Leave your comment..."></textarea>
                                </div>
                                <button type="submit" class="btn leave-comment-btn">
                                    SUBMIT <i class="fa fa-angle-right ml-2"></i>
                                </button>
                            </form>
                        @else
                            <div class="alert alert-warning text-center">
                                <p>You must be logged in to leave a comment.</p>
                                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                                <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('scripts')
    <script>
        $(document).ready(function() {
            console.log("jQuery is loaded and DOM is ready!"); // Debugging check

            // Show the reply form when "Reply" is clicked
            $('.reply-btn').click(function() {
                var commentId = $(this).data('comment-id');
                console.log("Reply button clicked for comment ID:", commentId); // Debugging check

                // Hide any visible edit form
                $('#edit-form-' + commentId).slideUp();

                // Show/Hide the reply form
                $('#reply-form-' + commentId).slideToggle();
            });

            // Cancel reply (hide the form)
            $('.cancel-reply').click(function() {
                var commentId = $(this).data('comment-id');
                console.log("Cancel button clicked for comment ID:", commentId); // Debugging check

                $('#reply-form-' + commentId).slideUp(); // Hide the form
            });

            // Show the edit form when "Edit" is clicked
            $('.edit-btn').click(function() {
                var commentId = $(this).data('comment-id');
                console.log("Edit button clicked for comment ID:", commentId); // Debugging check

                // Hide any visible reply form
                $('#reply-form-' + commentId).slideUp();

                // Toggle visibility of the edit form
                $('#edit-form-' + commentId).slideToggle(); // Show/Hide the edit form
            });

            // Cancel edit (hide the edit form)
            $('.cancel-edit').click(function() {
                var commentId = $(this).data('comment-id');
                console.log("Cancel edit button clicked for comment ID:", commentId); // Debugging check

                $('#edit-form-' + commentId).slideUp(); // Hide the edit form
            });
        });
    </script>
@endsection
