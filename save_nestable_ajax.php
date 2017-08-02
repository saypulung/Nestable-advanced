<?php
require_once('db_buku.class.php');
$db = new Database;
$db->connect();
$menu_order = 0;
global $menu_order;
function print_rec($d=array(),$parent = 0){
	global $db;
	global $menu_order;
	$bejo = 'asu';
	$iterator = new RecursiveArrayIterator($d);
	while($iterator->valid()){
		if($iterator->hasChildren()){
			$last_parent = 0;
			foreach ($iterator->getChildren() as $key => $value) {
				if(is_array($value)){
					print_rec($value,$last_parent);
				}else{
					$menu_order++;
					$last_parent = $value;
					$db->update('category',array('parent_ID'=>$parent,'`order`'=>$menu_order),'category_ID='.$value);
					echo "id : ".$value ." ; parent_id : ".$parent." ". "<br>";
				}
			}
		}
		$iterator->next();
	}
}
//$json_post = isset($_POST['nestable_output'])? json_decode($_POST['nestable_output']) : '';
//print_r($json_post);
$json_to_ar = json_decode($_POST['nestable_output']);
print_r($json_to_ar);
echo '<br>';
//print_rec($json_post);
echo '<br>';