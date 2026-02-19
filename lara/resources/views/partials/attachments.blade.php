<div class="attachments-section">
    <h3>Прикреплённые файлы ({{ $submission->attachments->count() }}/3)</h3>

    @forelse($submission->attachments as $attachment)
        <div class="attachment-item">
            <div>
                <strong>{{ $attachment->original_name }}</strong>
                <br>
                <small>
                    Размер: {{ round($attachment->size / 1024, 2) }} KB
                    | Статус: 
                    <span class="status-badge status-{{ $attachment->status }}">
                        {{ $attachment->status }}
                    </span>
                </small>
                @if($attachment->rejection_reason)
                    <br>
                    <small style="color: #f44336;">Причина: {{ $attachment->rejection_reason }}</small>
                @endif
            </div>
            <div>
                <a href="{{ route('attachments.download', $attachment) }}" class="btn btn-small">Скачать</a>
                @if(Auth::id() === $submission->user_id && in_array($attachment->status, ['pending', 'rejected']))
                    <form method="POST" action="{{ route('attachments.destroy', $attachment) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-small btn-beige" onclick="return confirm('Удалить файл?')">Удалить</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p>Файлы не загружены</p>
    @endforelse

    @if(Auth::id() === $submission->user_id && in_array($submission->status, ['draft', 'needs_fix']) && $submission->attachments->count() < 3)
        <hr>
        <form method="POST" action="{{ route('attachments.upload', $submission) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Загрузить файл (PDF, ZIP, PNG, JPG до 10MB)</label>
                <input type="file" name="file" id="file" accept=".pdf,.zip,.png,.jpg,.jpeg" required>
            </div>
            <button type="submit" class="btn">Загрузить</button>
        </form>
    @endif
</div>