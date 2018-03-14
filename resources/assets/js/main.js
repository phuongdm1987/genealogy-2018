$(document).ready(function ($) {
    $('#delete-person').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var action = button.data('action') // Extract info from data-* attributes
        var person_name = button.data('personName') // Extract info from data-* attributes

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('#delete-form').attr('action', action)
        modal.find('#person-name').text(person_name)
    })

    var data = [30, 86, 168, 281, 303, 365]
    d3.select('.chart')
        .selectAll('div')
        .data(data)
        .enter()
        .append('div')
        .style('width', function(d) { return d + 'px'; })
        .text(function(d) { return d; });
})