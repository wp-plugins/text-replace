=== Text Replace ===
Contributors: coffee2code
Donate link: http://coffee2code.com/donate
Tags: text, replace, shortcuts, post content, coffee2code
Requires at least: 2.2
Tested up to: 2.5
Stable tag: 2.0
Version: 2.0

Replace text with other text in posts, etc.  Very handy to create shortcuts to commonly-typed and/or lengthy text/HTML, or for smilies.

== Description ==

Replace text with other text in posts, etc.  Very handy to create shortcuts to commonly-typed and/or lengthy text/HTML, or for smilies.

This plugin can be utilized to make shortcuts for frequently typed text, but keep these things in mind:

* Your best bet with defining shortcuts is to define something that would never otherwise appear in your text.  For instance, bookend the shortcut with colons:
	`wp: => <a href='http://wordpress.org'>WordPress</a>`
	`:aol: => <a href='http://www.aol.com'>America Online, Inc.</a>`
Otherwise, you risk proper but undesired replacements:
	`Hi => Hello`
Would have the effect of changing "His majesty" to "Hellos majesty".

* List the more specific matches early, to avoid stomping on another of your shortcuts.  For example, if you have both 
`:p` and `:pout:` as shortcuts, put `:pout:` first, otherwise, the `:p` will match against all the `:pout:` in your text.

* If you intend to use this plugin to handle smilies, you should probably disable WordPress's default smilie handler.

* This plugin is set to filter the_content, the_excerpt, and optionally, get_comment_text and get_comment_excerpt.

* **SPECIAL CONSIDERATION:** Be aware that the shortcut text that you use in your posts will be stored that way in the database (naturally).  While calls to display the posts will see the filtered, text replaced version, anything that operates directly on the database will not see the expanded replacement text.  So if you only ever referred to "America Online" as ":aol:" (where ":aol:" => "<a href='http://www.aol.com'>America Online</a>"), visitors to your site will see the linked, expanded text due to the text replace, but a database search would never turn up a match for "America Online".

* However, a benefit of the replacement text not being saved to the database and instead evaluated when the data is being loaded into a web page is that if the replacement text is modified, all pages making use of the shortcut will henceforth use the updated replacement text.

== Installation ==

1. Unzip `text-replace.zip` inside the `/wp-content/plugins/` directory, or upload `text-replace.php` there
1. Activate the plugin through the 'Plugins' admin menu in WordPress
1. Go to the new `Options` -> `Text Replac`e (or for WP 2.5: `Settings` -> `Text Replace`) admin options page.  Optionally customize the options (notably to define the shortcuts and their replacements).
1. Start using the shortcuts in posts.  (Also applies to shortcuts already defined in older posts as well)

* SPECIAL NOTE FOR UPGRADERS: If you have used v1.0 or prior of this plugin, you will have to copy your `$text_to_replace` array contents into the plugin's option's page field.

== Frequently Asked Questions ==

= Does this plugin modify the post content in the database? =

No.  The plugin filters post content on-the-fly.

= Will this work for posts I wrote prior to installing this plugin? =

Yes, if they include strings that you've now defined as shortcuts.

= What post fields get handled by this plugin? =

The plugin filters the post content and post excerpt fields, and optionally comments and comment excerpts.

= Is the plugin case sensitive? =

Yes.

= I use :wp: all the time as a shortcut for WordPress, but when I search posts for the term "WordPress", I don't see posts where I used the shortcut; why not? =

Search engines will see those posts since they only ever see the posts after the shortcuts have been replaced.  However, WordPress's search function searches the database directly, where only the shortcut exists, so WordPress doesn't know about the replacement text you've defined.

== Screenshots ==

1. A screenshot of the admin options page for the plugin, where you define the terms/phrases/shortcuts and their related replacement text
