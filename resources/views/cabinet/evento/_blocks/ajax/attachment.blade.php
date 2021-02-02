@if(count($attachments))
    <nav class="navbar">
        <ul class="navbar-nav flex-row">
            @each('cabinet.evento._blocks.ajax.attachment.item', $attachments, 'attachment')
        </ul>
    </nav>
@endif