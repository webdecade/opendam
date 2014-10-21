<?php
$link = mysql_connect("localhost","root","sO[p15xLw*2TJlXo") or die('Could not connect: ' . mysql_error());
echo 'Connected successfully';
mysql_select_db('opendam') or die('Could not select database');

// Performing SQL query
$query = 'SELECT file.*, groupe.name as groupe_name FROM `file` LEFT JOIN `groupe` ON file.groupe_id=groupe.id WHERE file.id ="'.$_GET['id'].'"';
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    print_r($line);
    $query_new = 'SELECT * FROM `import` WHERE file_name ="'.$line['original'].'" AND album ="'.$line['groupe_name'].'"';
	$result_new = mysql_query($query_new) or die('Query failed: ' . mysql_error());
	if(mysql_num_rows($result_new) > 0){
		while ($line_new = mysql_fetch_array($result_new, MYSQL_ASSOC)) {
			print_r($line_new);
			$tags = explode(',',$line_new['tags']);
			print_r($tags);
			$tag_ids = array();
			$query_remove = 'DELETE FROM file_tag WHERE file_id ="'.$line['id'].'"';
			mysql_query($query_remove) or die('Query failed: ' . mysql_error());
			foreach($tags as $tag){
				$query_tag = 'SELECT id FROM `tag` WHERE title ="'.rtrim(ltrim(str_replace("'","",$tag))).'"';
				$result_tag = mysql_query($query_tag) or die('Query failed: ' . mysql_error());
				if(mysql_num_rows($result_tag) > 0){
					$tag_id = mysql_fetch_row($result_tag);
					$tag_ids[] = $tag_id[0];
					$sql_tag="INSERT INTO file_tag (file_id, tag_id, type) VALUES ('".$line['id']."', '".$tag_id[0]."', '3')";
					mysql_query($sql_tag) or die('Query failed: ' . mysql_error());
				}else{
					echo "No Tag Found ".rtrim(ltrim(str_replace("'","",$tag)));
					$sql_insert_tag="INSERT INTO tag (title, customer_id) VALUES ('".rtrim(ltrim($tag))."', '1')";
					mysql_query($sql_insert_tag) or die('Query failed: ' . mysql_error());
					$sql_tag="INSERT INTO file_tag (file_id, tag_id, type) VALUES ('".$line['id']."', '".mysql_insert_id()."', '3')";
					mysql_query($sql_tag) or die('Query failed: ' . mysql_error());
					//echo "No Tag Found ".rtrim(ltrim($tag));	
				}
				//mysql_query($sql_tag) or die('Query failed: ' . mysql_error());
			}
			$sql_update="UPDATE file SET description='".str_replace("'","",$line_new['description'])."' WHERE id='".$line['id']."'";
			mysql_query($sql_update) or die('Query failed: ' . mysql_error());
			print_r($tag_ids);
		}
	}else{
		echo "No Match Found";
		$query_new = 'SELECT * FROM `import` WHERE file_name ="'.$line['name'].'"';
		$result_new = mysql_query($query_new) or die('Query failed: ' . mysql_error());
		if(mysql_num_rows($result_new) > 0){
			while ($line_new = mysql_fetch_array($result_new, MYSQL_ASSOC)) {
				print_r($line_new);
				$tags = explode(',',$line_new['tags']);
				print_r($tags);
				$tag_ids = array();
				$query_remove = 'DELETE FROM file_tag WHERE file_id ="'.$line['id'].'"';
				mysql_query($query_remove) or die('Query failed: ' . mysql_error());
				foreach($tags as $tag){
					$query_tag = 'SELECT id FROM `tag` WHERE title ="'.rtrim(ltrim(str_replace("'","",$tag))).'"';
					$result_tag = mysql_query($query_tag) or die('Query failed: ' . mysql_error());
					if(mysql_num_rows($result_tag) > 0){
						$tag_id = mysql_fetch_row($result_tag);
						$tag_ids[] = $tag_id[0];
						$sql_tag="INSERT INTO file_tag (file_id, tag_id, type) VALUES ('".$line['id']."', '".$tag_id[0]."', '3')";
						mysql_query($sql_tag) or die('Query failed: ' . mysql_error());
					}else{
						echo "No Tag Found ".rtrim(ltrim(str_replace("'","",$tag)));
						$sql_insert_tag="INSERT INTO tag (title, customer_id) VALUES ('".rtrim(ltrim(str_replace("'","",$tag)))."', '1')";
						mysql_query($sql_insert_tag) or die('Query failed: ' . mysql_error());
						$sql_tag="INSERT INTO file_tag (file_id, tag_id, type) VALUES ('".$line['id']."', '".mysql_insert_id()."', '3')";
						mysql_query($sql_tag) or die('Query failed: ' . mysql_error());
						//echo "No Tag Found ".rtrim(ltrim($tag));	
					}
					//mysql_query($sql_tag) or die('Query failed: ' . mysql_error());
				}
				$sql_update="UPDATE file SET description='".str_replace("'","",$line_new['description'])."' WHERE id='".$line['id']."'";
				mysql_query($sql_update) or die('Query failed: ' . mysql_error());
				print_r($tag_ids);
			}
		}else{
			echo "Still, No Match Found ".$line['name'];
		}
	}
}

?>
