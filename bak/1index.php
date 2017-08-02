<?php
require_once 'mysql_crud.php';
$d = '[{"id":15,"children":[{"id":20},{"id":17},{"id":2},{"id":3},{"id":9},{"id":10},{"id":11},{"id":12},{"id":14},{"id":13}]},{"id":16,"children":[{"id":6},{"id":7},{"id":8}]},{"id":4},{"id":5}]';
$data = json_decode($d , TRUE);
print_r($data);
echo '<br>';
$hasil_simpan = array();
function print_rec($d=array(),$parent = 0){
	$iterator = new RecursiveArrayIterator($d);
	while($iterator->valid()){
		if($iterator->hasChildren()){
			$last_parent = 0;
			foreach ($iterator->getChildren() as $key => $value) {
				if(is_array($value)){
					print_rec($value,$last_parent);
				}else{
					$last_parent = $value;
					echo "id : ".$value ." ; parent_id : ".$parent." ". "<br>";
				}
			}
		} else {
			echo "No children.\n";
		}

		$iterator->next();
	}
}

echo '<br>'.print_rec($data);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>Nestable</title>
    <link rel="stylesheet" type="text/css" href="style-nestable.css"/>
</head>
<body>

    <h1>Nestable</h1>

    

    <menu id="nestable-menu">
        <button type="button" data-action="expand-all">Expand All</button>
        <button type="button" data-action="collapse-all">Collapse All</button>
    </menu>

    <!--div class="cf nestable-lists">
        <div class="dd" id="nestable">
            <ol class="dd-list">
                <li class="dd-item" data-id="1">
                    <div class="dd-handle">Item 1</div>
                </li>
                <li class="dd-item" data-id="2">
                    <div class="dd-handle">Item 2</div>
                    <ol class="dd-list">
                        <li class="dd-item" data-id="3">
							<div class="dd-handle">Item 3</div>
						</li>
                        <li class="dd-item" data-id="4">
							<div class="dd-handle">Item 4</div>
						</li>
                        <li class="dd-item" data-id="5">
                            <div class="dd-handle">Item 5</div>
                            <ol class="dd-list">
                                <li class="dd-item" data-id="6"><div class="dd-handle">Item 6</div></li>
                                <li class="dd-item" data-id="7"><div class="dd-handle">Item 7</div></li>
                                <li class="dd-item" data-id="8"><div class="dd-handle">Item 8</div></li>
                            </ol>
                        </li>
                        <li class="dd-item" data-id="9">
							<div class="dd-handle">Item 9</div>
						</li>
                        <li class="dd-item" data-id="10">
							<div class="dd-handle">Item 10</div>
						</li>
                    </ol>
                </li>
                <li class="dd-item" data-id="11">
                    <div class="dd-handle">Item 11</div>
                </li>
                <li class="dd-item" data-id="12">
                    <div class="dd-handle">Item 12</div>
                </li>
            </ol>
        </div>
    </div-->
	
<div class="cf nestable-lists">

    <div class="dd" id="nestable">
        <ol class="dd-list">
            <li class="dd-item" data-id="15">
                <div class="dd-handle"> Berita</div>
                <ol class="dd-list">
                    <li class="dd-item" data-id="20">
                        <div class="dd-handle"> Berita Desa</div>
					</li>
					<li class="dd-item" data-id="17">
						<div class="dd-handle"> Umum</div>
					</li>
					<li class="dd-item" data-id="2">
						<div class="dd-handle"> Berita Lampung Timur</div>
					</li>
                    <li class="dd-item" data-id="3">
						<div class="dd-handle"> Berita Lampung</div>
					</li>
                    <li class="dd-item" data-id="9">
                        <div class="dd-handle"> Nasional</div>
                    </li>
                    <li class="dd-item" data-id="10">
                        <div class="dd-handle"> Internasional</div>
					</li>
                    <li class="dd-item" data-id="11">
						<div class="dd-handle"> Lifestyle</div>
					</li>
                    <li class="dd-item" data-id="12">
						<div class="dd-handle"> Lingkungan</div>
					</li>
					<li class="dd-item" data-id="14">
						<div class="dd-handle"> Sosok</div>
					</li>
                    <li class="dd-item" data-id="13">
                        <div class="dd-handle"> Pendidikan</div>
					</li>
                </ol>
                <li class="dd-item" data-id="16">
                    <div class="dd-handle"> Artikel</div>
                    <ol class="dd-list">
                        <li class="dd-item" data-id="6">
							<div class="dd-handle"> Opini</div>
						</li>
                        <li class="dd-item" data-id="7">
                            <div class="dd-handle"> Cerpen</div>
						</li>
                        <li class="dd-item" data-id="8">
                            <div class="dd-handle"> Puisi</div>
						</li>
                    </ol>
				</li>
                <li class="dd-item" data-id="4">
                    <div class="dd-handle"> Keliling Lampung Timur</div>
				</li>
                <li class="dd-item" data-id="5">
                    <div class="dd-handle"> Lamtim Menulis</div>
				</li>
        </ol>
    </div>
</div>
    <p><strong>Serialised Output (per list)</strong></p>
	<form action="save_menu.php" method="post">
    <textarea id="nestable-output" name="data"></textarea>
    <button type="submit" name="simpan" id="save_menu">Simpan</button>
	</form>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="jquery.nestable.js"></script>
<script>

$(document).ready(function()
{
	
    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };

    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 1
    })
    .on('change', updateOutput);

    // activate Nestable for list 2
    $('#nestable2').nestable({
        group: 1
    })
    .on('change', updateOutput);

    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));
    updateOutput($('#nestable2').data('output', $('#nestable2-output')));

    $('#nestable-menu').on('click', function(e)
    {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

    $('#nestable3').nestable();

});
</script>
</body>
</html>
