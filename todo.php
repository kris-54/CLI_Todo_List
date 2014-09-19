<?php

 // Create array to hold list of todo items
$items = array();

// List array items formatted for CLI
function list_items($list)
{
    $new_list = '';
    // var_dump($list);
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
    } 
    return $items;
}

function read_file($filename)
{
    $handle = fopen($filename,'r');
    //pass in the file to open
    $content = trim(fread($handle, filesize($filename)));
    //content is the the file and file size
    $content = explode("\n", $content);
    //content is a string so explode to return an array//
    // $items = $content if this is done without merge lists will not combine
    fclose($handle);
    //close the file once rendered
    return $content;
}

function save_file($filename,$items)
{
    $handle = fopen($filename, 'w');
        foreach($items as $item) {
            fwrite($handle,$item . PHP_EOL);
        }    
    fclose($handle);
    
}


 // The loop!
do {
 // Echo the list produced by the function
 echo list_items($items);

 // Show the menu options
 echo '(N)ew item, (R)emove item, (S)ort, s(A)ve file (O)pen File (Q)uit : ';

 // Get the input from user
 // Use trim() to remove whitespace and newlines
 $input = get_input(TRUE);

 // Check for actionable input
 if ($input == 'N') {
     // Ask for entry
     echo 'Enter item: ';
     $new_item = get_input();
     echo 'Would you like to add to the (B)eginning or (E)nd of list' . PHP_EOL;
    
     $input = get_input(TRUE);
        if ($input == 'B') {
            array_unshift($items, $new_item);
        } else {
            array_push($items, $new_item);
            }
 } elseif ($input == 'R') {
     // Remove which item?
     echo 'Enter item number to remove: ';
     // Get array key
     $key = get_input();
     // Remove from array
     $key = $key - 1;
     unset($items[$key]);
     $items = array_values($items);
 } elseif ($input == 'S') {
     //call sort function        
     $items = sort_menu($items);
 } elseif ($input == 'F') {
    //remove first item on list
    array_shift($items);
 } elseif ($input == 'L') {
    //removes last item on list
    array_pop($items);
 } elseif ($input == 'O') {
    echo "enter file path: ";
    //ask user for file path
    $filename = get_input();
    //the user's input = the file name for the function//
    $content = read_file($filename);
    //call the function to reaad the users input and that equals the content//
    $items = array_merge($items,$content);
    //use array merge to combine the file(content) with newly added items//
    //use $items = to render the list//        
 } elseif ($input == 'A')
  {
    echo "enter file path to save: ";
    $filename = get_input();
    if (file_exists($filename)) {
        echo "File ALREADY EXISTS, do you want to proceed? 'Y' or 'N'" . PHP_EOL;
        $choice = get_input(true); 
        if ($choice === 'Y') {
            save_file($filename, $items);
        } else {
            echo 'save aborted' . PHP_EOL;
        }   
    } else {
        save_file($filename,$items);
    }
 }   

// Exit when input is (Q)uit
} while ($input != 'Q');

 // Say Goodbye!
 echo "Goodbye!\n";

 // Exit with 0 errors
 exit(0);
 ?>