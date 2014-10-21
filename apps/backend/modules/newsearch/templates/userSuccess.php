<h1>User Data Array</h1>

<?php
foreach($userdata as $key => $value){
    echo '<br/>'.$key.': '.$value;
}
echo print_r($userdata,true);
?>