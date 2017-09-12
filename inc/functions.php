<?php
	include("config.php");
	include("objects.php");
	
	$conn_obj = new db("127.0.0.1","root","dani300");
	$conn = $conn_obj->getConnection();
	
	
	
	function getCataloguesWithSubCatalogues($json = NULL) {
		global $conn;
		$res = $conn->query("select * from `catalogues`");
		$res_ = $res->fetchAll(PDO::FETCH_ASSOC);
		
		$last = array();
		foreach($res_ as $entry) {
			$last = $entry;
			
			$res = $conn->prepare("select * from `sub-catalogues` WHERE `cata-id` = :panda");
			$res->bindParam("panda",$entry["cata-id"]);
			$res->execute();
			
			foreach($res->fetchAll(PDO::FETCH_ASSOC) as $subentry) {
				$last[] = $subentry;
			}
		}
		if($json) return json_encode($last);
		return $last;
	}
	function getCategoriesWithSubCategories($json = NULL) {
		global $conn;
		$res = $conn->query("select * from `categories`");
		$res_ = $res->fetchAll(PDO::FETCH_ASSOC);
		
		$last = array();
		foreach($res_ as $entry) {
			$last = $entry;
			
			$res = $conn->prepare("select * from `sub-categories` WHERE `cat-id` = :panda");
			$res->bindParam("panda",$entry["cat-id"]);
			$res->execute();
			
			foreach($res->fetchAll(PDO::FETCH_ASSOC) as $subentry) {
				$last[] = $subentry;
			}
		}
		if($json) return json_encode($last);
		return $last;
	}
	
	function getArticlesByCategory($catid) {
		global $conn;
		$res = $conn->prepare("select * from `articles` where `catid` = :panda");
		$res->bindParam("panda",$catid);
		$res->execute();
		return $res->fetchAll(PDO::FETCH_ASSOC);
	}
	function getArticlesByCategorySubCategory($catid,$subcatid) {
		global $conn;
		$res = $conn->prepare("select * from `articles` where `catid` = :panda and `subcatid` = :panda1");
		$res->bindParam("panda",$catid);
		$res->bindParam("panda1",$subcatid);
		$res->execute();
		return $res->fetchAll(PDO::FETCH_ASSOC);
	}
	
	function getArticleByID($id) {
		global $conn;
		$res =  $conn->prepare("select * from `articles` where `id` = :panda");
		$res->bindParam("panda",$id);
		$res->execute();
		return $res->fetch(PDO::FETCH_ASSOC);
	}
	
	function CreateCatalogue($obj) {
		global $conn;
		if(!$obj) die("Empty object");
		$res =  $conn->prepare("insert into `catalogues` (`name`,`towhere`) values (:panda,:panda1)");
		$res->bindParam("panda",$obj->name);
		$res->bindParam("panda1",$obj->towhere);
		$res->execute();
		return $res->rowCount();
	}
	function CreateSubCatalogue($obj) {
		global $conn;
		if(!$obj) die("Empty object");
		$res =  $conn->prepare("insert into `sub-catalogues` (`name`,`cata-id`,`towhere`) values (:panda,:panda2,:panda1)");
		$res->bindParam("panda",$obj->name);
		$res->bindParam("panda1",$obj->towhere);
		$res->bindParam("panda2",$obj->catid);
		$res->execute();
		return $res->rowCount();
	}
	
	function CreateCategory($obj) {
		global $conn;
		if(!$obj) die("Empty object");
		$res =  $conn->prepare("insert into `categories` (`name`) values (:panda)");
		$res->bindParam("panda",$obj->name);
		$res->execute();
		return $res->rowCount();
	}
	function CreateSubCategory($obj) {
		global $conn;
		if(!$obj) die("Empty object");
		$res =  $conn->prepare("insert into `sub-categories` (`name`,`cat-id`) values (:panda,:panda1)");
		$res->bindParam("panda",$obj->name);
		$res->bindParam("panda1",$obj->catid);
		$res->execute();
		return $res->rowCount();
	}
	function AddArticle($obj) {
		global $conn;
		if(!$obj) die("Empty object");
		$res =  $conn->prepare("insert into `articles` (`catid`,`subcatid`,`name`,`specs`,`imgs`,`rating`) values (:panda,:panda1,:panda2,:panda3,:panda4,:panda5)");
		$res->bindParam("panda",$obj->catid);
		$res->bindParam("panda1",$obj->subcatid);
		$res->bindParam("panda2",$obj->name);
		$res->bindParam("panda3",$obj->specs);
		$res->bindParam("panda4",$obj->imgs);
		$res->bindParam("panda5",$obj->rating);
		$res->execute();
		return $res->rowCount();
	}
	function DeleteArticleByID($id) {
		global $conn;
		$res = $conn->prepare("update `articles` set `deleted` = 1 where `id` = :panda");
		$res->bindParam("panda",$id);
		$res->execute();
		return $res->rowCount();
	}
	function DeleteCatalogueAndItsSubCataloguesByID($id) {
		global $conn;
		$rows = 0;
		$res = $conn->prepare("delete from `catalogues` where `cata-id` = :panda");
		$res->bindParam("panda",$id);
		$res->execute();
		$rows += $res->rowCount();
		$res = $conn->prepare("delete from `sub-catalogues` where `cata-id` = :panda");
		$res->bindParam("panda",$id);
		$res->execute();
		$rows += $res->rowCount();
		return $rows;
	}
	function DeleteCategoryAndItsSubCategoriesByID($id) {
		global $conn;
		$rows = 0;
		$res = $conn->prepare("delete from `categories` where `cat-id` = :panda");
		$res->bindParam("panda",$id);
		$res->execute();
		$rows += $res->rowCount();
		$res = $conn->prepare("delete from `sub-categories` where `cat-id` = :panda");
		$res->bindParam("panda",$id);
		$res->execute();
		$rows += $res->rowCount();
		return $rows;
	}
	function DeleteSubCategoryByID($id) {
		global $conn;
		$res = $conn->prepare("delete from `sub-categories` where `id` = :panda");
		$res->bindParam("panda",$id);
		$res->execute();
		return $res->rowCount();
	}
	function DeleteSubCatalogueByID($id) {
		global $conn;
		$res = $conn->prepare("delete from `sub-catalogues` where `id` = :panda");
		$res->bindParam("panda",$id);
		$res->execute();
		return $res->rowCount();
	}
	
	$obj= new article("1","3","Chair","saens","png","5");
	$damn = DeleteCategoryAndItsSubCategoriesByID(2);
	print_r($damn);
	
?>
