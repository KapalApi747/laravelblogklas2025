<style>
    .single_comment_area .reply-btn {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
    }

    .single_comment_area .reply-btn:hover {
        background-color: #0056b3;
    }
</style>

<li class="single_comment_area" style="margin-left: {{ $depth * 20 }}px;">
    <div class="comment-wrapper d-md-flex align-items-start">
        <div class="comment-author">
            <img src="{{ $comment->user->photo->path === 'https://placehold.co/640x480' ? 'https://placehold.co/60' : asset('assets/img/' . $comment->user->photo->path)}}" alt="">
        </div>
        <div class="comment-content">
            <h5>{{ $comment->user->name }}</h5>
            <span class="comment-date text-muted">{{ $comment->created_at->format('F j, Y') }}</span>
            <div>
                @if(isset($comment->parent->user))
                    <strong>
                        <span>@ {{ $comment->parent->user->name }}</span>
                    </strong>
                @endif
            </div>
            <p>
                {{ $comment->body }}
            </p>
            @auth
                <div class="mb-5">
                    {{--Reply Button--}}
                    <a class="reply-btn btn btn-primary" href="javascript:void(0);" data-comment-id="{{ $comment->id }}">
                        Reply <i class="fa fa-reply"></i>
                    </a>

                    {{--Edit Button--}}
                    @if(auth()->id() === $comment->user_id)
                        <a class="edit-btn btn btn-success" href="javascript:void(0);" data-comment-id="{{ $comment->id }}">
                            Edit <i class="fa fa-edit"></i>
                        </a>
                    @endif
                </div>

                {{--Reply Form--}}
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

    <!-- If there are child comments, recursively display them -->
    @if($comment->children->isNotEmpty())
        <ol class="children">
            @foreach($comment->children as $child)
                @include('components.frontend.comments.comment', ['comment' => $child, 'depth' => ($depth ?? 0) + 1])
            @endforeach
        </ol>
    @endif
</li>
