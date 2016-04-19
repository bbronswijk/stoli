<h1 class="page-title">Ideeën box</h1>
<div id="ideas">
	<form>
		<h3>Lever hier awesome verbeteringen in voor wiebetaaltdestoli.com!</h3>
		<input class="idea-input" type="text" name="idea" placeholder="vb: track & trace" /><button class="btn red idea">verzenden</button>
	</form>
	
	<ul class="list-ideas">
		<?php foreach ($this->ideas as $key => $value) { ?>
			<li class="idea">
				<div class="user"><?php echo $value['last_name']; ?></div>
				<div class="description"><?php echo $value['description']; ?></div>
			</li>
		<?php } ?>
	</ul>
	
</div>
