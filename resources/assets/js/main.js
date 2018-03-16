$(document).ready(function ($) {
    $('#delete-person').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let action = button.data('action'); // Extract info from data-* attributes
        let person_name = button.data('personName'); // Extract info from data-* attributes

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        let modal = $(this);
        modal.find('#delete-form').attr('action', action);
        modal.find('#person-name').text(person_name)
    })
});