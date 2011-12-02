<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
</head>
<body>
<h3>Area Download</h3>
<ol>
	<li>Scarica <a href="./10MB">questo file vuoto</a> di 10 MBytes.</li>
	<li>Al termine del download ricarica la pagina</li>
	<li>Scarica di nuovo il file annullando prima del termine</il>
	<li>Finch&egrave; si annulla il download prima del termine, il contatore non cambia</li>
</ol>
<diV style="float:left;border:1px solid #ccc;padding:.5em;">
<? if($remain>0 and $remaintry>0): ?>
	<i>Puoi effettuare : <br />
	<b><?=$remain?></b> download completi
	<br />
	<b><?=$remaintry?></b> tentativi di download</i>
<? else: ?>
	<i>Hai terminato il numero massimo di download.</i>
<? endif; ?>
</div>
</body>
</html>
