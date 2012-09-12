<?php
/*
Plugin Name: JG Degrees
Plugin URI:
Description: Post Type for Degrees
Version: 1.0
Author: Jen Germann
Author URI: http://jengermann.com
*/

// Enable post thumbnails
// include "includes/functions.php";
class jg_degrees {

	var $meta_fields = array("logo_link","affiliate_link","acc_agency","address","state","phone","website","tuition_fees","percent_fin_aid", "school_type", "programs_offered", "most_popular");


	function jg_degrees()
	{
		// Register custom post types
		register_post_type('jg_degrees', array(
			'label' => __('Degrees'),
			'singular_label' => __('Degree'),
			'public' => true,
			'show_ui' => true,
			'_builtin' => false,
			'_edit_link' => 'post.php?post=%d',
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array("slug" => "degree"), // Permalinks
			'query_var' => "jg_degrees",
			'supports' => array('title', 'editor', 'excerpt', 'thumbnail'/*, 'comments' ,'custom-fields'*/),
			'taxonomies' => array('category', 'post_tag')
		));

		add_filter("manage_edit-jg_degrees_columns", array(&$this, "edit_columns"));
		add_action("manage_posts_custom_column", array(&$this, "custom_columns"));

		// Register custom taxonomy
		register_taxonomy( 'degree_types', 'jg_degrees', array( 'hierarchical' => true, 'label' => __('Degree Category') ) );  // category
		register_taxonomy( 'degree_tag', 'jg_degrees', array('hierarchical' => false,  'label' => __('Degree Tag'))); //tag

		// Admin interface init
		add_action("admin_init", array(&$this, "admin_init"));
		add_action("template_redirect", array(&$this, 'template_redirect'));

		// Insert post hook
		add_action("wp_insert_post", array(&$this, "wp_insert_post"), 10, 2);
	}

	function edit_columns($columns)
	{
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Title",
			"degree_types" => "Degree Type",
			"most_popular" => "Most Popular?",
			"state" => "State",
		);

		return $columns;
	}

	function custom_columns($column)
	{
		global $post;
		//echo $post->ID;
		$custom = get_post_custom();
		switch ($column)
		{
			case "degree_types":
				$degree_types = get_the_term_list($post->ID, 'degree_types', '', ', ','');
				echo $degree_types;
				break;
			case "most_popular":
				$most_popular = get_post_custom();
				echo $custom["most_popular"][0];
			break;
			case "state":
				$custom = get_post_custom();
				echo $custom["state"][0];
				break;
		}
	}

	// Template selection
	function template_redirect()
	{
		global $wp;
		if ($wp->query_vars["post_type"] == "jg_degrees")
		{
			include(TEMPLATEPATH . "/jg-degrees.php");
			die();
		}
	}

	// When a post is inserted or updated
	function wp_insert_post($post_id, $post = null)
	{
		if ($post->post_type == "jg_degrees")
		{
			// Loop through the POST data
			foreach ($this->meta_fields as $key)
			{
				$value = @$_POST[$key];

				// If value is a string it should be unique
				if (!is_array($value))
				{
					if($value != "")
					{
						// Update meta
						if (!update_post_meta($post_id, $key, $value))
						{
							// Or add the meta data
							add_post_meta($post_id, $key, $value);
						}
					}
				}
				else
				{
					// If passed along is an array, we should remove all previous data
					delete_post_meta($post_id, $key);

					// Loop through the array adding new values to the post meta as different entries with the same name
					foreach ($value as $entry)
					{
						if($entry != "")
							add_post_meta($post_id, $key, $entry);
					}
				}
			}
		}
	}

	function admin_init()
	{
		// Custom meta boxes for the edit jg_degrees screen
	add_meta_box("degree-meta", "Degree Options", array(&$this, "meta_options"), "jg_degrees", "normal", "low");
	}

	// Admin post meta contents
	function meta_options()
	{ //"acc_agency","address","city","state","zip"
		global $post;
		$custom = get_post_custom($post->ID);
		$most_popular = $custom["most_popular"][0];

		$logo_link = $custom["logo_link"][0];
		$affiliate_link = $custom["affiliate_link"][0];

		$acc_agency = $custom["acc_agency"][0];
		$address = $custom["address"][0];
		//$city = $custom["city"][0];
		$state = $custom["state"][0];
		//$zip = $custom["zip"][0];
		//$area_code = $custom["area_code"][0];
		$phone = $custom["phone"][0];
		//$ext = $custom["ext"][0];
		$website = $custom["website"][0];
		$tuition_fees = $custom["tuition_fees"][0];
		$percent_fin_aid = $custom["percent_fin_aid"][0];
		$school_type = $custom["school_type"][0];
		$programs_offered = $custom["programs_offered"][0];
?>
	<script type="text/javascript">
		document.getElementById("post").setAttribute("enctype","multipart/form-data");
		document.getElementById('post').setAttribute('encoding','multipart/form-data');
	</script>

<?php if ( attribute_escape($most_popular) === "true" ){
				$checked = "checked=\"checked\"";
			} else {
				$checked = "";
			}
?>
<table>
<tr>
	<td><label><strong>Most Popular Degree</strong>:</label></td>
	<td colspan="2">
		<input name="most_popular" id="most_popular" type="checkbox" class="checkbox" value="true" <?php echo $checked; ?> />
	</td>
</tr>
<tr>
	<td><label><strong>Logo Link</strong>: <small>(include the http://)</small></label></td>
	<td colspan="2"><input type="text" name="logo_link" value="<?php echo $logo_link; ?>" size="50" /></td>
</tr>
<tr>
	<td><label><strong>Affiliate Link</strong>: <small>(include the http://)</small></label></td>
	<td colspan="2"><input type="text" name="affiliate_link" value="<?php echo $affiliate_link; ?>" size="50" /></td>
</tr>
<tr>
	<td><label><strong>Accrediting Agency</strong>:</label></td>
	<td colspan="2"><input type="text" name="acc_agency" value="<?php echo $acc_agency; ?>" size="50" /></td>
</tr>
<tr>
	<td><label><strong>Address</strong>:</label></td>
	<td colspan="2"><input type="text" name="address" value="<?php echo $address; ?>" size="50" /></td>
</tr>
<tr>
	<td><label><strong>State</strong>:</label></td>
	<td colspan="2">
		<select id="state" name="state">
			<option>Select</option>
			<option <?php if($state == 'Alabama') { echo 'selected';} ?> value="Alabama">Alabama</option>
			<option <?php if($state == 'Alaska') { echo 'selected="selected"';} ?> value="Alaska">Alaska</option>
			<option <?php if($state == 'Arizona') { echo 'selected="selected"';} ?> value="Arizona">Arizona</option>
			<option <?php if($state == 'Arkansas') { echo 'selected="selected"';} ?> value="">Arkansas</option>
			<option <?php if($state == 'California') { echo 'selected="selected"';} ?> value="California">California</option>
			<option <?php if($state == 'Colorado') { echo 'selected="selected"';} ?> value="Colorado">Colorado</option>
			<option <?php if($state == 'Connecticut') { echo 'selected="selected"';} ?> value="Connecticut">Connecticut</option>
			<option <?php if($state == 'Delaware') { echo 'selected="selected"';} ?> value="Delaware">Delaware</option>
			<option <?php if($state == 'District of Columbia') { echo 'selected="selected"';} ?> value="District of Columbia">District of Columbia</option>
			<option <?php if($state == 'Florida') { echo 'selected="selected"';} ?> value="Florida">Florida</option>
			<option <?php if($state == 'Georgia') { echo 'selected="selected"';} ?> value="Georgia">Georgia</option>
			<option <?php if($state == 'Hawaii') { echo 'selected="selected"';} ?> value="Hawaii">Hawaii</option>
			<option <?php if($state == 'Idaho') { echo 'selected="selected"';} ?> value="Idaho">Idaho</option>
			<option <?php if($state == 'Illinois') { echo 'selected="selected"';} ?> value="Illinois">Illinois</option>
			<option <?php if($state == 'Indiana') { echo 'selected="selected"';} ?> value="Indiana">Indiana</option>
			<option <?php if($state == 'Iowa') { echo 'selected="selected"';} ?> value="Iowa">Iowa</option>
			<option <?php if($state == 'Kansas') { echo 'selected="selected"';} ?> value="Kansas">Kansas</option>
			<option <?php if($state == 'Kentucky') { echo 'selected="selected"';} ?> value="Kentucky">Kentucky</option>
			<option <?php if($state == 'Louisiana') { echo 'selected="selected"';} ?> value="Louisiana">Louisiana</option>
			<option <?php if($state == 'Maine') { echo 'selected="selected"';} ?> value="Maine">Maine</option>
			<option <?php if($state == 'Maryland') { echo 'selected="selected"';} ?> value="Maryland">Maryland</option>
			<option <?php if($state == 'Massachusetts') { echo 'selected="selected"';} ?> value="Massachusetts">Massachusetts</option>
			<option <?php if($state == 'Michigan') { echo 'selected="selected"';} ?> value="Michigan">Michigan</option>
			<option <?php if($state == 'Minnesota') { echo 'selected="selected"';} ?> value="Minnesota">Minnesota</option>
			<option <?php if($state == 'Mississippi') { echo 'selected="selected"';} ?> value="Mississippi">Mississippi</option>
			<option <?php if($state == 'Missouri') { echo 'selected="selected"';} ?> value="Missouri">Missouri</option>
			<option <?php if($state == 'Montana') { echo 'selected="selected"';} ?> value="Montana">Montana</option>
			<option <?php if($state == 'Nebraska') { echo 'selected="selected"';} ?> value="Nebraska">Nebraska</option>
			<option <?php if($state == 'Nevada') { echo 'selected="selected"';} ?> value="Nevada">Nevada</option>
			<option <?php if($state == 'New Hampshire') { echo 'selected="selected"';} ?> value="New Hampshire">New Hampshire</option>
			<option <?php if($state == 'New Jersey') { echo 'selected="selected"';} ?> value="New Jersey">New Jersey</option>
			<option <?php if($state == 'New Mexico') { echo 'selected="selected"';} ?> value="New Mexico">New Mexico</option>
			<option <?php if($state == 'New York') { echo 'selected="selected"';} ?> value="New York">New York</option>
			<option <?php if($state == 'North Carolina') { echo 'selected="selected"';} ?> value="North Carolina">North Carolina</option>
			<option <?php if($state == 'North Dakota') { echo 'selected="selected"';} ?> value="North Dakota">North Dakota</option>
			<option <?php if($state == 'Ohio') { echo 'selected="selected"';} ?> value="Ohio">Ohio</option>
			<option <?php if($state == 'Oklahoma') { echo 'selected="selected"';} ?> value="Oklahoma">Oklahoma</option>
			<option <?php if($state == 'Oregon') { echo 'selected="selected"';} ?> value="Oregon">Oregon</option>
			<option <?php if($state == 'Pennsylvania') { echo 'selected="selected"';} ?> value="Pennsylvania">Pennsylvania</option>
			<option <?php if($state == 'Rhode Island') { echo 'selected="selected"';} ?> value="Rhode Island">Rhode Island</option>
			<option <?php if($state == 'South Carolina') { echo 'selected="selected"';} ?> value="South Carolina">South Carolina</option>
			<option <?php if($state == 'South Dakota') { echo 'selected="selected"';} ?> value="South Dakota">South Dakota</option>
			<option <?php if($state == 'Tennessee') { echo 'selected="selected"';} ?> value="Tennessee">Tennessee</option>
			<option <?php if($state == 'Texas') { echo 'selected="selected"';} ?> value="Texas">Texas</option>
			<option <?php if($state == 'Utah') { echo 'selected="selected"';} ?> value="Utah">Utah</option>
			<option <?php if($state == 'Vermont') { echo 'selected="selected"';} ?> value="Vermont">Vermont</option>
			<option <?php if($state == 'Virginia') { echo 'selected="selected"';} ?> value="Virginia">Virginia</option>
			<option <?php if($state == 'Washington') { echo 'selected="selected"';} ?> value="Washington">Washington</option>
			<option <?php if($state == 'West Virginia') { echo 'selected="selected"';} ?> value="West Virginia">West Virginia</option>
			<option <?php if($state == 'Wisconsin') { echo 'selected="selected"';} ?> value="Wisconsin">Wisconsin</option>
			<option <?php if($state == 'Wyoming') { echo 'selected="selected"';} ?> value="Wyoming">Wyoming</option>
		</select>
	</td>
</tr>
<tr>
	<td><label><strong>Contact</strong>:</label></td>
	<td colspan="2"><input type="text" name="phone" value="<?php echo $phone; ?>" size="20" /></td>
</tr>
<tr>
	<td><label><strong>Website</strong>:</label></td>
	<td colspan="2"><input type="text" name="website" value="<?php echo $website; ?>" size="50" /></td>
</tr>
<tr>
	<td><label><strong>Tuition &amp; Fees</strong>:</label></td>
	<td colspan="2">$ <input type="text" name="tuition_fees" value="<?php echo $tuition_fees; ?>" size="10" /></td>
</tr>
<tr>
	<td><label><strong>Percentage of Students Receiving Financial Aid</strong>:</label></td>
	<td colspan="2"><input type="text" name="percent_fin_aid" value="<?php echo $percent_fin_aid; ?>" size="2" />%</td>
</tr>
<tr>
	<td><label><strong>Type of School</strong>:</label></td>
	<td colspan="2"><input type="text" name="school_type" value="<?php echo $school_type; ?>" size="50" /></td>
</tr>
<tr>
	<td><label><strong>Programs Offered</strong>:</label></td>
	<td colspan="2"><input type="text" name="programs_offered" value="<?php echo $programs_offered; ?>" size="50" /></td>
</tr>

</table>
<?php
	}
}

// Initiate the plugin
add_action("init", "jg_degreesInit");
function jg_degreesInit() { global $jgs; $jgs = new jg_degrees(); }
?>