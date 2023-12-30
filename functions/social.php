<?php
function wayup_get_share($type = 'fb', $permalink = false, $title = false, $excerpt = false) {
    if (!$permalink) {
        $permalink = get_permalink();
    }
    if (!$title) {
        $title = get_the_title();
    }
    if (!$excerpt) {
        $excerpt = get_the_excerpt();
    }
    switch ($type) {
        // case 'twi':
        //     return 'http://twitter.com/home?status=' . $title . '+-+' . $permalink;
        //     break;
        // case 'fb':
        //     return 'http://www.facebook.com/sharer.php?u=' . $permalink . '&t=' . $title;
        //     break;
        // case 'vk':
        //     return 'http://vk.com/share.php?url=' . $permalink . '&title=' . $title . '&comment=';//.get_the_content();
        //     break;
        // case 'li':
        //     return 'http://www.linkedin.com/shareArticle?mini=true&url=' . $permalink . '&title=' . $title;//.get_the_content();
        //     // 'http://www.linkedin.com/shareArticle?mini=true&url= . $permalink .  &title= . How%20to%20make%20custom%20linkedin%20share%20button&summary=some%20summary%20if%20you%20want . &source= . stackoverflow.com'
        //     break;
    

        case 'twi':
            return 'http://twitter.com/home?status=' . esc_attr($title) . '+-+' . esc_url($permalink);
            break;
        case 'fb':
            return 'http://www.facebook.com/sharer.php?u=' . esc_url($permalink) . '&t=' . esc_attr($title);
            break;
        case 'goglp':
            return 'https://plus.google.com/share?url='. urlencode(esc_url($permalink));
            break;
        case 'vk':
            return 'http://vkontakte.ru/share.php?url='. urlencode(esc_url($permalink)).'&title='.esc_attr($title).'&description='.esc_attr($excerpt);
            break;
        case 'pin':
            return 'http://pinterest.com/pin/create/button/?url='. urlencode(esc_url($permalink)).'&description='.esc_attr($excerpt).'&media='.urlencode(esc_url($image_url));
            break;
        case 'red':
            return 'http://reddit.com/submit?url='. urlencode(esc_url($permalink)).'&title='.esc_attr($title);
            break;
        case 'lin':
            return 'https://www.linkedin.com/shareArticle?mini=true&url='. urlencode(esc_url($permalink)).'&title='.esc_attr($title).'&summary='.esc_attr($excerpt);
            break;
        default:
            return '';
    }
}