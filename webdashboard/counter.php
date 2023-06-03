<?php
function inc() {
    
    
// Add correct path to your countlog.txt file.
$path = 'idcount.txt';

// Opens countlog.txt to read the number of hits.
$file  = fopen( $path, 'r' );
$count = fgets( $file, 1000 );
fclose( $file );

if ($count <= "20") {
    // Update the count.
    $count = abs( intval( $count ) ) + 1;
  }
if ($count > 20){
    $count = 0;
}

// Output the updated count.
echo "{$count} hits\n";

// Opens countlog.txt to change new hit number.
$file = fopen( $path, 'w' );
fwrite( $file, $count );
fclose( $file );

}
?>
