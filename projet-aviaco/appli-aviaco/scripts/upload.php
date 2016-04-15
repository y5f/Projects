<?php
//----- Classe de chargement  ---------
require_once '../vendor/autoload.php';
require_once '../generator/generated-conf/config.php';

// fixe le niveau de rapport d'erreur
if (version_compare(phpversion(), '5.3.0', '>=') == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE);

function bytesToSize1024($bytes, $precision = 2) {
    $unit = array('B','KB','MB');
    return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision).' '.$unit[$i];
}

if (isset($_FILES['myfile'])) {
    $sFileName = $_FILES['myfile']['name'];
	$tmpFileName=$_FILES['myfile']['tmp_name'];
    $sFileType = $_FILES['myfile']['type'];
    $sFileSize = bytesToSize1024($_FILES['myfile']['size'], 1);
       $nameFile=new TBINDEX();
       $nameFile->save();
       
       //-- On recupere l'extension du fichier charger --//
       $ext=  explode('.', $_FILES['myfile']['name']);
       //$namedest='IMG'.$nameFile->getIndx().'.'.$ext[1];
       
       if($ext[1]==='pdf'){
            $namedest='pdfFile/PDF'.$nameFile->getIndx().'.'.$ext[1];
            $to="../upload/".$namedest;
       }else{
            $namedest='avatard/IMG'.$nameFile->getIndx().'.'.$ext[1];
            $to="../upload/".$namedest;
       }
	
	//--------------------------------------------------------------
	//My_usr_updt($sFileName);
	//---------- On copie l'image dans le repertoir upload----------
	move_uploaded_file($tmpFileName, $to);
	//--------------------------------------------------------------
    echo <<<EOF
	<form action='' method='post'>
<div class="s">
    <p>Type : {$sFileType}</p>
    <p>Taille : {$sFileSize}<input type=button value=Envoyer id=upload/$namedest onclick=myfile(this.id)></p>
</div>
</form>
EOF;
} else {
    echo '<div class="f">Une erreur s\'est produite</div>';
}
//m_disconnect();
?>