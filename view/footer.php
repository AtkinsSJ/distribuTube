	</div>

	<footer class="main-footer">
		Site powered by <a href="https://github.com/AtkinsSJ/distribuTube">DistribuTube</a>
	</footer>
	
	<?php // Page-specific JS files
	foreach ($this->js as $js):?>
		<script type="text/javascript" src="<?=$js;?>"></script>
	<?php endforeach; ?>
</body>
</html>