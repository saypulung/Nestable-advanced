<?php
include_once 'db_buku.class.php';
$db = new Database;
$db->connect();
$title = '';
$parent_ID = '';
$menu_order = '';
if(!isset($_GET['mode'])){
	exit();
}
$mode = $_GET['mode'];
if($mode=='add'){
	$title = $_POST['t'];
	$parent_ID = (int)$_POST['p_id'];
	$menu_order = $_POST['m_order'];
	echo $title.' '.$parent_ID.' '.$menu_order;
	$db->insert('category',array('title'=>$title,'parent_ID'=>$parent_ID,'order'=>$menu_order,'type'=>'post'));
	echo $db->getSql();
	print_r($db->getResult());
	echo 'insert';
}
if($mode=='edit'){
	$title = $_POST['t'];
	$category_ID = $_POST['cat_id'];
	$db->update('category',array('title'=>$title),'category_ID='.$category_ID);
	echo 'Diedit su';
}
if($mode=='hapus'){
	
}
if($mode=='get_data_select'){
	$db->select('category','category_ID,title,parent_ID','type=\'post\'','`order` asc,category_ID desc');
	if($db->numRows()>0){
		$res = $db->getResult();
		echo json_encode(array('hasil'=>$res));
	}
}
if($mode=='select_id'){
	$id = $_GET['id'];
	$db->select('category','category_ID,title,parent_ID','type=\'post\' and category_ID='.$id,'`order` asc,category_ID desc');
	if($db->numRows()>0){
		$res = $db->getResult();
		echo json_encode(array('hasil'=>$res));
	}
}