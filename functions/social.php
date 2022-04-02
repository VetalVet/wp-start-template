<?php
function wayup_get_share($type = 'fb', $permalink = false, $title = false) {
    if (!$permalink) {
        $permalink = get_permalink();
    }
    if (!$title) {
        $title = get_the_title();
    }
    switch ($type) {
        case 'twi':
            return 'http://twitter.com/home?status=' . $title . '+-+' . $permalink;
            break;
        case 'fb':
            return 'http://www.facebook.com/sharer.php?u=' . $permalink . '&t=' . $title;
            break;
        case 'vk':
            return 'http://vk.com/share.php?url=' . $permalink . '&title=' . $title . '&comment=';//.get_the_content();
            break;
        default:
            return '';
    }
}