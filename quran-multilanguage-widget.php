<?php
/*
Plugin Name: Holy Quran random verse widget
Description: Holy Quran random verse widget is translated into 22 languages
Version: 1.2.3
Author: Karim Bahmed
Author URI: http://islamaudio.fr
*/

add_action('widgets_init','holy_quran_random_init');

function  holy_quran_random_init(){
	register_widget("holy_quran_random_widget");

}

class holy_quran_random_widget extends WP_widget{


	function holy_quran_random_widget(){
		$options = array(
			"classname" => "quran_random",
			"description" => "random Quran verse"
		);
		$this->WP_widget("quran_random", "Quran random verse",$options);
	}
	
	function widget($args,$d){
	
		extract($args);
		echo $before_widget;
		echo $before_title.$d['title'].$after_title;
		$line = rand(1,6236);

		$file = plugin_dir_url( __FILE__ ).'languages/'.$d['language'].'.txt';
		$document = @fopen($file, "r");
			if ($document)
				{

			for ($Actuelle=1; $Actuelle <= $line; $Actuelle++)
				{

		$temp = fgets($document);
			if (empty($temp)) { break; }
				else { $content = $temp; }
			}
			}

	else
	{
		$content = "Erreur d'ouverture de <em>$file</em>";
	}

	@fclose($document);
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 


	echo $content;		
	if(is_plugin_active( 'quran-text-multilanguage/quran-text-multilanguage.php' ) AND $d['language'] != "arabe" ) {
		$num = explode("|", $content);	
		
	global $wpdb;
		$req_sourate = $wpdb->get_results( 
		"
		SELECT ID,post_status
		FROM $wpdb->posts  
		WHERE post_content LIKE '%[quran]%'
		"
		);
		
	foreach ( $req_sourate as $sourate ) 
	{
		if($sourate->post_status =='publish'){	
		echo '<br><a href="./?page_id='.$sourate->ID.'&sourate=_'.$num[0].'">Sura '.$num[0].'</a>';

		}
	}		
		
	}		
		echo $after_widget;
	}
	
	function update($new,$old){
		
		return $new;
	}
	
	function form($d){

		$id_title = $this->get_field_id("title");
		$name_title = $this->get_field_name("title");
		$id_language = $this->get_field_id("language");
		$name_language = $this->get_field_name("language");
		$defaut = array(
		"title" => "Ramdon Quran verse"
		);
		$d = wp_parse_args($d,$defaut);
		?>
		<p>
			<label for="<?php echo $id_title; ?>">Title :</label>
			<input name="<?php echo $name_title; ?>" id="<?php echo $id_title;?>" value="<?php echo $d['title']; ?>" type="text"/>
		</p>
		<p>
			<label>Languages : </label>
			<select name="<?php echo $name_language; ?>">
			<option value="arabe"<?php if ($d['language'] == "arabe"){echo 'selected="selected"';}?>>Arabe</option>				
			<option value="english"<?php if ($d['language'] == "english"){echo 'selected="selected"';}?>>English</option>			
			<option value="francais"<?php if ($d['language'] == "francais"){echo 'selected="selected"';}?>>Français</option>
			<option value="german"<?php if ($d['language'] == "german"){echo 'selected="selected"';}?>>German</option>
			<option value="russian"<?php if ($d['language'] == "russian"){echo 'selected="selected"';}?>>Russian</option>	
			<option value="albanian"<?php if ($d['language'] == "albanian"){echo 'selected="selected"';}?>>Albanian</option>
			<option value="azerbaijani"<?php if ($d['language'] == "azerbaijani"){echo 'selected="selected"';}?>>Azerbaijani</option>
			<option value="bengali"<?php if ($d['language'] == "bengali"){echo 'selected="selected"';}?>>Bengali</option>			
			<option value="bulgarian"<?php if ($d['language'] == "bulgarian"){echo 'selected="selected"';}?>>Bulgarian</option>	
			<option value="chinese"<?php if ($d['language'] == "chinese"){echo 'selected="selected"';}?>>Chinese</option>
			<option value="czech"<?php if ($d['language'] == "czech"){echo 'selected="selected"';}?>>Czech</option>
			<option value="indonesian"<?php if ($d['language'] == "indonesian"){echo 'selected="selected"';}?>>Indonesian</option>
			<option value="italian"<?php if ($d['language'] == "italian"){echo 'selected="selected"';}?>>Italian</option>
			<option value="kurdish"<?php if ($d['language'] == "kurdish"){echo 'selected="selected"';}?>>Kurdish</option>
			<option value="malay"<?php if ($d['language'] == "malay"){echo 'selected="selected"';}?>>Malay</option>
			<option value="norwegian"<?php if ($d['language'] == "norwegian"){echo 'selected="selected"';}?>>Norwegian</option>
			<option value="portuguese"<?php if ($d['language'] == "portuguese"){echo 'selected="selected"';}?>>Portuguese</option>
			<option value="romanian"<?php if ($d['language'] == "romanian"){echo 'selected="selected"';}?>>Romanian</option>
			<option value="somali"<?php if ($d['language'] == "somali"){echo 'selected="selected"';}?>>Somali</option>
			<option value="spanish"<?php if ($d['language'] == "spanish"){echo 'selected="selected"';}?>>Spanish</option>	
			<option value="swedish"<?php if ($d['language'] == "swedish"){echo 'selected="selected"';}?>>Swedish</option>	
			<option value="turkish"<?php if ($d['language'] == "turkish"){echo 'selected="selected"';}?>>Turkish</option>				
			</select>
		</p>
		<?php
	}
}