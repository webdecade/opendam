<div id="admin-tag-list-page" class="span12">
	<?php
		$orderBy = $orderBy->getRawValue();
		
		draw_breadcrumb(array(
			array("link" => path("@custom_tag_list"), "text" => __("Tag Search")),
		));
	?>

	<div class="search-block clearfix">
		<div class="pull-left">
			<form class="form-inline">
				<?php params_to_input_hidden(merge_query_params(null, array("orderBy", "page")));?>
				
				<label><?php echo __('Sort modules by')?></label>
				<select name="orderBy[]">
					<option <?php if (in_array("name_asc", $orderBy)) echo "selected";?> value="lastname_asc"><?php echo __("Name ascending")?></option>
					<option <?php if (in_array("name_desc", $orderBy)) echo "selected";?> value="lastname_desc"><?php echo __("Name descending")?></option>
					<option <?php if (in_array("created_at_asc", $orderBy)) echo "selected";?> value="created_at_asc"><?php echo __("Date ascending")?></option>
					<option <?php if (in_array("created_atl_desc", $orderBy)) echo "selected";?> value="created_at_desc"><?php echo __("Date descending")?></option>
				</select>
				
				<button class="btn"><i class="icon-search"></i></button>
			</form>
			
			<ul class="filter">
				<li>
					<a class="<?php if ($currentLetter === "") echo "selected"?>" href="<?php echo path("@custom_tag_list", 
							merge_request_params(null, array("letter", "page")));?>"><?php echo __('ALL')?>
					</a> 
				</li>
				
				<?php foreach ($letters as $letter):?>
					<li>
						<a class="<?php if ($letter == $currentLetter) echo "selected"?>" href="<?php echo path("@custom_tag_list", 
								merge_request_params(array("letter" => $letter), array("page")));?>"><?php echo $letter?>
						</a>
					</li>
				<?php endforeach;?>
			</ul>
	
		</div>

		<form class="form-search pull-right">
			<?php params_to_input_hidden(merge_query_params(null, array("keyword", "page")));?>

			<div class="input-append">
				<input name="keyword" type="text" class="input-medium search-query" placeholder="<?php echo __("Search")?>" value="<?php echo $keyword;?>">
				<button class="btn"><i class="icon-search"></i></button>
			</div>
		</form>
	</div>
	
	<table id="tag-list" class="table">
		<thead>
			<tr>
				<th class="span9"><?php echo __("Name")?></th>
				<th class="span3 text-centered"><?php echo __("Actions")?></th>
			</tr>
		</thead>
		
		<tbody>
			<?php if (!count($tags->getResults())):?>
				<tr>
					<td colspan="2"><?php echo __("No tag found.")?></td>
				</tr>
			<?php else:?>
				<?php foreach ($tags as $tag):?>
					<tr>
						<td><?php echo $tag->getName();?></td>
						<td class="text-centered">

							<a class="btn" href="http://citidam.mastermindmarketing.com/index.php/custom/keywords/<?=$tag->getId();?>/files">
								<?php echo __("View Files");?>
							</a>
						</td>
					</tr>
				<?php endforeach;?>
			<?php endif;?>
		</tbody>
	</table>

	<?php echo pagination($tags, "@admin_tag_list");?>
</div>
