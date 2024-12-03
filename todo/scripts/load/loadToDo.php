<?php

    $sql = "SELECT * FROM todolist";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0){
        while($row = mysqli_fetch_array($result)){
            $id = $row['id'];
            $chore = $row['chore'];
            $fullName = $row['user'];
            $day = $row['day'];

            $day = date("d/m/Y", strtotime($day));
            $onclick = 'window.location="./scripts/add/addToDone.php?id=' . $id . '"';
            echo '
                <tr>
                    <td><center><input type="checkbox" name="" id="" onclick='. $onclick .'></center></td>
                    <td><center>' . $id .'</center></td>
                    <td>' . $chore .'</td>
                    <td>' . $fullName .'</td>
                    <td><center>' . $day .'</center></td>
                </tr>
            ';
        }
    }
    
?>