<?php
	$page = "mangaSearch";
	if(isset($_POST["UploadXML"]))
	{
		$maxSize = 5000000; //5 mb
		$file = $_FILES["MyAnimelistXML"];
		if(isset($file))
		{
			$fileType = pathinfo(basename($file["name"]),PATHINFO_EXTENSION);
			$fileSize = $file["size"];
			if($fileType === "xml" && $fileSize <= $maxSize)
			{
				if(move_uploaded_file($file["tmp_name"], TMP_XML_FILE_PATH))
				{
					SQL_loadMyanimelistXMLToDataspace();
				}
			}
		}
	}
	
	navigate($page);
?>