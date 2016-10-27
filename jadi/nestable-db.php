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
			$this->append_tag_menu('<li class="dd-item" data-id="'.$b['category_ID'].'"><span class="right-icon"><a href="javascript:void(0)" onclick="append_form(\''.$b['category_ID'].'\')">Edit</a> | Hapus</span><div class="dd-handle" id="title_id_'.$b['category_ID'].'">'.$b['title'].'</div><div class="nestable-edit edit-id-'.$b['category_ID'].'"></div>');
				if($this->is_have_child($b['category_ID'])){
					$this->generate_category($b['category_ID']);
				}
				$this->append_tag_menu('</li>');
			}
			$this->append_tag_menu('</ol>');
		}
	}
	
}
	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>Nestable</title>
    <link rel="stylesheet" type="text/css" href="style-nestable.css"/>
	<style>
		.right-icon{
			float:right;
		}
		.nestable-edit{
			display:none;
		}
	</style>
</head>
<body>

    <h1>Nestable</h1>
<div class="cf nestable-lists">

    <div class="dd" id="nestable">
		<?php
			$menu = new Menu();
			$menu->init();
			$menu->generate_category();
			echo $menu->get_tag();
		?>
	</div>
</div>
<p id="status">Ready</p>

	<p><strong>Add/Edit Data</strong></p>
	<input type="hidden" id="mode_data" value="add"/>
	<input type="hidden" id="id_cat" value=""/>
	<select id="parent_id">
		<option value="0" selected>No Parent</option>		
	</select>
	<input type="text" placeholder="Name" id="category_name" required/><button id="add_data">Save</button>
    <p><strong>Serialised Output (per list)</strong></p>
	<form action="save_nestable_ajax.php" method="post">
		<textarea id="nestable-output" name="nestable_output"></textarea>
		<button type="submit" name="simpan" id="save_menu">Simpan</button>
	</form>


<script src="jquery.js"></script>
<script src="jquery.form.js"></script>
<script src="jquery.nestable.js"></script>
<script>

$(document).ready(function()
{
	
	
	$('.hide').hide();
	$.getJSON('add_or_edit_nestable.php?mode=get_data_select',function(data){
		$.each(data.hasil,function(){
			$('#parent_id').append('<option value="'+this['category_ID']+'">'+this['title']+'</option>');
		});
	});
    var updateOutput = function(e,f)
    {
		var data_output = '';
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
			data_output = window.JSON.stringify(list.nestable('serialize'));
            output.val(data_output);
        } else {
            output.val('[]');
        }
		if(f!=='first'){
			var posting = $.post('save_nestable_ajax.php',{nestable_output:data_output});
			posting.done(function(){
				$('#status').html('Saved');
				setTimeout(function(){
					$('#status').html('Ready');
				},2000);
				console.log('post to : '+data_output);
			});
		}
		
		//console.log('changed');
    };
    $('#nestable').nestable({
        group: 1
    })
    .on('change', updateOutput);
    updateOutput($('#nestable').data('output', $('#nestable-output')),'first');
});
$('#add_data').click(function(){
	var parent_id = $('#parent_id').val();
	var title = $('#category_name').val();
	var mode = $('#mode_data').val();
	var id_cat = $('#id_cat').val();
	var posting;
	console.log(parent_id+' '+title+' '+mode+' '+id_cat);
    posting = $.post('add_or_edit_nestable.php?mode='+mode,{p_id:parent_id,t:title,m_order:'0',cat_id:id_cat});
	posting.done(function(data){
		console.log(data);
		location.reload();
	});
});
function append_form(id){
	$.getJSON('add_or_edit_nestable.php?mode=select_id&id='+id,function(data){
		if(data!==''){
			console.log(data);
			var template_form = '<div class="form_edit" id="form_edit_id'+id+'"><input type="hidden" id="cat_id_'+id+'"  value="'+id+'"/><input type="text" id="title_'+id+'" value="'+data.hasil[0]['title']+'"/><br><button onclick="save_edit(\''+id+'\')">Simpan</button><button onclick="remove_me('+id+')">Cancel</button>  </div>';
			console.log('id : '+id+' '+template_form);
			if(!$('#form_edit_id'+id).length){
				$('.edit-id-'+id).append(template_form);
				$('.edit-id-'+id).slideDown('slow');
			}
			
		}
	});
}
function remove_me(id){
	$('.edit-id-'+id).slideUp('slow');
	$('#form_edit_id'+id).remove();
}
function save_edit(id){
	var id_cat = $('#cat_id_'+id).val();
	var title = $('#title_'+id).val();
	var edit = $.post('add_or_edit_nestable.php?mode=edit',{t:title,cat_id:id_cat});
	edit.done(function(respon){
		console.log(respon);
		$('#status').html('Saved');
		setTimeout(function(){
			$('#status').html('Ready');
			$('#title_id_'+id).html(title);
		},2000);
	});
	remove_me(id);
}

</script>
</body>
</html>
