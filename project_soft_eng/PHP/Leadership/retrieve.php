<?php

require_once("../function_calls.php");

//REF: Validate Logged in user

$termid = get_term(date('Y-m-d'));

function get_OI_Priv($userID, $current_term){
    global $conn;

    $OI;
    
    $find_OI_stmt = 'SELECT user, oi.username as OI_Name, oi.userID as OI, stud.userID as student
        FROM billet_term_roster, users as oi, users as stud
        WHERE term = '.$current_term.'
            AND stud.assigned_OI = rosterID
            AND user = oi.userID
            AND stud.userID = '.$userID;

    $result = $conn->query($find_OI_stmt);

    if($result->num_rows >0){

        while($row = $result->fetch_assoc()){
            $OI = $row['OI'];
            return $OI;
        }
    }
    
    else{
        //Throw error here.
        return "-";
    }
}

$stmt = $conn->prepare('SELECT `userId` as `id`,CONCAT(`abbrevRank`, " ", `lastName`) AS `name`, `assigned_OI`, `program_status`.`status`, "" AS `aid`, "" AS `OI`, "" AS `commandBillet`, "" AS `collateralBillet` FROM `users` INNER JOIN ranktbl ON `users`.`user_rank` = ranktbl.`rankID` INNER JOIN program_status ON `users`.`status` = program_status.`statusID` ORDER BY `lastName` DESC');

$stmt->execute();
$result = $stmt->get_result();

$results = [];
while($row = $result->fetch_assoc()) {
    $row['aid'] = get_aid($row['id'], $termid);
    $row['OI'] = get_OI_Priv($row['id'], $termid);
    $row['commandBillet'] = get_user_cmd_billet($row['id'], $termid);
    $row['collateralBillet'] = get_user_collateral_billet($row['id'], $termid);

    $results[] = $row;
}
echo json_encode($results);
