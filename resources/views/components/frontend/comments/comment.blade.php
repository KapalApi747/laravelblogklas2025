<li class="single_comment_area" style="margin-left: {{ $depth * 20 }}px;">
    <div class="comment-wrapper d-md-flex align-items-start">
        <div class="comment-author">
            <img src="{{ $comment->user->photo->path ? asset('assets/img/' . $comment->user->photo->path) : asset('assets/frontend/img/core-img/favicon.ico') }}" alt="">
        </div>
        <div class="comment-content">
            <h5>{{ $comment->user->name }}</h5>
            <span class="comment-date text-muted">{{ $comment->created_at->format('F j, Y') }}</span>
            <p>{{ $comment->body }}</p>
            @auth
                <div class="mb-5">
                    <a class="reply-btn" href="javascript:void(0);" data-comment-id="{{ $comment->id }}">
                        Reply <i class="fa fa-reply"></i>
                    </a>
                </div>
                <!-- Reply Form (Initially Hidden) -->
                <div class="reply-form border border-1" id="reply-form-{{ $comment->id }}" style="display: none;">
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

    <!-- If there are child comments, recursively display them -->
    @if($comment->children->isNotEmpty())
        <ol class="children">
            @foreach($comment->children as $child)
                @include('components.frontend.comments.comment', ['comment' => $child, 'depth' => ($depth ?? 0) + 1])
            @endforeach
        </ol>
    @endif
</li>
