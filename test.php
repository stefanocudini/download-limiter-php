<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<style>
body {
	background:#21214e;
	color:#ccc
}
#copy {
	position:fixed;
	z-index:1000;
	right:140px;
	top:-6px;
	font-style:italic;
	font-size:.85em;
	padding:5px 8px;
	background: #3a3a74;
	border:2px solid #c5cdd4;
	border-radius:.7em;
	opacity: 0.8;
}
#copy a {
	color:#ccc;
}
#ribbon {
	position: absolute;
	top: 0;
	right: 0;
	border: 0;
	filter: alpha(opacity=80);
	-khtml-opacity: .8;
	-moz-opacity: .8;
	opacity: .8;		
}
</style>
</head>
<body>
<h3>PHP Download Limiter</h3>
<ol>
	<li>Scarica <a href="./10MB">questo file vuoto</a> di 10MBytes.</li>
	<li>Al termine del download ricarica la pagina</li>
	<li>Scarica di nuovo il file annullando prima del termine</il>
	<li>Finch&egrave; si annulla il download prima del termine, il contatore non cambia</li>
	<li>La velocita di download &egrave; sempre limitata a 100 KBytes/s</li>
</ol>
<div style="float:left;border:1px solid #ccc;padding:.5em;">
<? if($remain>0 and $remaintry>0): ?>
	<i>Puoi effettuare : <br />
	<b><?=$remain?></b> download completi
	<br />
	<b><?=$remaintry?></b> tentativi di download</i>
<? else: ?>
	<i>Hai terminato il numero massimo di download.</i>
<? endif; ?>
</div>
<div id="copy"><a href="http://labs.easyblog.it/">Labs</a> &bull; <a rel="author" href="http://labs.easyblog.it/stefano-cudini/">Stefano Cudini</a></div>
<a href="https://github.com/stefanocudini/download-limiter-php"><img id="ribbon" src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub"></a>

<script type="text/javascript" src="/labs-common.js"></script>
</body>
</html>
