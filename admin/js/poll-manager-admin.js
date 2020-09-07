(function ($) {
    'use strict';
    $(document).ready(function () {
        var sp_poll_add = document.querySelector('#sp_poll_add');
        if (sp_poll_add) {
            var sp_poll_container = document.querySelector('#sp_poll_container');
            var sp_poll_submit = document.querySelector('#sp_poll_submit');


            // Event
            sp_poll_add.addEventListener('click', function (e) {
                var input = document.createElement('INPUT');
                input.setAttribute('class', 'sp_poll_field regular-text');
                input.setAttribute('type', 'text');
                input.setAttribute('data-id', '');
                sp_poll_container.appendChild(input);
            });


            // Submit
            sp_poll_submit.addEventListener('click', function (e) {
                e.preventDefault();
                var polls = [];
                $('.sp_poll_field').each(function () {
                    if ($(this).val() != '') polls.push($(this).val());
                });
                // console.log(polls);

                var data = {
                    // 'action': 'sp_poll_admin_ajax',
                    'polls': polls,
                };

                var url = new URL(window.location.href);
                url.searchParams.set('sp_poll_add', 'poll');
                // console.log(url);
                // console.log(url.href);

                // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                jQuery.post(url.href, data, function (response) {
                    // console.log('Voted Completed: ' + response);
                    window.location.href = window.location.pathname + window.location.search + window.location.hash;
                    // creates a history entry
                });
            });

        }
    });
})(jQuery);
