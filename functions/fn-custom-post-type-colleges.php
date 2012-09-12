<?php
/**************************************************************************************************************************

CUSTOM POST TYPE: COLLEGES
A brand spankin' new JG_Colleges plugin.
Version 2.0

I should make a little icon for it.

**************************************************************************************************************************/

add_action('init', 'jg_colleges_register');   

function jg_colleges_register() {
  $labels = array( 
  	'name' => _x('JG Colleges', 'post type general name'), 
  	'singular_name' => _x('College', 'post type singular name'), 
  	'add_new' => _x('Add New', 'college item'), 
  	'add_new_item' => __('Add New College'),
  	'edit_item' => __('Edit College'), 
  	'new_item' => __('New College'), 
  	'view_item' => __('View College'), 
  	'search_items' => __('Search JG Colleges'), 
  	'not_found' => __('Nothing found'), 
  	'not_found_in_trash' => __('Nothing found in Trash'), 
  	'parent_item_colon' => ''
  );

  $args = array( 
  	'labels' => $labels, 
  	'public' => true, 
  	'publicly_queryable' => true, 
  	'show_ui' => true, 
  	'query_var' => true, 
  	'menu_icon' => get_stylesheet_directory_uri() . '/images/icon-jgcolleges.png', 
		'rewrite' => array("slug" => "college"), // Permalinks
  	'capability_type' => 'post', 
  	'hierarchical' => false, 
  	'menu_position' => null, 
  	'supports' => array('title','editor','thumbnail')
  );   

  register_post_type( 'jg_colleges' , $args ); 
}

  add_action("manage_posts_custom_column", "jg_custom_columns"); 
  add_filter("manage_edit-jg_colleges_columns", "jg_edit_columns");
  
  function jg_edit_columns($columns) {
  	$columns = array( 
  		"cb" => "<input type=\"checkbox\" />", 
			"title" => "Title",
			"state" => "State",
  	);
  	return $columns;
  }

  function jg_custom_columns($column) {
  	global $post;
  	
  	switch ($column) { 
  		case "state":	$custom = get_post_custom(); echo $custom["state"][0]; break;

  		//case "description": the_excerpt(); break; 
  		//case "year": $custom = get_post_custom(); echo $custom["year_completed"][0]; break; 
  		//case "skills": echo get_the_term_list($post->ID, 'Skills', '', ', ',''); break; 
  	} 
  }

  //register_taxonomy("Skills", array("portfolio"), array("hierarchical" => true, "label" => "Skills", "singular_label" => "Skill", "rewrite" => true));

  add_action('admin_init', 'lets_add_some_meta_boxes');
  
  function lets_add_some_meta_boxes() {
  	add_meta_box("college_options", "College Options", "college_options", "jg_colleges", "normal", "high");
  	add_meta_box("cheapest", "Cheapest?", "cheapest", "jg_colleges", "normal", "high");
  }

  function college_options() { 
  global $post;
  
  	$custom = get_post_custom($post->ID);
		$acc_agency = $custom["acc_agency"][0];
		$address = $custom["address"][0];
		$state = $custom["state"][0];
		$phone = $custom["phone"][0];
		$website = $custom["website"][0];

		$percent_fin_aid = $custom["percent_fin_aid"][0];
		$school_type = $custom["school_type"][0];
		$programs_offered = $custom["programs_offered"][0];
		$degree_type = $custom["degree_type"][0];
		$tuition_fees = $custom["tuition_fees"][0];
		
		$this_degree_type = get_post_meta( $post->ID, 'degree_type', TRUE );

  ?>

<table>
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
<tr>
	<td valign="top"><label><strong>Degree Types Offered</strong>:</label></td>
	<td colspan="2">
		<input type="checkbox" name="degree_type[]" id="degree_type-art" value="art" <?php if(in_array('art', $this_degree_type)) {echo ' checked="checked"'; } else {} ?>> <label>Art and Design</label><br>

		<input type="checkbox" name="degree_type[]" id="degree_type-bus" value="bus" <?php if(in_array('bus', $this_degree_type)) {echo ' checked="checked"'; } else {} ?>> <label>Business</label><br>

		<input type="checkbox" name="degree_type[]" id="degree_type-com" value="com" <?php if(in_array('com', $this_degree_type)) {echo ' checked="checked"'; } else {} ?>> <label>Communications</label><br>

		<input type="checkbox" name="degree_type[]" id="degree_type-edu" value="edu" <?php if(in_array('edu', $this_degree_type)) {echo ' checked="checked"'; } else {} ?>> <label>Education</label><br>

		<input type="checkbox" name="degree_type[]" id="degree_type-eng" value="eng" <?php if(in_array('eng', $this_degree_type)) {echo ' checked="checked"'; } else {} ?>> <label>Engineering</label><br>

		<input type="checkbox" name="degree_type[]" id="degree_type-hea" value="hea" <?php if(in_array('hea', $this_degree_type)) {echo ' checked="checked"'; } else {} ?>> <label>Health Care</label><br>

		<input type="checkbox" name="degree_type[]" id="degree_type-law" value="law" <?php if(in_array('law', $this_degree_type)) {echo ' checked="checked"'; } else {} ?>> <label>Law and Criminal Justice</label><br>

		<input type="checkbox" name="degree_type[]" id="degree_type-lib" value="lib" <?php if(in_array('lib', $this_degree_type)) {echo ' checked="checked"'; } else {} ?>> <label>Liberal Arts</label><br>

		<input type="checkbox" name="degree_type[]" id="degree_type-mat" value="mat" <?php if(in_array('mat', $this_degree_type)) {echo ' checked="checked"'; } else {} ?>> <label>Math and Science</label><br>

		<input type="checkbox" name="degree_type[]" id="degree_type-nur" value="nur" <?php if(in_array('nur', $this_degree_type)) {echo ' checked="checked"'; } else {} ?>> <label>Nursing</label><br>

		<input type="checkbox" name="degree_type[]" id="degree_type-tec" value="tec" <?php if(in_array('tec', $this_degree_type)) {echo ' checked="checked"'; } else {} ?>> <label>Technology</label>

	</td>
</tr>
<tr>
	<td><label><strong>Tuition &amp; Fees</strong>:</label></td>
	<td colspan="2">$ <input type="text" name="tuition_fees" value="<?php echo $tuition_fees; ?>" size="10" /></td>
</tr>
</table>

  <?php
  }

  function cheapest() { 
  	global $post; 
  	$custom = get_post_custom($post->ID); 
		$cheapest = $custom["cheapest"][0];
		$tuition_per_credit = $custom["tuition_per_credit"][0];
		$out_of_state_tuition = $custom["out_of_state_tuition"][0];
		$avg_credits_needed = $custom["avg_credits_needed"][0];
		$total_tuition = $custom["total_tuition"][0];

		$program_length = $custom["program_length"][0];
		$internship = $custom["internship"][0];
		$campus_visit = $custom["campus_visit"][0];
  ?> 
<table>
<tr>
	<td><label><strong>Cheapest?</strong></label></td>
	<td>
		<label>Yes</label> <input type="radio" id="yes" name="cheapest"  value="true" <?php if ($cheapest == 'true') echo 'checked';?>/>
		<label style="margin-left: 15px;">No</label> <input type="radio" id="no" name="cheapest"  value="false" <?php if ($cheapest == '' || $cheapest == 'false') echo 'checked';?>/>
	</td>
</tr>

<tr>
	<td><label><strong>Tuition Per Credit</strong>:</label></td>
	<td colspan="2">$ <input type="text" name="tuition_per_credit" value="<?php echo $tuition_per_credit; ?>" size="10" /></td>
</tr>
<tr>
	<td><label><strong>Out of State Tuition</strong>:</label></td>
	<td colspan="2">$ <input type="text" name="out_of_state_tuition" value="<?php if ($out_of_state_tuition == '' ) { echo 'NA'; } else { echo $out_of_state_tuition; } ?>" size="10" /></td>
</tr>
<tr>
	<td><label><strong>Average # of Credits Needed</strong>:</label></td>
	<td colspan="2">&nbsp;&nbsp;&nbsp;<input type="text" name="avg_credits_needed" value="<?php echo $avg_credits_needed; ?>" size="10" /></td>
</tr>
<tr>
	<td><label><strong>Estimated Total Tuition</strong>:</label> <em>(no comma)</em></td>
	<td colspan="2">$ <input type="text" name="total_tuition" value="<?php echo $total_tuition; ?>" size="10" /></td>
</tr>

<tr>
	<td><label><strong>Projected Full-Time Program Length</strong>:</label></td>
	<td colspan="2">&nbsp;&nbsp;&nbsp;<input type="text" name="program_length" value="<?php echo $program_length; ?>" size="50" /></td>
</tr>
<tr>
	<td><label><strong>Internships Required?</strong></label></td>
	<td>
		<label>Yes</label> <input type="radio" id="yes" name="internship"  value="true" <?php if ($internship == 'true') echo 'checked';?>/>
		<label style="margin-left: 15px;">No</label> <input type="radio" id="no" name="internship"  value="false" <?php if ($internship == 'false') echo 'checked';?>/>
	</td>
</tr>

<tr>
	<td><label><strong>Campus Visits Required?</strong></label></td>
	<td>
		<label>Yes</label> <input type="radio" id="yes" name="campus_visit"  value="true" <?php if ($campus_visit == 'true') echo 'checked';?>/>
		<label style="margin-left: 15px;">No</label> <input type="radio" id="no" name="campus_visit"  value="false" <?php if ($campus_visit == 'false') echo 'checked';?>/>
	</td>
</tr>

</table>

</table>
  <?php }
  
  add_action('save_post', 'save_details');
  
  function save_details() {
  	global $post;

		update_post_meta($post->ID, "acc_agency", $_POST["acc_agency"]);
		update_post_meta($post->ID, "address", $_POST["address"]);
		update_post_meta($post->ID, "state", $_POST["state"]);
		update_post_meta($post->ID, "phone", $_POST["phone"]);
		update_post_meta($post->ID, "website", $_POST["website"]);

		update_post_meta($post->ID, "percent_fin_aid", $_POST["percent_fin_aid"]);
		update_post_meta($post->ID, "school_type", $_POST["school_type"]);
		update_post_meta($post->ID, "programs_offered", $_POST["programs_offered"]);

		if( isset($_POST['degree_type']) ){
    	update_post_meta($post->ID, "degree_type", $_POST["degree_type"] );
		}else{
			delete_post_meta($post->ID, "degree_type");
		}

		update_post_meta($post->ID, "tuition_fees", $_POST["tuition_fees"]);

		update_post_meta($post->ID, "cheapest", $_POST["cheapest"]);
		update_post_meta($post->ID, "tuition_per_credit", $_POST["tuition_per_credit"]);
		update_post_meta($post->ID, "out_of_state_tuition", $_POST["out_of_state_tuition"]);
		update_post_meta($post->ID, "avg_credits_needed", $_POST["avg_credits_needed"]);
		update_post_meta($post->ID, "total_tuition", $_POST["total_tuition"]);

		update_post_meta($post->ID, "program_length", $_POST["program_length"]);
		update_post_meta($post->ID, "internship", $_POST["internship"]);
		update_post_meta($post->ID, "campus_visit", $_POST["campus_visit"]);
  }

?>