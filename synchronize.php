<?php
    // Include Composer libraries
require_once("./sdk/Dropbox/Auth.php");
require_once("./sdk/Dropbox/Files.php");
require_once("./sdk/Dropbox/FileProperties.php");
require_once("./sdk/Dropbox/FileRequests.php");
require_once("./sdk/Dropbox/Paper.php");
require_once("./sdk/Dropbox/Misc.php");
require_once("./sdk/Dropbox/Sharing.php");
require_once("./sdk/Dropbox/Users.php");
require_once("./sdk/Dropbox.php");

    // Initialize Dropbox client
    $dropbox = new Dropbox\Dropbox('v2-api-token');

	
function download_from_dropbox($ref , $folder_from , $folder_to){
	//recursive folder/file list
	$list = $ref->files->list_folder($folder_from,true);
	echo "<PRE>";
	// print_r($list);
	$cwd = getcwd(); 
	chdir('../images/cities');
	

	//create/update folders
	foreach($list["entries"] as $entry){
		
		if($entry[".tag"] == "folder"){
			echo $entry["path_display"]."---";
			mkdir(substr($entry["path_display"],1)."/", 0755, true);
		}
	}
	chdir($cwd); 
	
	//copy the file-s
	foreach($list["entries"] as $entry){
		
		if($entry[".tag"] == "file"){
			echo "file <br/>";
			$ref->files->download($entry["path_display"], '../local-folder' . $entry["path_display"]);
			print_r($entry);
		}
	}

	echo "</PRE>";
}


echo 'Current script owner: ' . get_current_user();


download_from_dropbox($dropbox , '' , '../local-folder/');
?>
