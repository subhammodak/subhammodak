<?php
// Create zip
function createZip($zip,$dir){
    if (is_dir($dir)){

        if ($dh = opendir($dir)){
            while (($file = readdir($dh)) !== false){
                
                // If file
                if (is_file($dir.$file)) {
                    if($file != '' && $file != '.' && $file != '..'){
                        
                        $zip->addFile($dir.$file);
                    }
                }else{
                    // If directory
                    if(is_dir($dir.$file) ){

                        if($file != '' && $file != '.' && $file != '..'){

                            // Add empty directory
                            $zip->addEmptyDir($dir.$file);
                            $folder = $dir.$file.'/';
                            
                            // Read data of the folder
                            createZip($zip,$folder);
                        }
                    }
                }
            }
            closedir($dh);
        }
    }
}

$zip = new ZipArchive();
    $filename = "./Student_Picture.zip";

    if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
        exit("cannot open <$filename>\n");
    }

    // Folder Path 
    $dir = 'picture/';

    // Create zip
    createZip($zip,$dir);

    $zip->close();
    
    $filename = "Student_Picture.zip";
    
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="'.basename($filename).'"');
    header('Content-Length: ' . filesize($filename));

    flush();
    readfile($filename);
    // delete file
    unlink($filename);
   ?>
