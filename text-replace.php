<?php
/*
Plugin Name: Text Replace
Version: 1.0
Plugin URI: http://www.coffee2code.com/wp-plugins/
Author: Scott Reilly
Author URI: http://www.coffee2code.com
Description: Replace text with other text in posts, etc.  Very handy to create shortcuts to commonly-typed and/or lengthy text/HTML, or for smilies.

NOTES:

This plugin can be utilized to make shortcuts for frequently typed text, but keep these things in mind:

- Your best bet with defining shortcuts is to define something that would never otherwise appear in your text.  For instance, 
bookend the shortcut with colons:
	":wp:" => "<a href='http://wordpress.org'>WordPress</a>",
	":aol:" => "<a href='http://www.aol.com'>America Online, Inc.</a>",
Otherwise, you risk proper but undesired replacements:
	"Hi" => "Hello",
Would have the effect of changing "His majesty" to "Hellos majesty".  One solution might be to instead have used " Hi " (with spaces).

- Be mindful of your use of quotes as you define replacement text.  Escape embedded double-quotes.

- List the more specific matches early, to avoid stomping on another of your shortcuts.  For example, if you have both ":p" and ":pout:"
as shortcuts, put ":pout:" first, otherwise, the ":p" will match against all the ":pout:" in your text.

- If you intend to use this plugin to handle smilies, you should probably disable WordPress's default smilie handler.

- This plugin is set to filter the_content, the_excerpt, and if uncommented, comment_text.

- SPECIAL CONSIDERATION: Be aware that the shortcut text that you use in your posts will be stored that way in 
the database (naturally).  While calls to display the posts will see the filtered, text replaced version, 
anything that operates directly on the database will not see the expanded replacement text.  So if you only
ever referred to "America Online" as ":aol:" (where ":aol:" => "<a href='http://www.aol.com'>America Online</a>"),
visitors to your site will see the linked, expanded text due to the text replace, but a database search would
never turn up a match for "America Online".

- However, a benefit of the replacement text not being saved to the database and instead evaluated when the data is being loaded
into a web page is that if the replacement text is modified, all pages making use of the shortcut will henceforth use the updated 
replacement text.

*/

/*
Copyright (c) 2004-2005 by Scott Reilly (aka coffee2code)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation 
files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, 
modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the 
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR
IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

//Define the text to be replaced
//Careful not to define text that could match partially when you don't want it to:
//   i.e.  "Me" => "Scott"
//	would also inadvertantly change "Men" to be "Scottn"
	
$text_to_replace = array(
	":wp:" => "<a href='http://wordpress.org'>WordPress</a>",
	":wpwiki:" => "<a href='http://wiki.wordpress.org'>WordPress Wiki</a>",
);

function c2c_text_replace ($text, $case_sensitive=false) {
	global $text_to_replace;
	$oldchars = array("(", ")", "[", "]", "?", ".", ",", "|", "\$", "*", "+", "^", "{", "}");
	$newchars = array("\(", "\)", "\[", "\]", "\?", "\.", "\,", "\|", "\\\$", "\*", "\+", "\^", "\{", "\}");
	foreach ($text_to_replace as $old_text => $new_text) {
		$old_text = str_replace($oldchars, $newchars, $old_text);
		// Old method for string replacement.
		//$text = preg_replace("|([\s\>]*)(".$old_text.")([\s\<\.,;:\\/\-]*)|imsU" , "$1".$new_text."$3", $text);
		// New method.  WILL match string within string, but WON'T match within tags
		$preg_flags = ($case_sensitive) ? 's' : 'si';
		$text = preg_replace("|(?!<.*?)$old_text(?![^<>]*?>)|$preg_flags", $new_text, $text);
	}
	return $text;
} //end c2c_text_replace()

add_filter('the_content', 'c2c_text_replace', 2);
add_filter('the_excerpt', 'c2c_text_replace', 2);
// Uncomment this next line if you wish to allow users to be able to use text-replacement.  Note that the
//	priority must be set high enough to avoid <img> tags inserted by the text replace process from getting omitted 
//	as a result of the comment text sanitation process, if you use this plugin for smilies, for instance.
//add_filter('get_comment_text', 'c2c_text_replace', 10);
//add_filter('get_comment_excerpt', 'c2c_text_replace', 10);

?>