<?php
/*
Plugin Name: PHPInclusion
Plugin URI: http://www.royakhosravi.com/?p=63
Description:  PHP File Inclusion in posts & pages through use of require, include or similar statements.
Author: Roya Khosravi
Version: 1.1
Author URI: http://www.royakhosravi.com/

Updates:
-none

To-Doo: 
-none
*/

$phpinclusion_localversion="1.1";
 // Admin Panel   
function phpinclusion_add_pages()
{
	add_options_page('PHPInclusion options', 'PHPInclusion', 8, __FILE__, 'phpinclusion_options_page');            
}
// Options Page
function phpinclusion_options_page()
{ 
    // Configuration Page
    echo <<<END
<div class="wrap" style="max-width:950px !important;">
	<h2>PHPInclusion $phpinclusion_localversion</h2>
				
	<div id="poststuff" style="margin-top:10px;">
	
	<div id="sideblock" style="float:right;width:220px;margin-left:10px;"> 
		 <h3>Related</h3>

<div id="dbx-content" style="text-decoration:none;">
<ul>
<li><a style="text-decoration:none;" href="http://www.royakhosravi.com/?p=63">PHPInclusion</a></li>
</ul><br />
</div>
 	</div>
	
	 <div id="mainblock" style="width:710px">
	 
		<div class="dbx-content">
						<h3>Usage</h3>                         
<p>PHPInclusion Wordpress plugin allows you (admin only) to insert the content of a php file into your post/page with include(), require() , require_once() and include_once() functions. 
<p>Examples: <br>
<strong>[include:</strong>MyPhpFile.php<strong>]</strong><br>
<strong>[include:</strong>MyDir/MyPhpFile.php<strong>]</strong><br>
<strong>[include_once:</strong>MyDir/MyPhpFile.php<strong>]</strong><br>
<strong>[require:</strong>MyDir/MyPhpFile.php<strong>]</strong><br>
<strong>[require_once:</strong>MyDir/MyPhpFile.php<strong>]</strong><br>
</p>


		</div>
					
		<br/><br/><h3>&nbsp;</h3>	
	 </div>

	</div>
<h5>PHPInclusion plugin by <a href="http://www.royakhosravi.com/">Roya Khosravi</a></h5>
</div>
END;
}
// Add Options Page
add_action('admin_menu', 'phpinclusion_add_pages');

function phpinclusion_tag($mode,$files) {
	if ( get_the_author_login()=='admin' ) {
	switch ($mode) {
		case "include":
    		include($files);
    		break;
	case "include_once":
	case "includeonce":
    		include_once($files);
    		break;
	case "require":
    		require($files);
    		break;
	case "require_once":
	case "requireonce":
    		require_once($files);
    		break;
	default:
	}
	}
}

function phpinclusion_check($the_content) {

	if ((strpos($the_content, "[require:")!==FALSE)||(strpos($the_content, "[include:")!==FALSE)|| (strpos($the_content, "[require_once:")!==FALSE)||(strpos($the_content, "[include_once:")!==FALSE) || (strpos($the_content, "[requireonce:")!==FALSE)||(strpos($the_content, "[includeonce:")!==FALSE)) { 
		preg_match_all('/\[(?<name>\w+):([^\])]+)/', $the_content, $matches, PREG_SET_ORDER); 
		foreach($matches as $match) { 
			$the_content = preg_replace("/\[(?<name>\w+):([^\])]+)\]/", phpinclusion_tag($match[1], $match[2]), $the_content,1);

		}
		
	}
    return $the_content;
}
add_filter('the_content', 'phpinclusion_check', 10);
add_filter('the_excerpt','phpinclusion_check', 10);
?>