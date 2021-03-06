<?php
if(!empty($_GET["filename"]) && !empty($_GET["year"])){
	$_filetitle = (ucfirst($_GET["filename"]));
	$_filename = (($_GET["filename"]).".json");
	$_filename = (($_GET["year"])."/".($_filename));
	if(file_exists($_SERVER["DOCUMENT_ROOT"]."/api/docx/".($_filename))){
		Header("Content-Type:Application/JSON");
		Require_Once($_SERVER["DOCUMENT_ROOT"]."/api/docx/".($_filename));
	}elseif(!file_exists($_SERVER["DOCUMENT_ROOT"]."/api/docx/".($_filename))){
		echo("<title>Blog Docx Files</title>");
		echo("<code>Coming Soon...</code>");
	}
}elseif(empty($_GET["filename"]) || empty($_GET["year"])){
	$_dir = scandir($_SERVER["DOCUMENT_ROOT"]."/api/docx/");
	$_year = [];
	$_yearDir = [];
	$_blog = [];
	Header("Content-Type:Application/JSON");
	foreach($_dir as $_token => $_coin){
		if($_coin == "." || $_coin == ".."){
			continue;
		}else{
			$_yearDir[] = (scandir($_SERVER["DOCUMENT_ROOT"]."/api/docx/".$_coin."/"));
			$_year[] = ($_coin);
		}
	}
	for($_g = 0;$_g <= count($_year)-1;$_g++){
		foreach($_yearDir[$_g] as $_token => $_coin){
			if($_coin == "." || $_coin == ".."){
				continue;
			}else{
				$_filename = explode(".",$_coin)[0];
				$_blog[] = (["link"=>"//".$_SERVER["HTTP_HOST"]."/blog/".($_filename)."/".($_year[$_g]),"blog_id"=>$_filename,"year"=>$_year[$_g]]);
			}
		}
	}	
	echo(json_encode($_blog,JSON_PRETTY_PRINT));
}//
?>