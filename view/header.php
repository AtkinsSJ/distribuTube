<!doctype html>
<html lang="<?=$this->lang?>" class="no-js">
<head>
	<meta charset="utf-8"/>
	<title><?php if (isset($this->title)) { echo "{$this->title} -"; }?> DistribuTube</title>
	<base href="<?= $this->base ?>" />
	<?php foreach ($this->styles as $style): ?>
	<?=$style?>
	<?php endforeach; ?>
</head>
<body>