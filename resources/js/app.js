require('./bootstrap');

// require('./jquery-ui');
// require('./jquery-sortable');

$( document ).ready(function() {
    $( function() {
        $( "#sort" ).sortable();
        $( "#sort" ).disableSelection();
      } );
$(function() {
    $(".sortable-posts").sortable({
        stop: function() {
        //     console.log("asdasd");
            $.map($(this).find('li'), function(el) {
                var id = el.id;
                var sorting = $(el).index();
                $.ajax({
                    url: 'sortPosts',
                    type: 'GET',
                    data: {
                        id: id,
                        sorting: sorting
                    },
                });
            });
        }
    });
});
});