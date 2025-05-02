<?php
function renderAnnouncements($dbc){
    $SQS = "SELECT * FROM announcement";
    //echo "<br>SQS:".$SQS."</br>";
    $result = mysqli_query($dbc,$SQS);
    echo "
    <div class='Announcments'>
    <table border='1' cellpadding='5' cellspacing='0'>
    <tr><th colspan='2'>Announcments!</th></tr>
    <tr>
        <th>Date Posted</th>
        <th>Message</th>
    </tr>";
    while($row = mysqli_fetch_assoc($result)){
        echo "<tr>
                <td>" . htmlspecialchars($row["posted"]) . "</td>
                <td>" . nl2br(htmlspecialchars($row["message"])) . "</td>
              </tr>";
    }
    echo "</table>
    </div>";
}
?>