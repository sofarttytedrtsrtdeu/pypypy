<div class="comments-section">
    <h3>Комментарии</h3>

    @forelse($submission->comments as $comment)
        <div class="comment">
            <div class="comment-meta">
                <strong>{{ $comment->user->name }}</strong> 
                ({{ $comment->user->role }}) - 
                {{ $comment->created_at->diffForHumans() }}
            </div>
            <div class="comment-body">
                {{ $comment->body }}
            </div>
        </div>
    @empty
        <p>Комментариев пока нет</p>
    @endforelse

    <hr>

    <form method="POST" action="{{ route('comments.store', $submission) }}">
        @csrf
        <div class="form-group">
            <label for="comment">Добавить комментарий</label>
            <textarea name="body" id="comment" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn">Отправить комментарий</button>
    </form>
</div>