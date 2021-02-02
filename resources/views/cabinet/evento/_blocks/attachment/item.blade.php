<li class="nav-item">
    <div class="nav-link mr-3">
        <a href="{{ route('cabinet.evento.attachment.download', $attachment['evento_attachment_id']) }}" target="">
            {{$attachment['evento_attachment_originalname']}}
        </a>
        <a href="{{ route('cabinet.evento.attachment.destroyAndBack', $attachment['evento_attachment_id']) }}" class="ml-3 text-danger attachment_delete"
            data-attachmentId="{{ $attachment['evento_attachment_id'] }}"
        >
            delete
        </a>
    </div>
</li>
