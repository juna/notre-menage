<div class="articles_list">
	<?php
		foreach ($res_articles->all as $obj_article)
		{
			$categories = '';
			foreach ($obj_article->articlecategories->get()->all as $obj_articlecategory)
			{
				$categories .= $obj_articlecategory->title . ' ';
			}
			
			echo '
	<div class="article">
		<h2>' . $obj_article->title . '</h2>
		<p class="intro">
			' . $obj_article->intro . '
		</p>
		<a href="' . base_url() . 'artikel/' . $obj_article->alias . '" class="readon">... weiterlesen!</a>
		<p class="subinfo">
			Geschrieben am xx<br/>
			Abgelegt in den Kategorien: ' . $categories . '
		</p>
	</div>
	
	';
		}
	?>
</div>