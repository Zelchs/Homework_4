<?php
include "config/config.php";
include "src/header.php";
echo "<hr>";
?>
<main>

<?php

if (isset($_SESSION['user'])) {

echo "<p>You are logged in!</p>";
include "newexercise.php";
echo "<hr>";
include "filterForm.php";
}
else {
echo "<p>You are logged out!</p>";
}
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

?>
<?php

//FIXME !! NOT SAFE need prepared statements!! reme
if (isset($_GET['exercise'])) {
    $aName = "%" . $_GET['exercise'] . "%"; // we add %s to get fuzzy matches
    $stmt = $conn->prepare("SELECT * FROM todo WHERE exercise LIKE (?)");
    $stmt->bind_param("s", $aName); //s means string here
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM todo";
    $result = $conn->query($sql);
}

if ($result->num_rows > 0) {
    echo "Cool we got " . $result->num_rows . " rows of data!<hr>";
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        // var_dump($row);
        // echo "id: " . $row["id"] . " name - " . $row["name"] . " artist: " . $row["artist"] . " Created on:" . $row["created"]
        $html = "id: " . $row["id"]; //set $html text here
        $html .= "Exercise - " . $row["exercise"]; //we add this line to previous $html
        $html .= "Notes: " . $row["note"];
        $html .= "To be done:" . $row["tododate"];
        $html .= "<hr>";
        echo $html;
        //   echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["lastname"]. "<br>";
    }
} else {
    echo "0 results";
}

// $sql = "SELECT * FROM todo WHERE exercise LIKE 'ABBA'";
// $result = $conn->query($sql);

// we can get all results at once and then loop through them
// $allrows = $result->fetch_all(MYSQLI_BOTH);
$allrows = $result->fetch_all(MYSQLI_ASSOC);
var_dump($allrows);
foreach ($allrows as $rowindex => $row) {
    echo "<div class='myrow' id='row-$rowindex'>";
    // var_dump($row);
    $html = "id: " . $row["id"]; //set $html text here
    $html .= "Exercise - " . $row["exercise"]; //we add this line to previous $html
    $html .= "Note: " . $row["note"];
    $html .= "To be done:" . $row["tododate"];
    // $html .= "<hr>";
    echo $html;
    echo "</div>";
}
?>
</main>


<?php
include "src/footer.php";
?>