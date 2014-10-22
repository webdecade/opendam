<h1>Citi Search</h1>
<style>
.filter-header {
	max-width:300px;
	min-width:240px;
	height:30px;
	text-align: center;
	font-size: 20px;
	font-weight: bold;
	background-color: #6FA2E7;
	color: #ffffff;
	padding-top: 20px;
	margin-bottom: 25px;

}
.filter-body { 
	float:left;
}
.filter-results {
	float:left;
	width:600px;
	padding-left: 100px;
}

#partners{ 
	float:left;
	
}
#user-studies{
	float:right;
	
}
#business-development{
		float:left;
		
}
#presentations{
	float:right;
	
}
.filter-results-left{
	width:300px;
	float: left;
	
}
.filter-results-right{
	width:300px;
	float: right;
	
}
.main-body{ padding-top: 20px;}

</style>
<?php // Build out topbar date search to runs off of the date tag associated with a file ?>
<div class="search-block clearfix">
</div>	
<div class="main-body">
    <div class="filter-body">
    	<div class="filter-header">Filter Results</div>
        <?php  //include_partial("citisearch/FilterList", array("selected" => "list", "albums" => $albums));?>
    </div>
    <div class="filter-results">
    	<div class="filter-results-left">
        	<div id="partners" class="results odd"><div class="filter-header">Existing Partners</div></div>
        	<div id="business-development" class="results odd"><div class="filter-header">Business Development</div></div>
        </div>
        <div class="filter-results-right">
        	<div id="user-studies" class="results even"><div class="filter-header">User Studies</div></div>
        	<div id="presentations" class="results even"><div class="filter-header">Presentation</div></div>
        	
        	
    	</div>
    </div>
</div>