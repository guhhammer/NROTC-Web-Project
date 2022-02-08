<?php

include("../Database/config.php");
$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());

//REF: Validate Logged in user


//Walk the tree
$tree = [];

function getFolderFiles($folderid) {
    global $conn;
    
    //File Statements
    $filestmt = $conn->prepare('SELECT `id`,`name`,`date`,LENGTH(`data`) AS `size`,CONCAT(`abbrevRank`, " ", `lastName`) AS `uploadedby` FROM documents_files INNER JOIN users ON users.userID = `uploadedby` INNER JOIN ranktbl ON `users`.`user_rank` = ranktbl.`rankID` WHERE folder=?');
    $filestmt->bind_param("i", $folderid);

    $filestmt->execute();
    $result = $filestmt->get_result();

    $results = [];
    while($row = $result->fetch_assoc()) {
        $row['url'] = '../../PHP/Documents/download.php?id=' . $row['id'];
        $results[] = $row;
    }
    return $results;
}

function walkDocumentTreeRoot($private, &$node, $root = NULL, $fullpath = []) {
    global $conn;
    
    //Directory Statements
    $documentstmt = $conn->prepare('SELECT * FROM documents_folders WHERE parent IS NULL');
    if($root !== NULL) {
        $documentstmt = $conn->prepare('SELECT * FROM documents_folders WHERE parent=?');
        $documentstmt->bind_param("i", $root); 
    }
    $documentstmt->execute();
    $result = $documentstmt->get_result();
    while($row = $result->fetch_assoc()) {
        if($row['private'] == 1 && $private != 1)
            continue;

        $tempPath = $fullpath;
        array_push($tempPath, $row['name']);

        $dir = [
            'id' => $row['id'],
            'name' => $row['name'],
            'fullPath' => implode('/', $tempPath),
            'directories' => [],
            'files' => getFolderFiles($row['id']),
        ];

        //Construct Child Dirs
        walkDocumentTreeRoot($private, $dir, $row['id'], $tempPath);

        //Add Completed Directory
        $node['directories'][] = $dir;
    }
}

walkDocumentTreeRoot(0, $tree);

echo json_encode($tree);
