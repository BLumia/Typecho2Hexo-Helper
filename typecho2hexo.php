<?php
// Run Enviroment and DB setting
/* ********************
All Supported Enviroments($ENV_CASE, aka. Data Source): 
	"STD_MYSQL"  	You should setting the following stuff to connect to sql
	"OPEN_SHIFT" 	Supposed by Red Hat
	"SAE"			Supposed by Sina App Engine
You should modify the PDO statement in setting_db.inc.php if you are not using mysql.
******************** */
	$ENV_CASE = "SAE";//Environment flag, Normally should be "STD_MYSQL"
	// If you are using STD_MYSQL, fill the following informations
	$SQL_DB_NAME = "judge";	//Your DB Name
	$SQL_DB_HOST = "localhost";//Your DB Host
	$SQL_DB_PORT = "3307";//Your DB Host
	$SQL_DB_USER = "root";//Your DB Login Username
	$SQL_DB_PASS = "usbw";//Your DB Management Password
	
// ---------- Item Get Border Line ----------
	
	require("./setting_db.inc.php");
	
	if (isset($_GET["cid"])) {
		$cidNum = intval($_GET["cid"]);
		$sql=$pdo->prepare("SELECT title, text, created, category, tags
						FROM typecho_contents c, (
						
						SELECT cid, group_concat( m.name ) tags
						FROM typecho_metas m, typecho_relationships r
						WHERE m.mid = r.mid
						-- AND m.type = 'tag'
						GROUP BY cid
						)t1, (
						
						SELECT cid, m.name category
						FROM typecho_metas m, typecho_relationships r
						WHERE m.mid = r.mid
						AND m.type = 'category'
						)t2
						WHERE t1.cid = t2.cid
						AND c.cid = t1.cid
						AND t1.cid = {$cidNum}");
		$sql->execute();
		$row = $sql->fetch(PDO::FETCH_ASSOC);
		header("Content-Type: application/force-download; charset=utf-8");
		header("Content-Disposition: attachment; filename=".str_replace(array(" ","?","\\","/" ,":" ,"|", "*" ),'-',$row["title"]).".md");
		$_time=date('Y-m-d H:i:s',$row["created"]);
		$_content=str_replace('<!--markdown-->','',$row["text"]);
		$_finally = 
<<<STR
title: {$row["title"]}
categories: {$row["category"]}
tags: [{$row["tags"]}]
date: {$_time}
---
{$_content}
STR;
		echo $_finally;
	} else {
		header("Content-Type: text/html; charset=utf8");
		$sql=$pdo->prepare("SELECT t1.cid, title, created, category, tags
						FROM typecho_contents c, (
						
						SELECT cid, group_concat( m.name ) tags
						FROM typecho_metas m, typecho_relationships r
						WHERE m.mid = r.mid
						-- AND m.type = 'tag'
						GROUP BY cid
						)t1, (
						
						SELECT cid, m.name category
						FROM typecho_metas m, typecho_relationships r
						WHERE m.mid = r.mid
						AND m.type = 'category'
						)t2
						WHERE t1.cid = t2.cid
						AND c.cid = t1.cid");
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		foreach($res as $row) {
			$_time=date('Y-m-d H:i:s',$row["created"]);
			$_finally = 
<<<STR
				title: <a href="http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?cid={$row["cid"]}">{$row["title"]}</a><br/>
				categories: {$row["category"]}<br/>
				tags: [{$row["tags"]}]<br/>
				date: {$_time}<br/>
				<hr/>
STR;
			echo $_finally;
		}
	}
?>
