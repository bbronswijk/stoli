<h1 class="page-title">Overzicht</h1>

<header id="bottlesHeader">
	<ul id="bottle-filter">
		<li class="filter-item">
			<a href="#" data-filter="all" class="selected" >All</a>
		</li>
		<li class="filter-item">
			<a href="#" data-filter="owner">Eigen</a>
		</li>
		<li class="filter-item">
			<a href="#" data-filter="present">Aanwezig</a>
		</li>

	</ul>
	<button id="add-bottle" class="btn red add" style="float:right;">
		nieuwe fles
	</button>
		
</header>

<!-- bottles are loaded using ajax and mustache -->
<ul id="bottles" class="items"></ul>