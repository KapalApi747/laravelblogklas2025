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
                                            @if(isset($comment->parent->user))
                                                <span class="text-gray-500">@ {{ $comment->parent->user->name }}</span>
                                            @endif
                                            <p>{{ $comment->body }}</p>
                                            @auth
                                                <a class="reply-btn" href="javascript:void(0);" data-comment-id="{{ $comment->id }}">
                                                    Reply <i class="fa fa-reply"></i>
                                                </a>

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

                    {{--<!-- Reply Modal -->
                    <div class="modal" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="replyModalLabel">Reply to Comment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('comments.store', $post->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="parent_id" id="parent_id">
                                    <div class="modal-body">
                                        <div class="form-group">
                                                <textarea class="form-control" name="message" id="message" cols="30"
                                                          rows="5" placeholder="Write your reply..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                        <button type="submit" class="btn btn-primary">Submit Reply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>--}}
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
        /*$(document).ready(function() {
            $('.reply-btn').click(function() {
                var commentId = $(this).data('comment-id');  // Get the correct comment ID

                // Set the hidden input field inside the modal to the correct parent ID
                $('#parent_id').val(commentId);

                // Show the reply modal
                $('#replyModal').modal('show');
            });
        });*/

        $(document).ready(function() {
            console.log("jQuery is loaded and DOM is ready!"); // Debugging check

            // Show the reply form when "Reply" is clicked
            $('.reply-btn').click(function() {
                var commentId = $(this).data('comment-id');
                console.log("Reply button clicked for comment ID:", commentId); // Debugging check

                $('#reply-form-' + commentId).slideToggle(); // Show/Hide the reply form
            });

            // Cancel reply (hide the form)
            $('.cancel-reply').click(function() {
                var commentId = $(this).data('comment-id');
                console.log("Cancel button clicked for comment ID:", commentId); // Debugging check

                $('#reply-form-' + commentId).slideUp(); // Hide the form
            });
        });


    </script>
@endsection
