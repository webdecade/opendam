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
#filter-body { 
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
.box { 
	border-width: 2px;
	border-style: solid;
	border-color: #5383BC;
	box-shadow: 1px 1px 1px #888888;
	margin-bottom: 25px;
}
</style>


<?php // Build out topbar date search to runs off of the date tag associated with a file ?>
<div class="search-block clearfix">

	<div class="pull-left">
		<ul class="inline list-actions ">
<li>
<a id="add_main_folder_button" href="/index.php/admin/albums/new" style="color:#333333;">
<i class="icon-plus-sign"></i>
Create an album
</a>
</li>
</u>
	</div>
	<div class="pull-right">
		<div class="custom-select">
			From &nbsp; &nbsp;<input type="text" name="startdt">&nbsp;&nbsp; (clear)&nbsp;&nbsp; 
			To &nbsp; &nbsp;<input type="text" name="enddt">&nbsp;&nbsp; (clear) &nbsp;&nbsp; <input type="button" name="show" value="show">	
		</div>
	</div>
</div>	
<div class="main-body">
    <div id="filter-body" class="box">
    	<div class="filter-header">Filter Results</div>
        <?php  //include_partial("citisearch/FilterList", array("selected" => "list", "albums" => $albums));?>
    </div>
    <div class="filter-results">
    	<div class="filter-results-left">
        	<div id="partners" class="box"><div class="filter-header">Existing Partners</div>
<ul>
					<?php if (!count($albums->getResults())):?>
				<li><?php echo __("No album found.")?></li>
			<?php else:?>
				<?php foreach ($albums as $album):?>
					<li><?php echo $album->getName();?></li>
				<?php endforeach;?>
			<?php endif;?>
		
	</ul>
        </div>
        	<div id="business-development" class="box"><div class="filter-header">Business Development</div></div>
        </div>
        <div class="filter-results-right">
        	<div id="user-studies" class="box"><div class="filter-header">User Studies</div></div>
        	<div id="presentations" class="box"><div class="filter-header">Presentation</div></div>
        	
        	
    	</div>
    </div>
</div>