<?php
include_once('db.php');
// Script to create Update
// Use isset $_POST['']
if(isset($_GET['updateSelect'])) {
    // use addslashes() to accept strings with slashes
    // use strip_tags() to avoid html/script tags
    $up_ids = strip_tags(trim(addslashes($_GET['get_id'])));
    $up_value = strip_tags(trim(addslashes($_GET['get_value'])));
    // Check the fields to make sure they are not empty
    // If one field has no string, it won't be saved into database
    if ($up_value == '') {
       $res = [
            'status' => 422,
            'message' => 'All fields are required!'
        ];
        echo json_encode($res);
        return;
    }
    else {
        // Prepare to insert into table
        $mySQL = "UPDATE `tbl_user` SET `team`='$up_value' WHERE `id`='$up_ids'";
        $sql_query = mysqli_query($mysqli, $mySQL);
        // Query if mySQL is true or false
        if ($sql_query == TRUE) {
           $res = [
                'status' => 200,
                'message' => 'Data Updated Successfully!'
            ];
            echo json_encode($res);
            return;
        }
        else {
            $res = [
                'status' => 500,
                'message' => 'Data not updated!'
            ];
            echo json_encode($res);
            return;
        }
    }
}

// Select Data From Another Table to be the Select-Option values
$sqlSelect = "SELECT * FROM `tbl_select`";
// Loop data from $sqlSelect and display messages
$query = $mysqli->query($sqlSelect);
if($query->num_rows> 0){
    // We don't echo here
    // We declare a variable as below
    $get_select = mysqli_fetch_all($query, MYSQLI_ASSOC);
}

// Display Data in the HTML Table
$sqlData = "SELECT * FROM `tbl_user`";
$queryData = mysqli_query($mysqli, $sqlData);
// Loop through $result and display messages
while ($row = mysqli_fetch_assoc($queryData)) {
    echo "<tr>
                <td>{$row['team']}</td>
                <td align='center'>
                    <select id='{$row['id']}' class='updateData'>
                        <option style='color: red;' selected value='{$row['team']}'>{$row['team']}</option>";
                    // We use foreach to loop Data from the $get_select above
                    foreach ($get_select as $options) { ?>
                        <option value='<?php echo $options['title']; ?>'><?php echo $options['title']; ?></option><?php } echo "
                    </select>
                </td>
            <tr>";
}
// The class and id of the Select-Option above are very important here
?>
