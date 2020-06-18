<?php
include "config/config.php";
include "src/header.php";
echo "<hr>";
?>
<main>

<?php
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_SESSION['user'])) {

echo "<p>You are logged in!</p>";
include "newexercise.php";
echo "<hr>";
include "filterForm.php";
// if (isset($_GET['exercise'])) {
//     $aName = "%" . $_GET['exercise'] . "%"; 
//     $stmt = $conn->prepare("SELECT * FROM todo WHERE exercise LIKE (?)");
//     $stmt->bind_param("s", $aName);
//     $stmt->execute();
//     $result = $stmt->get_result();
// } else {
//     $sql = "SELECT * FROM todo";
//     $result = $conn->query($sql);
// }
if (isset($_GET['exercise'])) {
    $aName = "%" . $_GET['exercise'] . "%"; // we add %s to get fuzzy matches
    $stmt = $conn->prepare("SELECT *
        FROM todo
        WHERE exercise
        LIKE (?)
        AND userid = (?)");
    $stmt->bind_param("sd", $aName, $_SESSION['id']); //s means string here
    $stmt->execute();
    $result = $stmt->get_result();
} 
else {
    $stmt = $conn->prepare("SELECT *
        FROM todo
        WHERE userid = (?)");
    $stmt->bind_param("d", $_SESSION['id']); //s means string here
    $stmt->execute();
    $result = $stmt->get_result();
}

if ($result->num_rows > 0) {
    echo "<h2>Your exercises</h2>";
    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $checked = "";
        $exercise = $row['exercise'];
        $note = $row['note'];
        if ($row['done']) {
            $checked = "checked";
        }
        if (isset($row['tododate'])) {
            $tododate = $row['tododate'];
        }
        else {
            $tododate = "2020-08-27";
        }
        $datetime1 = date_create($tododate);
        // $html = "id: " . $row["id"]; 
        $html = "<form action='src/updatedata.php' method='post'>";
        $html .= "<input class='done' type='checkbox' name='done' $checked>";
        // $html .= "Exercise - " . $row["exercise"]; 
        // $html .= " Notes: " . $row["note"];
        $html .= "<input class='exercise' name='exercise' placeholder='exercise' value='$exercise'>";
        $html .= "<input class='note' name='note' placeholder='note' value='$note' size='60'>";
        // $html .= " To be done:" . $row["tododate"];
        $html .= "<input type='date' class='tododate' name='tododate' value='$tododate'>";
        $html .= "<button type='submit' class='update' name='updatedata' value='$id'>UPDATE data</button>";
        $html .= "</form>";
        $html .= "<form action='src/deletedata.php' method='post'>";
        $html .= "<button type='submit' name='deletedata' value='$id'>";
        $html .= "Delete exercise</button>";
        $html .= "</form>";
        $html .= "<hr>";
        echo $html;
    }
} 
else {
    echo "0 results";
}
// $allrows = $result->fetch_all(MYSQLI_ASSOC);
//     foreach ($allrows as $rowindex => $row) {
//         echo "<div class='myrow' id='row-$rowindex'>";
//         $html = "id: " . $row["id"]; //set $html text here
//         $html .= "Exercise - " . $row["exercise"]; //we add this line to previous $html
//         $html .= "Note: " . $row["note"];
//         $html .= "To be done:" . $row["tododate"];
//         // $html .= "<hr>";
//         echo $html;
//         echo "</div>";
//     }
}
else {
echo "<p>You are logged out!</p>";
}
?>
</main>


<?php
include "src/footer.php";
?>