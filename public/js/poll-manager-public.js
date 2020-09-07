(function ($) {
    'use strict';
    $(document).ready(function () {
        var check = document.querySelectorAll('.sp-poll-holder');
        if (check) {
            setTimeout(function start() {

                $('.sp-poll-bar').each(function (i) {
                    var $bar = $(this);
                    var $voting = $bar.children()[2];

                    $voting.addEventListener('click', function (e) {
                        var target = e.target.previousElementSibling.dataset.vote;
                        e.target.previousElementSibling.dataset.vote = parseInt(target) + 1;
                        var poll = e.target.dataset;
                        var name = e.target.offsetParent.parentNode.dataset.name;
                        var data = {
                            'action': 'pool_action',
                            'key': poll.key,
                            'id': poll.id,
                        };

                        var url = new URL(window.location.href);
                        url.searchParams.set('sp_poll_vote', data.key);
                        url.searchParams.set('sp_poll_vote_id', data.id);

                        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                        jQuery.get(url.href, function (response) {
                            setCookie(name, poll.question, 1);
                            return sp_poll_target(e.target.offsetParent.parentNode);
                        });
                    });


                });

                function sp_poll_target(target) {
                    var node = target;
                    // Check Current user Voted or not
                    var name = node.dataset.name;
                    if (getCookie(name) != '') {
                        node.querySelector('.sp-poll-voted').innerHTML = 'You have Voted: ' + getCookie(name);
                        disable_vote(node);
                    }
                    var votes = 0, question = 0;
                    // var polls = $('.sp-poll-holder .sp-poll-percent')
                    var polls = node.querySelectorAll('.sp-poll-holder .sp-poll-percent')
                    polls.forEach(function (ele) {
                        var vote = parseInt(ele.parentNode.dataset.vote);
                        question += 1;
                        votes += !isNaN(vote) ? vote : 0;
                    });

                    polls.forEach(function (ele) {
                        var vote = parseInt(ele.parentNode.dataset.vote);
                        var percent = !isNaN(vote) && vote > 0 ? ((vote * 100) / votes) : 0;
                        $(ele).prop('Counter', 0).animate({
                            Counter: percent
                        }, {
                            duration: 2000,
                            easing: 'swing',
                            step: function (now) {
                                // if (now > 0) $(this).text(Math.ceil(now) +'%');
                                if (now > 0) $(this).text(now.toFixed(0) + '%');
                                $(this).css('width', now + '%');
                            }
                        });
                    });

                }

                function sp_poll() {
                    // Check Current user Voted or not
                    var name = $('.sp-poll-holder').attr('data-name');
                    if (getCookie(name) != '') {
                        $('.sp-poll-voted').text('You have Voted: ' + getCookie(name));
                        disable_vote();
                    }
                    var votes = 0, question = 0;
                    // console.log('clicked')
                    var polls = $('.sp-poll-holder .sp-poll-percent')
                    polls.each(function () {
                        var vote = parseInt($(this).parent('.sp-poll-count').attr('data-vote'));
                        question += 1;
                        votes += !isNaN(vote) ? vote : 0;
                    });
                    // console.log('questen', question);
                    // console.log('voye', votes);

                    polls.each(function () {
                        var vote = parseInt($(this).parent('.sp-poll-count').attr('data-vote'));
                        var percent = !isNaN(vote) && vote > 0 ? ((vote * 100) / votes) : 0;
                        // console.log('persent', percent);
                        $(this).prop('Counter', 0).animate({
                            Counter: percent
                        }, {
                            duration: 2000,
                            easing: 'swing',
                            step: function (now) {
                                // if (now > 0) $(this).text(Math.ceil(now) +'%');
                                if (now > 0) $(this).text(now.toFixed(2) + '%');
                                $(this).css('width', now + '%');
                            }
                        });
                    });

                }

                // sp_poll();

                var tars = document.querySelectorAll('.sp-poll-holder');
                var sp_view_vote = document.querySelectorAll('.sp-view-vote');
                tars.forEach(function (ele) {
                    // var name = $('.sp-poll-holder').attr('data-name');
                    var name = ele.dataset.name;
                    if (getCookie(name) !== '') {
                        return sp_poll_target(ele);
                    }
                });

                sp_view_vote.forEach(function (vote) {
                    vote.addEventListener('click', function (e) {
                        var ele = e.target.parentNode;
                        return sp_poll_target(ele);
                    });
                });


                function disable_vote(target) {
                    var tars = target.querySelectorAll('.sp-vote')
                    $(tars).each(function () {
                        $(this).remove();
                    });
                }

                function setCookie(cname, cvalue, exdays) {
                    var d = new Date();
                    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                    var expires = "expires=" + d.toUTCString();
                    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                }

                function getCookie(cname) {
                    var name = cname + "=";
                    var decodedCookie = decodeURIComponent(document.cookie);
                    var ca = decodedCookie.split(';');
                    for (var i = 0; i < ca.length; i++) {
                        var c = ca[i];
                        while (c.charAt(0) == ' ') {
                            c = c.substring(1);
                        }
                        if (c.indexOf(name) == 0) {
                            return c.substring(name.length, c.length);
                        }
                    }
                    return "";
                }

            }, 200);
        }
    });
})(jQuery);
