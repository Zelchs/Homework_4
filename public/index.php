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
if (isset($_GET['exercise'])) {
    $aName = "%" . $_GET['exercise'] . "%"; 
    $stmt = $conn->prepare("SELECT * FROM todo WHERE exercise LIKE (?)");
    $stmt->bind_param("s", $aName);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM todo";
    $result = $conn->query($sql);
}

if ($result->num_rows > 0) {
    echo "<h2>Your exercises</h2>";
    while ($row = $result->fetch_assoc()) {
        $html = "id: " . $row["id"]; 
        $html .= "Exercise - " . $row["exercise"]; 
        $html .= "Notes: " . $row["note"];
        $html .= "To be done:" . $row["tododate"];
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