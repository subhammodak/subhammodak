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

// Create ZIP file
if(isset($_POST['create_picture'])){
    
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
}

if(isset($_POST['create_signature'])){
    
    $zip = new ZipArchive();
    $filename = "./Student_Signature.zip";

    if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
        exit("cannot open <$filename>\n");
    }

    // Folder Path 
    $dir = 'signature/';

    // Create zip
    createZip($zip,$dir);

    $zip->close();
    
    $filename = "Student_Signature.zip";
    
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="'.basename($filename).'"');
    header('Content-Length: ' . filesize($filename));

    flush();
    readfile($filename);

    /*
    OR
    // Auto Download Zip with delete
        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="'.$zipPath.'"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        ob_clean();
        flush();
        if (readfile($zipPath))
        {
          unlink($zipPath);
        }
    */


    // delete file
    unlink($filename);
}


// Create TAR file
if(isset($_POST['create_picture'])){
    
    $filename = "temp_reg_doc_zip/Registration_Students_Documents".date("YmdHis").".tar";

    $zip = new PharData($filename);

    // Folder Path 
    $dir = 'registration_documents/';

    // Create zip
    createZip($zip,$dir);

    //$zip->close();
    
    /*header('Content-Type: application/tar');
    header('Content-Disposition: attachment; filename="'.basename($filename).'"');
    header('Content-Length: ' . filesize($filename));

    flush();
    readfile($filename);
    // delete file
    unlink($filename);*/

    // tar file can not auto download.

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>KWC University Registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
      html,body { 
	height: 100%; background-color:#17a2b8 !important;
}

.global-container{
	height:100%;
	display: flex;
	align-items: center;
	justify-content: center;
	background-color: #f5f5f5;
}

form{
	padding-top: 10px;
	font-size: 14px;
	margin-top: 30px;
}

.card-title{ font-weight:300; }

.btn{
	font-size: 14px;
	margin-top:20px;
}


.login-form{ 
	width:550px;
	margin:20px;
}

.sign-up{
	text-align:center;
	padding:20px 0 0;
}

.alert{
	margin-bottom:-30px;
	font-size: 13px;
	margin-top:20px;
}
  </style>
</head>
<body bg-info>

    <div class="bg-info">
    <h2 class="text-center">Registration of 1st Sem to the University of Kalyani (<?=date("Y")?>-<?=date("y")+1?>)</h2>
<div class="global-container bg-info">
    
	<div class="card login-form">
	<div class="card-body">
		<h3 class="card-title text-center">KWC University Registration</h3>
		<div class="card-text text-center">
			<form method='POST' action=''>
                <input type='submit' name='create_picture' value='Download Students Picture' class="btn btn-info" />&nbsp;
                <input type='submit' name='create_signature' value='Download Students Signature' class="btn btn-info" />
            </form>
		</div>
	</div>
</div>
</div>
</div>
</body>
</html>