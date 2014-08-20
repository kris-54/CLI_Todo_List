<?php

 // Create array to hold list of todo items
 $items = array();

 // List array items formatted for CLI
 function list_items($list)
 {
    $new_list = ' ';
    foreach ($list as $key => $item) {
        $new_list .= ($key + 1) . " {$item}\n";
    }
        return $new_list;

 }

 // Get STDIN, strip whitespace and newlines, 
 // and convert to uppercase if $upper is true
 function get_input($upper = FALSE) 
 {
     if ($upper) {
        return  strtoupper(trim(fgets(STDIN)));       
    } else {
        return trim(fgets(STDIN));
    }
}

function sort_menu($items) 
{
    echo '(A)-Z,(Z)-A,(O)rder Entered, (R)everse Order Entered : ';
    $input = get_input(true);
    switch ($input) {
        case 'A':
            asort($items);
            break;
        case 'Z':
            arsort($items);
            break;
        case 'O':
            ksort($items);
            break;
        case 'R':
            krsort($items);
            break;
    } return ($items);
}



 // The loop!
 do {
     // Echo the list produced by the function
     echo list_items($items);

     // Show the menu options
     echo '(N)ew item, (R)emove item, (S)ort, (Q)uit : ';

     // Get the input from user
     // Use trim() to remove whitespace and newlines
     $input = get_input(TRUE);

     // Check for actionable input
     if ($input == 'N') {
         // Ask for entry
         echo 'Enter item: ';
         // Add entry to list array
         $items[] = get_input();
     } elseif ($input == 'R') {
         // Remove which item?
         echo 'Enter item number to remove: ';
         // Get array key
         $key = get_input();
         $key = $key - 1;
         // Remove from array
         unset($items[$key]);
         $items = array_values($items);
     } elseif ($input == 'S') {
         //call sort function        
         $items = sort_menu($items);
     }
 // Exit when input is (Q)uit
 } while ($input != 'Q');

 // Say Goodbye!
 echo "Goodbye!\n";

 // Exit with 0 errors
 exit(0);