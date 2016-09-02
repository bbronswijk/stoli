<h1 class="page-title">Dashboard</h1>

<div class="graph col col-32"> 
	<h2  style="margin-bottom: 10px;" >Borrels</h2>
	<canvas class="aantal-borrels" width="800" height="280"></canvas>
	<!-- <div class="chart dateAdded"></div>-->
</div>

<div id="profiteur-container" class="graph col col-3"> 
	<h2>GROOTSTE PROFITEUR</h2>
	<h3 style="margin-top: 10px;"> </h3>
	<div class="profiteur">
		<img class="profiteur-img" src="<?php echo URL; ?>img/profile.png" alt="schrale baas" />
	</div>
	<i>a.k.a. Schrale Anus</i>
	<span> </span>
</div>


<div class="graph col col-3"> 
	<h2>Statistieken</h2>
	<table>
		<tr>
			<th>flessen</th>
			<td class="amount-bottles"></td>
		</tr>
		<tr>
			<th>deelnemers</th>
			<td class="amount-users"></td>
		</tr>
		<tr>
			<th>Liters</th>
			<td class="amount-liters"></td>
		</tr>
		<tr>
			<th> </th>
			<td> </td>
		</tr>
		<tr>
			<th>Meeste Flessen</th>
			<td class="most-bottles"></td>
		</tr>
		<tr>
			<th>Stoli Koning</th>
			<td class="stoli-koning"> </td>
		</tr>
		<tr>
			<th>Hoogste Level</th>
			<td class="most-xp"></td>
		</tr>
		<tr>
			<th>Level</th>
			<td  class="most-level"></td>
		</tr>
	</table>
	<div class="statics-background"></div>
</div>

<div class="graph col  col-32"> 
	<h2>XP</h2>
	<div class="chart horBarChart ct-major-twelfth"></div>
</div>

<div class="graph col col-22" style="text-align: center; overflow: visible;"> 
	<h2 style="text-align: left;">Stoli gedronken/gekocht</h2>	
	<canvas id="myRadarChart" class="verhouding-drunk-bought" width="200" height="200"></canvas>
</div>

<div class="graph col col-22" style="text-align: center;"> 
	<h2 style="text-align: left;">Verdeling Flessen</h2>
	<div style="padding: 40px;">
		<canvas class="verdeling-flessen" width="300" height="300"></canvas>
	</div>
</div>

<div class="graph col col-1" style="height: 400px;"> 
	<h2>Stoli gedronken/gekocht</h2>
	<div class="chart barChart"></div>
</div>
