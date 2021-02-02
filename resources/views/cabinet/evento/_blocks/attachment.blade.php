<div class="attachments">
    @if(count($evento['attachments']))
        <nav class="navbar">
            <ul class="navbar-nav flex-row">
                @each('cabinet.evento._blocks.attachment.item', $evento['attachments'], 'attachment')
            </ul>
        </nav>
    @endif
</div>