<?
//per file troppo piccoli si ottiene il blocco dello scaricamento anche se il download e' stato annullato dal browser!!!
$logfile = './downloads.log';
$countfile = './countdown.log';
$counttryfile = './countinit.log';
$maxdownload = 5;
//limite di download completi per uno stesso file
$maxtrydown = 10;
//limite di tentativi di download per uno stesso file
$limitRate = '100k';
//limite di banda in download
$dirdown = "/var/www/easyblog.it/download/";
//directory in cui cercare i file da scaricare!
//puo cercare anche delle subdirectory di $dirdown! basta specificarlo nel parametro passato allo script
//da mettere fuori!! della document_root
$target = basename($_SERVER['QUERY_STRING']);

if(empty($target)):

	//pagina con file di prova
	$cdown = count( array_keys(file($countfile),'10MB'."\n") );
	$ctry  = count( array_keys(file($counttryfile),'10MB'."\n") );
	$remain = $maxdownload - $cdown;
	$remaintry = $maxtrydown - $ctry;
	include('test.php');

else:

	$path = file_exists($dirdown.$target) ? $dirdown.$target : NotFound();

	$cdown = count( array_keys(file($countfile),$target."\n") );
	$ctry  = count( array_keys(file($counttryfile),$target."\n") );
	
	if( $cdown >= $maxdownload )
		 NotFound("Hai superato il numero massimo di download per questo file");
		 #eliminare il file! e toglierlo da dentro $countfile
	elseif( $ctry >= $maxtrydown )
		 NotFound("Hai superato il numero massimo tentativi di download per questo file");
	else
	{
		$res = sendFile($path);
	}
	
	if($res['aborted']===false)
		@file_put_contents($countfile, $target."\n", FILE_APPEND | LOCK_EX);
	else
		@file_put_contents($counttryfile, $target."\n", FILE_APPEND | LOCK_EX);

	#se il download non e' stato annullato	
	
	Logs($res);
	//forse mettere una exit() dentro Logs() senno continua l'esecuzione del php...
endif;


function NotFound($mes=false)
{
    header('HTTP/1.0 404 Not Found');
    exit(!$mes?"File non disponibile per il download":$mes);
}

function readfileLimit($file, $limit='100k')
{
	$bsize = 1024;
	$f = popen("pv -B $bsize -L $limit '$file'", 'r');
	if($f===false)
		return false;
	while(!feof($f))
	{
		echo fread($f, $bsize);
		flush();
	}
	fclose($f);
}

function sendFile($path, $contentType='application/octet-stream')
{
	global $target;
	global $limitRate;
	
	ignore_user_abort(true);
	//continua a eseguire php anche se il browser ha stoppato l'esecuzione

	header('Content-Transfer-Encoding: binary');
	header('Content-Disposition: attachment; filename="'.basename($path) . "\";");
	header("Content-Transfer-Encoding: binary");	
	header("Content-Type: ".mime_content_type(basename($path)));
	header("Content-Length: ".@filesize($path));

	$res = array(
		'file' => $target,
		'status' => false,
		'errors' => array(),
		'readfileStatus' => null,
		'aborted' => false
		);

	$res['readfileStatus'] = readfileLimit($path,$limitRate);
	
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
