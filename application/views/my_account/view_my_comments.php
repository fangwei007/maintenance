<?php
$this->load->view('my_account/includes/view_comment_bar');
switch ($source) {
    case 'others': //if comments is from my others' posts
        $this->load->view('my_account/comments/view_others_comments');
        break;

    case 'reply': //someone replyed my comments
        $this->load->view('my_account/comments/view_reply_comments');
        break;

    default:
        break;
}
?>
