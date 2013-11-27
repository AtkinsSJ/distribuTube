<?php
// Video displayed using http://www.videojs.com/
?>
<h1><?= $this->video->id ?> : <?= $this->video->title ?></h1>

<div class="video-wrapper">
	<video id="example_video_1" class="video-js vjs-default-skin"
		controls preload="auto"
		<?php /*poster="http://video-js.zencoder.com/oceans-clip.png"*/ ?> >
		<?php foreach ($this->video->sources as $format => $url): ?>
			<source src="<?= $url ?>?<?= time() ?>" type='video/<?= $format ?>' />
		<?php endforeach; ?>
	</video>
</div>