<li class="nav-item">
    <div class="nav-link mr-3">
        <a href="{{ route('cabinet.evento.attachment.download', $attachment->id) }}" target="">
            {{ $attachment->originalname }}
        </a>
        <a href="{{ route('cabinet.evento.attachment.destroyAndBack', $attachment->id) }}" class="ml-3 text-danger attachment_delete"
            data-attachmentId="{{ $attachment->id }}"
        >
            delete
        </a>
    </div>
</li>