$(function() { // Shorthand for $( document ).ready()
    "use strict";
    // Your js script is below this line
    // --------------------------------------------------------------------- //

    // Example
    console.log( "ready!" );

    // search functionality in order-list page
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#order-list-tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
});

