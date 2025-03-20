<x-frontend.content.post.single-post-area :post="$post"/>
<x-frontend.content.post.discussion-area :post="$post" :comments="$comments"/>

<!-- Add jQuery before Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')


