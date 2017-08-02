<?php
   if(isset($_POST['simpan'])){
	   $data = $_POST['data'];
	   $d_arr = json_decode($data,true);
	   print_r($d_arr);
   }
