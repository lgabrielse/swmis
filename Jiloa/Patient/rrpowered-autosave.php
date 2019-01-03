<?php
try {
/*Connect to the database*/
$dc = new PDO("mysql:host=localhost;dbname=swmisbethany", 'root', 'jiloa7');
 
/*Get the posted values from the form*/
$medrecnum==&$_POST['medrecnum'];
$visitid==&$_POST['visitid'];
$notes==&$_POST['notes'];
$temp==&$_POST['temp'];
$pulse==&$_POST['pulse'];
$bp_sys==&$_POST['bp_sys'];
$bp_dia==&$_POST['bp_dia'];
$entryby==&$_POST['entryby'];
$entrydt==&$_POST['entrydt'];

/*Get note id*/
$note_id=1;  
 
$stmt = $dc->query("SELECT * FROM patnotes WHERE id ='$note_id'");
$return_count = $stmt->rowCount();
if($return_count > 0){    
 
    if(isset($notes)){
    /*Update autosave*/
        $update_qry = $dc->prepare("UPDATE patnotes SET medrecnum='$medrecnum', visitid='$visitid', notes='$notes', temp='$temp', pulse='$pulse', bp_sys='$bp_sys', bp_dia='$bp_dia', entryby='$entryby', entrydt='$entrydt' WHERE id='$note_id'");
        $update_qry -> execute();
    } else {
    /*Get saved data from database*/
        $get_patnotes = $dc->prepare("SELECT * FROM patnotes WHERE id='$note_id'");
        $get_patnotes->execute();
        while ($gt_v = $get_patnotes->fetch(PDO::FETCH_ASSOC)) {
 			$medrecnum=$gt_v['medrecnum'];
			$visitid=$gt_v['visitid'];
			$notes=$gt_v['notes'];
			$temp=$gt_v['temp'];
			$pulse=$gt_v['pulse'];
			$bp_sys=$gt_v['bp_sys'];
			$bp_dia=$gt_v['bp_dia'];
			$entryby=$gt_v['entryby'];
			$entrydt=$gt_v['entrydt'];
            echo json_encode(array('medrecnum' => $medrecnum, 'visitid' => $visitid, 'notes' => $notes, 'temp' => $temp, 'pulse' => $pulse, 'bp_sys' => $bp_sys, 'bp_dia' => $bp_dia, 'entryby' => $entryby, 'entrydt' => $entrydt));
        }          
    }
} else {
/*Insert the variables into the database*/
    $insert_qry = $dc->prepare("INSERT INTO patnotes (medrecnum, visitid, notes, temp, pulse, bp_sys, bp_dia, entryby, entrydt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_qry->execute(array($medrecnum, $visitid, $notes, $temp, $pulse, $bp_sys, $bp_dia, $entryby, $entrydt));  
}
} catch(PDOException $e) {
    echo $e->getMessage();
    }
?>