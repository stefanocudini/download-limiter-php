<?
#header("Content-type: text/plain");
/*

per file troppo piccoli si ottiene il blocco dello scaricamento anche se il download e' stato annullato dal browser!!!

*/
$logfile = './downloads.log';
$countfile = './countdown.log';
$maxdownload = 3;
//limite di download per uno stesso file

$dirdown = "/var/www/easyblog.it/download/";
//directory in cui cercare i file da scaricare!
//puo cercare anche delle subdirectory di $dirdown! basta specificarlo nel parametro passato allo script
//da mettere fuori!! della document_root

$target = $_SERVER['QUERY_STRING'];
//
////togliere qualunque ../../ si trova in $target prima di scaricare!!!
//

if(empty($target)):
?>
<div style="text-align:center">Area Download</div>
<?
else:
	$name = is_file($dirdown.$target) ? $target : NotFound();
	$path = $dirdown.$name;

	$cdown = count( array_keys(file($countfile),$target."\n") );
	
	if( $cdown >= $maxdownload )
		 NotFound("Il Download di questo file e' stato disabilitato!");
		 #eliminare il file! e toglierlo da dentro $countfile
	else
		$res = sendFile($path);
		
	if($res['aborted']===false)
		@file_put_contents($countfile, $target."\n", FILE_APPEND | LOCK_EX);
	#se il download non e' stato annullato	
	
	Logs($res);
	//forse mettere una exit() dentro Logs() senno continua l'esecuzione del php...
endif;


function NotFound($mes=false)
{
    header('HTTP/1.0 404 Not Found');
    exit(!$mes?"File non disponibile per il download":$mes);
}

function sendFile($path, $contentType='application/octet-stream')
{
	global $target;
	
	ignore_user_abort(true);
	//continua a eseguire php anche se il browser ha stoppato l'esecuzione

	header('Content-Transfer-Encoding: binary');
	header('Content-Disposition: attachment; filename="'.basename($path) . "\";");
	header("Content-Transfer-Encoding: binary");	
	header("Content-Type: $contentType");
	header("Content-Length: ".@filesize($path));

	$res = array(
		'file' => $target,
		'status' => false,
		'errors' => array(),
		'readfileStatus' => null,
		'aborted' => false
		);

	$res['readfileStatus'] = readfile($path);
	
	if ($res['readfileStatus'] === false)
	{
		$res['errors'][] = 'readfile failed.';
		$res['status'] = false;
	}

	if (connection_aborted())
	{
	#se il download e' stato annullato	

		$res['errors'][] = 'Connection aborted.';
		$res['aborted'] = true;
		$res['status'] = false;
	}

	return $res;
}

// Log downloads status
function Logs($res)
{
	global $logfile;

	$abort = $res['aborted']?'ABORT':'FINISH';
	
	$info = implode("\t", array($abort, date('[d/m/Y H:i:s]'), $_SERVER['REMOTE_ADDR'], 'File: "'.$res['file'].'"'));
	//cambiare ordine valori se necessario
	
	#touch( $info );
	
	@file_put_contents($logfile, $info."\n", FILE_APPEND | LOCK_EX);
	//LOCK_EX indispensabile senno se tra un download e un altro ce poco tempo non lo scrive sul log!
}

?>
