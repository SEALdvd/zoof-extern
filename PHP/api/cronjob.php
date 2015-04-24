 <?php

require_once 'include/db_functions.php';
    $db = new db_functions();
    $db->dataWipe();

    foreach(glob("../pictures/*") as $file)
    {
       unlink($file);
    }
 ?>