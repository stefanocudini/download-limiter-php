<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "https://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<title>PHP Download Bandwidth Limiter</title>
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
	<li>For test <a href="./10MB">download this empty file</a> with size 10MBytes.</li>
	<li>When the downloade refresh this page.</li>
	<li>Download the file again canceling before the end.</il>
	<li>As long as you cancel the download before the end, the counter does not change.</li>
	<li>The download speed is always limited to 100 KBytes / s </li>
</ol>
<div style="float:left;border:1px solid #ccc;padding:.5em;">
<?php if($remain>0 and $remaintry>0): ?>
	<i>Remain: <b><?=$remain?></b> downloads.</i>
	<br />
	<i>Attempts: <b><?=$remaintry?></b> downloads</i>
<?php else: ?>
	<i>You have completed the maximum number of downloads.</i>
<?php endif; ?>
</div>
<small>Is not based on cookies</small>
<div id="copy"><a href="https://opengeo.tech/">Labs</a> &bull; <a rel="author" href="https://opengeo.tech/stefano-cudini/">Stefano Cudini</a></div>
<a href="https://github.com/stefanocudini/download-limiter-php"><img id="ribbon" src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub"></a>

<script type="text/javascript" src="/labs-common.js"></script>
</body>
</html>
