<?php
/*
 * Smarty plugin
 * --------------------------------------------------------
 * File: outputfilter.strip.php
 * Type: outputfilter
 * Name: strip
 * Version: 1.0
 * Purpose: Performs the same functionality as the {strip}
 * {/strip} tags, but across the board.
 * add the call:
 * $smarty->load_filter('output', 'strip');
 * --------------------------------------------------------
 */
function smarty_outputfilter_strip( $source, &$smarty )
{
    // compress all whitespace (tabs, newlines, spaces etc) down to one space
    $source = preg_replace("`\s+`ms", " ", $source);

    // remove return
    $source = str_replace(array("\r\n","\n","\r"), '', $source);

    // trim the result
    $source = trim($source);

    return $source;
}