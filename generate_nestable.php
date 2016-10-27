<?php
include_once 'db_buku.class.php';
class Menu{
	private $db;
	private $tag_menu;
	public function __construct(){
		$this->db= new Database();
		$this->db->connect();
		$this->tag_menu = '';
	}
	public function init(){
		$this->db= new Database();
		$this->db->connect();
		$this->tag_menu = '';
	}
	public function append_tag_menu($args){
		$this->tag_menu.=$args;
	}
	public function get_tag(){
		return $this->tag_menu;
	}
	public function reset_tag(){
		$this->tag_menu = '';
	}
	function is_have_child($category_id){
		$a = new Database;
		$a->connect();
		$a->sql("SELECT category_ID FROM category WHERE parent_ID='".$category_id."'");
		if($a->numRows()>0){
			return TRUE;
		}else{
			return FALSE;
		}
		return FALSE;
	}
	public function generate_category($parent = 0){
		$this->db->sql("SELECT * FROM `category` WHERE parent_ID='".$parent."' ORDER BY `order` ASC");
		if($this->db->numRows()>0){
			$a = $this->db->getResult();
			$this->append_tag_menu('<ol class="dd-list">');
			foreach($a as $b){
				//echo $b['title'];
			$this->append_tag_menu('<li class="dd-item" data-id="'.$b['category_ID'].'">
				<span class="right-icon"><a href="javascript:void(0)" onclick="append_form(\''.$b['category_ID'].'\')">Edit</a> | Hapus</span>
				<div class="dd-handle" id="title_id_'.$b['category_ID'].'">'.$b['title'].'</div>
				<div class="nestable-edit edit-id-'.$b['category_ID'].'"></div>');
				if($this->is_have_child($b['category_ID'])){
					$this->generate_category($b['category_ID']);
				}
				$this->append_tag_menu('</li>');
			}
			$this->append_tag_menu('</ol>');
		}
	}
	
}
$cat = new Menu;
$cat->generate_category();
echo $cat->get_tag();
	
?>