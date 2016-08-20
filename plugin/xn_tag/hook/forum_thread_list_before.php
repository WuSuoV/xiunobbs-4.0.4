<?php exit;

$tagids = param(3);
$tagid1 = $tagid2 = $tagid3 = $tagid4 = '';
$threadlist_from_tag = 0;
if($tagids) {
	$thread_list_from_default = 0;
	// 从 tagids 中查找合法的 tagid，不允许任意构造，尽量保证数据关联正确。
	function tag_cate_find_tagid_from_tagids($index, $tagids) {
		global $forum;
		if(empty($forum['tagcatelist'][$index])) return 0;
		$tagcate = $forum['tagcatelist'][$index];
		$enable_tagids = array_keys($tagcate['tagmap']);
		$arr = array_values(array_intersect($enable_tagids, $tagids));
		return empty($arr) ? 0 : $arr[0];
	}
	
	// 结果集缓存下来
	$tagids = param(3);
	$tagidarr = explode('_', $tagids);
	$tagidarr = array_filter_empty($tagidarr);
	$tagidarr = array_values($tagidarr);
	
	$tagid1 = tag_cate_find_tagid_from_tagids(0, $tagidarr);
	$tagid2 = tag_cate_find_tagid_from_tagids(1, $tagidarr);
	$tagid3 = tag_cate_find_tagid_from_tagids(2, $tagidarr);
	$tagid4 = tag_cate_find_tagid_from_tagids(3, $tagidarr);
	
	$tagidarr = array($tagid1, $tagid2, $tagid3, $tagid4);
	$tagidarr = array_values(array_filter_empty($tagidarr));
	$n = count($tagidarr);
	
	$tidlist = array();
	$count_sql = '';
	$find_sql = '';
	$tablepre = $db->tablepre;
	if($n == 1) {
		// 查找 tagid 属于哪个 cateid
		$count_sql = "SELECT COUNT(tid) AS num FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[0]'";
		$find_sql = "SELECT tid FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[0]'";
	} elseif($n == 2) {
		$count_sql = "SELECT COUNT(tid) num FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[0]' AND tid IN(
			SELECT tid FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[1]')";
		$find_sql = "SELECT tid FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[0]' AND tid IN(
			SELECT tid FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[1]')";
	} elseif($n == 3) {
		$count_sql = "SELECT COUNT(tid) num FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[0]' AND tid IN(
			SELECT tid FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[1]' AND tid IN(
				SELECT tid FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[2]'))";
		$find_sql = "SELECT tid FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[0]' AND tid IN(
			SELECT tid FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[1]' AND tid IN(
				SELECT tid FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[2]'))";
	} elseif($n == 4) {
		$count_sql = "SELECT COUNT(tid) num FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[0]' AND tid IN(
			SELECT tid FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[1]' AND tid IN(
				SELECT tid FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[2]' AND tid IN(
					SELECT tid FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[3]')))";
		$find_sql = "SELECT tid FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[0]' AND tid IN(
			SELECT tid FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[1]' AND tid IN(
				SELECT tid FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[2]' AND tid IN(
					SELECT tid FROM {$tablepre}tag_thread WHERE tagid='$tagidarr[3]')))";
	} else {
		$thread_list_from_default = 1;
	}
}

if($thread_list_from_default == 0) {
	
	// 缓存结果集，不然查询太耗费资源。
	$count_sql_md5 = md5($count_sql);
	$find_sql_md5 = md5($find_sql);

	$n = cache_get($count_sql_md5);
	if($n === NULL || DEBUG) {
		$arr = db_sql_find_one($count_sql);
		$n = $arr['num'];
		cache_set($count_sql_md5, $n, 30);
	}
	
	$tids = cache_get($find_sql_md5);
	if($n === NULL || DEBUG) {
		$tidlist = db_sql_find($find_sql);
		$tids = arrlist_values($tidlist, 'tid');
		cache_set($find_sql_md5, $tids, 30);
	}
	
	$pagination = pagination(url("forum-$fid-{page}-{$tagid1}_{$tagid2}_{$tagid3}_{$tagid4}"), $n, $page, $pagesize);
	$threadlist = thread_find_by_tids($tids);

}
?>