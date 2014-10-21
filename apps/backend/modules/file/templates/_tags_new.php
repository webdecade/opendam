<?php
	$tag_types = array(
		array(
			'name' => 'Retailer',
			'slug' => 'retailer',
		),
		array(
			'name' => 'Asset Type',
			'slug' => 'asset-type',
		),
		array(
			'name' => 'Placement',
			'slug' => 'placement',
		),
		array(
			'name' => 'Channel',
			'slug' => 'channel',
		),
		array(
			'name' => 'Delivery Date',
			'slug' => 'delivery-date',
		),
		array(
			'name' => 'Placement Type',
			'slug' => 'placement-type',
		),
		array(
			'name' => 'Messaging Focus',
			'slug' => 'messaging-focus',
		),
		array(
			'name' => 'Page Type',
			'slug' => 'page-type',
		),
	);
?>

<h4>Asset Tags</h4>

<div id="nav-bottom-file-tags">
	<ul>
		<?php 
			foreach($tag_types as $idx => $tag_type) : 
				$li_class = $idx == 0 ? 'first' : 'in';
				$a_class = $idx == 0 ? ' class="active"' : '';
		?>
		<li class="<?php echo $li_class ?>"><a<?php echo $a_class ?> href="javascript:" rel="tags-<?php echo $tag_type['slug'] ?>"><?php echo __($tag_type['name']) ?></a></li>
		<?php endforeach; ?>
	</ul>
</div>

<div id="content-bottom-file-tags">
	<?php foreach($tag_types as $idx => $tag_type) : ?>
	<div id="tags-<?php echo $tag_type['slug'] ?>" class="content-bottom"<?php echo $idx > 0 ? ' style="display: none;"' : '' ?> data-position="<?php echo $idx+1 ?>">
		<div class="comment_file" style="min-height: 300px;">
			<div style="position:relative;">
				<?php if($role) : ?>
				<div class="add add-comment left" style="width: 90%; margin-top: 0px;">
					<div class="textarea-wrapper">
						<ul id="tag_title" style="border: 0; margin: 0; min-height: 24px;"></ul>
					</div>
				</div>
		
				<a class="left" href='javascript: void(0);' style="margin-left: 5px; margin-top: 8px;" id='addTagRemote'><?php echo image_tag("icons/add4Bis.gif", array("align"=>"absmiddle")); ?></a>
				<span id="indicator" style="margin-left: 5px; display: none;"><?php echo image_tag('icons/loader/small-yellow-circle.gif', array('style'=>'vertical-align: -12px;'))?></span>
		
				<br clear="all" />
				<br clear="all" />
				<?php endif; ?>
			
				<div id="file_tags" class="cloud-tag-file">
					<?php $file_tags = FileTagPeer::retrieveByFileIdType(3, $file->getId());?>
					
					<?php foreach ($file_tags as $file_tag):?>
						<a class="label" href='javascript: void(0);' id="file_tag_<?php echo $file_tag->getId(); ?>"><?php echo $file_tag->getTag(); ?><i class='icon-remove-sign'></i></a>
						<script>
							jQuery(document).ready(function() {
								jQuery("#file_tag_<?php echo $file_tag->getId(); ?>").bind("click", function() {
									jQuery('#indicator').show();
									jQuery.post(
										"<?php echo url_for("tag/removeByUser?id=".$file_tag->getId()."&file_id=".$file_tag->getFileId()); ?>",
										{ "type": 3, "file_id": jQuery('#file_id').val(), "id": "<?php echo $file_tag->getId(); ?>" },
										function(data) {
											jQuery('#indicator').hide();
											jQuery('#file_tag_<?php echo $file_tag->getId(); ?>').remove();
										}
									);
								});
							});
						</script>
					<?php endforeach;?>
				</div>

				<?php if($role) : ?>
					<script type="text/javascript">
						function onTagFocus(obj)
						{
							if(obj.value.toLowerCase() == "<?php echo __("add tag ...")?>")
							{
								obj.value = "";
								jQuery(obj).removeClass("nc");
							}
						}
			
						function onTagBlur(obj)
						{
							if(obj.value == "")
							{
								obj.value = "<?php echo __("Add tag ...")?>";
								jQuery(obj).addClass("nc");
							}
						}
			
						jQuery(document).ready(function() {
							jQuery("#tag_title").tagit({
								tagSource: '<?php echo url_for("tag/fetchTags"); ?>',
								triggerKeys: ['enter', 'comma', 'tab'],
								minLength: 3,
								select: true,
								checkEmail: false,
								initialText: "<?php echo __("Add tag ..."); ?>",
								saveOnblur: true
							});
			
							jQuery('#addTagRemote').bind("click", function() {
								var values = jQuery("select.tagit-hiddenSelect").val();
			
								if(jQuery.trim(values).length > 0)
								{
									jQuery(this).fadeOut(200, function() {
										jQuery('#indicator').fadeIn(200, function() {
											jQuery.post(
												"<?php echo url_for('tag/addByUser?file_id='.$file->getId()); ?>",
												{ tag_title: values },
												function(data) {
													jQuery('#file_tags').html(data);
													jQuery('#indicator').fadeOut(200, function() {
														jQuery("#tag_title").tagit("reset");
														jQuery('#addTagRemote').fadeIn()
													});
												}
											);
										});
									});
								}
							});
						}); 
					</script>
				<?php endif; ?>
			</div>
		</div>
		<?php if($sf_user->haveAccessModule(ModulePeer::__MOD_THESAURUS) && $role): ?>
		<div class="comment_file" style="margin-left: 2%; min-height: 300px;">
			<?php include_partial("file/thesaurus", array("file" => $file)); ?>
		</div>
		<?php endif; ?>
	</div>
	<?php endforeach; ?>
</div>