<?php
function renderAnnouncements($dbc){
    $SQS = "SELECT * FROM announcement";
    //echo "<br>SQS:".$SQS."</br>";
    $result = mysqli_query($dbc,$SQS);
    echo "
    <div class='Announcments'>
    <table>
    <tr>
    <th>Announcments</th>
    </tr>";
    while($row = mysqli_fetch_assoc($result)){
        echo "<tr><th>Date Posted:</th><tr>";
        echo "<tr><th>".$row["posted"]."</th><tr>";
        echo "<tr><th>".$row["message"]."</th></tr>";
    }
    echo "</table>
    </div>";
}
?>