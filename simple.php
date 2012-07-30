<?

$dirdown = "./downfiles/";

$name = (isset($_SERVER['QUERY_STRING']) and 
		 is_file($dirdown.$_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : die("File Not Found");

$path = $dirdown.$name;

ignore_user_abort(true); // Don't end if the connection breaks

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$name.";" );
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".@filesize($path));

if (readfile($path) !== false and !connection_aborted()) {
// Success!
	file_put_contents('d.log',"scaricato\n");
}
else {
	file_put_contents('d.log',"annullato\n");
}

?>
