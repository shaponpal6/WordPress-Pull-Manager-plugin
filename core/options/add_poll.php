<div >
   <table class="form-table" role="presentation">

        <tbody>
        <tr>
            <th scope="row"><label for="blogname">Add Questions</label></th>
            <td id="sp_poll_container">
                <?php
                $polls = get_option('sp_poll_manager_questions');
                if (isset($polls) && !empty($polls)){
                    foreach ($polls as $poll){
                        echo '<div class="sp_poll_sp_text"><strong>Special Text and Question: </strong></div>';
                        echo '<input class="sp_poll_field regular-text" type="text" value="'.$poll.'">';
                        echo '<div class="description sp_poll_answer">Answer: Excellent, Good, Bad</div>';
                    }
                }else{
                    echo '<div class="sp_poll_sp_text"><strong>Special Text and Question: </strong></div>';
                    echo '<input class="sp_poll_field regular-text" type="text">';
                    echo '<div class="description sp_poll_answer">Answer: Excellent, Good, Bad</div>';
                }
                ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="blogname"></label></th>
            <td>
                <div id="sp_poll_add" class="button button-primary">Add new</div>
            </td>
        </tr>

        </tbody>
    </table>


    <p class="submit">
        <button id="sp_poll_submit" class="button button-primary">Save Changes</button>
    </p>
</div>