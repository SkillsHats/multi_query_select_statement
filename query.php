<?php

      $con = new mysqli("localhost", "root", "", "testing");

      // Check connection
      if ($con->connect_errno()) {
         echo "Connection Error: " . $con->connect_error();
      }
      
      $uid = 2;

      $query = "SELECT TEST_ID FROM TBL_INVITE WHERE INVITED_BY = $uid";
      $result = $con->query($query);
      $num = $result->num_rows;
      $array = array();

      while ($row = $result->fetch_assoc()) {
          $array[] = $row;
      }

      $sql = '';
      for($i=0; $i < count($array); $i++) {
        $test = $array[$i]['TEST_ID'];
        $sql .= "SELECT * FROM TESTS WHERE TEST_ID = $test;";
      }

      // Execute multi query
      if ($con->multi_query($sql)) {
        do {
          // Store first result set
          if ($result = $con->store_result()) {
            // Fetch one and one row
            while ($row = $result->fetch_row()) {
              printf("%s\n",$row[0]);
            }
            // Free result set
            $result->free_result();
            }
          } while ($con->next_result());
      }

      $con->close();
?>
