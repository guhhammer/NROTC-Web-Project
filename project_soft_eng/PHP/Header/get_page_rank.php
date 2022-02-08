<?php 

	$userID = $_POST["id"];

	include_once("../Database/config.php");
	include_once("../Database/selector.php");

	$rank_ = []; $lastname = []; $rank_value = [];
		
	$selector = new Selector();	
	$selector->getValues( [&$rank_, &$lastname], ["user_rank", "lastName"], "users", [["userID", $userID]], $status );
	$selector->getValues( [&$rank_value], ["abbrevRank"], "ranktbl", [["rankID", $rank_[0]]], $status );

	unset($selector);

	echo json_encode( $rank_value[0]."   ".$lastname[0] );

?>
