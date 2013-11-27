<!doctype html>
<html lang="<?=$this->lang?>" class="no-js">
<head>
	<meta charset="utf-8"/>
	<title><?php if (isset($this->title)) { echo "{$this->title} -"; }?> DistribuTube</title>
	<base href="<?= $this->base ?>" />
	<?php foreach ($this->styles as $style): ?>
	<?=$style?>
	<?php endforeach; ?>
	<script type="text/javascript" src="js/modernizr.custom.js"></script>
</head>
<body>
	<header class="main-header">
		<h1>DistribuTube</h1>
	</header>

	<div class="main-content">