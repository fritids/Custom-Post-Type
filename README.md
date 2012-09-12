*--------------------------------------------------------------------*

                    WP CUSTOM POST TYPE FUNCTION

*--------------------------------------------------------------------*

This is a custom post type for WordPress with custom meta fields and should have thumbnails, tags and categories ready 
to go.

TO USE:
Add fn-custom-post-type-colleges.php or n-custom-post-type-degrees.php to your theme. Include fn-custom-post-type-colleges.php 
or fn-custom-post-type-degrees.php in your functions.php file (as shown this repo's sample functions.php file). This CPT
does not currently have a template tied to it (possible future update). Create a single-jg_colleges.php or single-jg_degrees.php 
file to get your single post view. You can also create taxonomy and archive templates as needed. See http://codex.wordpress.org/Post_Type_Templates,
http://codex.wordpress.org/Template_Hierarchy#Custom_Taxonomies_display and http://codex.wordpress.org/Template_Hierarchy#Custom_Post_Types_display. 

IF YOU DON'T WANT AN ENTIRELY NEW CUSTOM POST TYPE:
But just need a custom meta box for your page or post, use fn-page-custom-fields.php or fn-post-custom-fields.php instead.


FILES IN THIS REPO:
functions/fn-custom-post-type-colleges.php
functions/fn-custom-post-type-degrees.php
functions/fn-page-custom-fields.php
functions/fn-post-custom-fields.php
functions.php (for demo only)

old stuff/fn-degrees.php (defunct)
old stuff/jg-dgrees.php (defunct; rename as you like; be sure to update fn-degrees.php)


UPDATES:
09/12/12: Discovered old CPT (fn-degrees.php) didn't save update/edits. You could add new and delete entire posts, but not
update any of the data in the custom meta fields. 