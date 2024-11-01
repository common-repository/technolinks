<?php
/*
Plugin Name: TechnoLinks
Plugin URI: http://www.delymyth.net/index.php?p=4329
Description: Allows to get the incoming links list to a single post from <a href="http://www.technorati.com/">Technorati</a> to be displayed under every single post.
Based on the incoming links list from the Dashboard, modified to work for every single post.
Version: 1
Author: DElyMyth
Author URI: http://www.delymyth.net/
*/ 

function technolink($text) {
if (is_single()) {
    require_once (ABSPATH . WPINC . '/rss-functions.php');
        $text .= "<br /><b><a href=\"http://www.technorati.com/cosmos/search.html?url=" . get_permalink() . "&partner=wordpress\">Incoming Links</a></b> (via <a href=\"http://www.technorati.com/\">Tecnorati</a>):<br />";
        $rss = @fetch_rss('http://feeds.technorati.com/cosmos/rss/?url='. trailingslashit(get_permalink()) .'&partner=wordpress');
        if ( isset($rss->items) && 0 != count($rss->items) ) {
        $text .= "<ul>";
        $rss->items = array_slice($rss->items, 0, 5);
        foreach ($rss->items as $item ) {
            $text .= "<li><a href=\"" . wp_filter_kses($item['link']) . "\">" . wp_specialchars($item['title']) . "</a>";
            $text .= " <br />" . $item['description']; //remove to remove link description (post text)
            $text .= "</li>";
            }
        $text .= "</ul><br />";
        }
        else {
            $text .= "Nothing Reported<br /><br />";
        }
    }
return $text;
}

    add_filter('the_content', 'technolink');

?>