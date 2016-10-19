<?php

namespace App\Modules\Api\Helpers;

use Illuminate\Http\Request;


class HtmlHelper
{
    public function stripHtmlTags($str, $allowable_tags = '', $strip_attrs = true, $preserve_comments = false, callable $callback = null)
    {
        $string = stripslashes($str);
        $string = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $string);
        $string = preg_replace("/\r|\n/", "", $string);
        $string = preg_replace("/\"|'/", "", $string);

        $allowable_tags = array_map('strtolower', array_filter( // lowercase
            preg_split('/(?:>|^)\\s*(?:<|$)/', $allowable_tags, -1, PREG_SPLIT_NO_EMPTY), // get tag names
            function ($tag) {
                return preg_match('/^[a-z][a-z0-9_]*$/i', $tag);
            } // filter broken
        ));
        $comments_and_stuff = preg_split('/(<!--.*?(?:-->|$))/', $string, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($comments_and_stuff as $i => $comment_or_stuff) {
            if ($i % 2) { // html comment
                if (!($preserve_comments && preg_match('/<!--.*?-->/', $comment_or_stuff))) {
                    $comments_and_stuff[$i] = '';
                }
            } else { // stuff between comments
                $tags_and_text = preg_split("/(<(?:[^>\"']++|\"[^\"]*+(?:\"|$)|'[^']*+(?:'|$))*(?:>|$))/", $comment_or_stuff, -1, PREG_SPLIT_DELIM_CAPTURE);
                foreach ($tags_and_text as $j => $tag_or_text) {
                    $is_broken = false;
                    $is_allowable = true;
                    $result = $tag_or_text;
                    if ($j % 2) { // tag
                        if (preg_match("%^(</?)([a-z][a-z0-9_]*)\\b(?:[^>\"'/]++|/+?|\"[^\"]*\"|'[^']*')*?(/?>)%i", $tag_or_text, $matches)) {
                            $tag = strtolower($matches[2]);
                            if (in_array($tag, $allowable_tags)) {
                                if ($strip_attrs) {
                                    $opening = $matches[1];
//                                    $closing = ( $opening === '</' ) ? '>' : $closing;
                                    $closing = '>';
                                    $result = $opening . $tag . $closing;
                                }
                            } else {
                                $is_allowable = false;
                                $result = '';
                            }
                        } else {
                            $is_broken = true;
                            $result = '';
                        }
                    } else { // text
                        $tag = false;
                    }
                    if (!$is_broken && isset($callback)) {
                        // allow result modification
                        call_user_func_array($callback, array(&$result, $tag_or_text, $tag, $is_allowable));
                    }
                    $tags_and_text[$j] = $result;
                }
                $comments_and_stuff[$i] = implode('', $tags_and_text);
            }
        }
        $string = implode('', $comments_and_stuff);
        return $string;
    }
}