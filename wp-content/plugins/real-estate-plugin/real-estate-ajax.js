jQuery(document).ready(function($) {
    function performSearch() {
        var page = $('#pages').text();
        var nextpage = $('#nextpages').val();
        if (page === '') {
            page = '1';
        }
        if (nextpage > '1') {
            page = nextpage;
        }
        console.log(page);

        const searchParams = {
            district: $('#district-input').val(),
            house_name: $('#house-name-input').val(),
            house_type: $('input[name="house-type"]:checked').val(),
            house_coordinates: $('#house-coordinates-input').val(),
            house_floors: $('#house-floors-input').val(),
            page: page
        };

        $.ajax({
            url: 'http://localhost/wordpresstest/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'real_estate_search',
                search_params: searchParams
            },
            beforeSend: function() {
                $('#widget-body').html('Завантаження...');
            },
            success: function(response) {
                $('#widget-body').html(response);
            },
            error: function() {
                $('#widget-body').html('Сталася помилка.');
            }
        });
    }

    // Привязываем событие клика к родительскому элементу
    $('#widget-body').on('click', '#nextpages', function(e) {
        e.preventDefault();
        performSearch();
    });

    // Привязываем событие клика к кнопке поиска
    $('#real-estate-search-button').on('click', function(e) {
        e.preventDefault();
        performSearch();
    });
});
