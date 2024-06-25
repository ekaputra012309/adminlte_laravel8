<script>
    $('#pendingModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var url = button.data('url');
        var modal = $(this);
        modal.find('form').attr('action', url);
    });

    $('#selesaiModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var url = button.data('url');
        var modal = $(this);
        modal.find('form').attr('action', url);
    });

    $('.proses-action').on('click', function(event) {
        event.preventDefault();
        var url = $(this).data('url');
        $('<form>', {
            "method": "POST",
            "action": url
        }).append($('<input>', {
            "type": "hidden",
            "name": "_token",
            "value": "{{ csrf_token() }}"
        })).appendTo('body').submit();
    });
</script>
