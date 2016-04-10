<?php 

/*###################### CONSTANT ##########################################*/

define("MAIN_URI", "http://www.momocuppy.com/", true);

/*###################### END CONSTANT ##########################################*/





/*###################### start misc ##########################################*/

// is_selected

function is_selected($condition1,$condition2,$condition3,$condition4){

	if($condition1 == $condition2){

		return $condition3;

	}else{

		return $condition4;

	}

}





function page($totalpage,$page,$link,$anchor){
	$varpaging = "";




	if($totalpage > 1){
		if(!is_numeric($page) || $page > $totalpage){
			$intpage = 1;
		}else{
			$intpage = $page;
		}

	

		//first page
		if($intpage == 1){
			$varpref = "";
		}else{
			$countp = $intpage - 1;
			$varpref = "<li><a href=\"".$link."&amp;p=".$countp.$anchor."\">&laquo; PREV |</a></li>\n";		
		}
		//end first page

		

		$varpaging =  " <ul class=\"paging\">\n";
		$varpaging = $varpaging.$varpref;	

		for($i=1;$i<=$totalpage;$i++){
			$varpaging = $varpaging . "<li><a href=\"".$link."&amp;p=".$i.$anchor."\" ".is_selected($page,$i,"class=\"selected\"","").">".$i."</a></li>\n";
		}

		//last page
		if($intpage > $totalpage){
			$varnext = "<li><a href=\"".$link."&amp;p=".$totalpage.$anchor."\">| NEXT &raquo;</a></li>\n";
		}elseif($intpage == $totalpage){
			$varnext = "";
		}else{
			$countn = $intpage + 1;
			$varnext = "<li><a href=\"".$link."&amp;p=".$countn.$anchor."\">| NEXT &raquo;</a></li>\n";		
		}		

		$varpaging = $varpaging.$varnext;
		//end last page		
		

		$varpaging = $varpaging."</ul>";		
	}	
	return $varpaging;
}

/*###################### end misc ##########################################*/

/*###################### std query ##########################################*/
function get_newid($table,$col){
	global $db;
	$newid = $db->get_row("select max(".$col.") as id from ".$table."");
	(is_null($newid->id)) ? $id = 1 : $id = $newid->id + 1;
	return $id;
}
/*###################### std query ##########################################*/

?>