<?php

class poll_manager_display
{
    function __construct()
    {
        add_action('init', function () {
            add_shortcode('poll_manager', array($this, 'make_poll'));
        });
        add_filter('use_block_editor_for_post', '__return_false');

//        add_filter('the_content', array($this, 'poll_display'));

        if ((isset($_GET['sp_poll_vote']) && $_GET['sp_poll_vote'] != '') && (isset($_GET['sp_poll_vote_id']) && $_GET['sp_poll_vote_id'] != '')) {
            $this->polling($_GET['sp_poll_vote_id'], $_GET['sp_poll_vote']);
        }

    }

    function make_poll()
    {
//        $poll = get_post_meta(get_the_ID(), 'sp_poll', true);
        $poll = get_option('sp_poll_manager_questions');
        if (!isset($poll) || empty($poll)) return '';
        ob_start();
        if (isset($poll)) {
            for ($i = 0; $i < count($poll); $i++) {
                $vote = get_post_meta(get_the_ID(), 'sp_poll_' . $i . '_vote', true);
                $vote1 = get_post_meta(get_the_ID(), 'sp_poll_' . $i . '_vote_excellent', true);
                $vote2 = get_post_meta(get_the_ID(), 'sp_poll_' . $i . '_vote_good', true);
                $vote3 = get_post_meta(get_the_ID(), 'sp_poll_' . $i . '_vote_bad', true);
                ?>
                <div class="sp-poll-wrap">
                    <div class="sp-poll-holder" data-name="sp_poll_manager_<?php echo get_the_ID().'_'.$i; ?>">
                        <div class="sp-poll-question"><?php echo $poll[$i]; ?></div>
                        <div class="sp-poll-voted"></div>


                        <div class="sp-poll-bar cf" data-vote="<?php echo isset($vote1) && $vote1 != '' ? $vote1 : 0; ?>">
                            <div class="sp-poll-label">Excellent</div>
                            <div class="sp-poll-count"
                                 data-vote="<?php echo isset($vote1) && $vote1 != '' ? $vote1 : 0; ?>"><span
                                        class="sp-poll-percent"></span></div>
                            <div class="sp-vote" data-question="Excellent"
                                 data-name="sp_poll_manager_<?php echo get_the_ID(); ?>"
                                 data-key="sp_poll_<?php echo $i; ?>_vote_excellent" data-id="<?php echo get_the_ID(); ?>">Vote
                            </div>
                        </div>


                        <div class="sp-poll-bar cf" data-vote="<?php echo isset($vote2) && $vote2 != '' ? $vote2 : 0; ?>">
                            <div class="sp-poll-label">Good</div>
                            <div class="sp-poll-count"
                                 data-vote="<?php echo isset($vote2) && $vote2 != '' ? $vote2 : 0; ?>"><span
                                        class="sp-poll-percent"></span></div>
                            <div class="sp-vote" data-question="Good"
                                 data-name="sp_poll_manager_<?php echo get_the_ID(); ?>"
                                 data-key="sp_poll_<?php echo $i; ?>_vote_good" data-id="<?php echo get_the_ID(); ?>">Vote
                            </div>
                        </div>


                        <div class="sp-poll-bar cf" data-vote="<?php echo isset($vote3) && $vote3 != '' ? $vote3 : 0; ?>">
                            <div class="sp-poll-label">Bad</div>
                            <div class="sp-poll-count"
                                 data-vote="<?php echo isset($vote3) && $vote3 != '' ? $vote3 : 0; ?>"><span
                                        class="sp-poll-percent"></span></div>
                            <div class="sp-vote" data-question="Bad"
                                 data-name="sp_poll_manager_<?php echo get_the_ID(); ?>"
                                 data-key="sp_poll_<?php echo $i; ?>_vote_bad" data-id="<?php echo get_the_ID(); ?>">Vote
                            </div>
                        </div>


                        <div class="sp-view-vote">View Vote</div>



                    </div>
                </div>
            <?php }
        }
        return ob_get_clean();
    }

    function poll_display($content)
    {
        if (is_page() || is_single()) {
            $fullcontent = $content . $this->make_poll();
        } else {
            $fullcontent = $content;
        }


        return $fullcontent;
    }

    function polling($id, $key)
    {
        if ($key === '' || $id === '') return 0;
        $val = get_post_meta($id, $key, true);
        if (isset($val)) {
            $new = (int)$val;
            update_post_meta($id, $key, ($new + 1));
        } else {
            add_post_meta($id, $key, 1);
        }
    }
}

return new poll_manager_display();