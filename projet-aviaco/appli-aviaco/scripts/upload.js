function myLoard(guid)
	{
		var Text=""
		Text+="<div id='img-wrapper'>"
    		Text+="<div class='wrapper'>"
				Text+="<div class='close'><a href=''>X</a></div>"
				Text+="<div id='drop_zone'><p>Deposez votre fichier ici ...</p></div>"
			Text+="</div>"
    	Text+="</div>"
        
		eval("MyIg").innerHTML=Text
		//------------- Déclaration des variables --------------//
		var dropArea = document.getElementById('drop_zone');
		var destinationUrl = "scripts/upload.php";
		//alert(destinationUrl)
		var list = [];
		var totalSize = 0;
		//
		// gestionnaires
    	function initHandlers() 
			{
        		dropArea.addEventListener('drop', handleDrop, false);
        		dropArea.addEventListener('dragover', handleDragOver, false);
    			}
		// survol lors du déplacement
    	function handleDragOver(event)
			{
        		event.stopPropagation();
        		event.preventDefault();
				dropArea.className = 'hover';
    			}
		// glisser déposer
    	function handleDrop(event)
			{
        		event.stopPropagation();
        		event.preventDefault();
				var Text=""
				Text="<div id='img-wrapper'>"
    				Text+="<div class='wrapper'>"
						Text+="<div class='close'><a href=''>X</a></div>"
						Text+="<div id='imag'></div>"
						Text+="<span id=''></div>"
						Text+="<div id='result'></div>"
					Text+="</div>"
    			Text+="</div>"
				eval("MyIg").innerHTML=Text
				files=event.dataTransfer.files
                                
				//----------- Affichage de l'image ------------
				//---------------------------------------------
    			for (var i = 0, f; f = files[i]; i++) {
                                
      			// Seules les fichiers images.
      				if (!f.type.match('image.*')) {
                                    eval("imag").innerHTML = ['<img id="thumb" class="thumb" src="upload/PDFicon.png"/>'].join('');
        						continue;
      						}
                                
      				var reader = new FileReader();
      			// bloc qui recupère les infos images.
      			reader.onload = (function(theFile) {
        		return function(e) {
          		// Lecture thumbnail.
          		//var span = document.createElement('span');
                        
          		eval("imag").innerHTML = ['<img class="thumb" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
							document.getElementById("joint").value=theFile.name
          		//document.getElementById('imag').insertBefore(span, null);
       						 };
     					 })(f);

      			// Read in the image file as a data URL.
      			reader.readAsDataURL(f);
   			 }
				processFiles(files);
    	}
		// traitement du lot de fichiers
    	function processFiles(filelist)
			{
				var result = document.getElementById('result');
        		if (!filelist || !filelist.length || list.length) return;
					totalSize = 0;
        			//totalProgress = 0;
        			result.textContent = '';

        		for (var i = 0; i < filelist.length && i < 5; i++)
					{
            			list.push(filelist[i]);
            			totalSize += filelist[i].size;
        				}
        			uploadNext();
    			}
		// à la fin, traiter le fichier suivant
		if(guid==1)
			{
				function handleComplete(size)
					{
        				//
        				uploadNext();
    					}
				}
		// transfert du fichier
    	function uploadFile(file, status)
			{
	        // création de l'objet XMLHttpRequest
    	    var xhr = new XMLHttpRequest();
        	xhr.open('POST', destinationUrl);
        	xhr.onload = function()
				{
            		result.innerHTML += this.responseText;
            		handleComplete(file.size);
        			};
        	xhr.onerror = function()
				{
            		result.textContent = this.responseText;
            		handleComplete(file.size);
        			};
        	xhr.upload.onprogress = function(event)
				{
            		handleProgress(event);
        			}
        	xhr.upload.onloadstart = function(event)
				{
        			}

        	// création de l'objet FormData
        	var formData = new FormData();
        	formData.append('myfile', file);
        	xhr.send(formData);
    	}

    	// transfert du fichier suivant
    	function uploadNext()
			{
        		if (list.length)
					{
            			dropArea.className = 'uploading';
			            var nextFile = list.shift();
            			if (nextFile.size >= 262144) 
							{ // 256 kb
                				result.innerHTML += '<div class="f">Fichier trop gros (dépassement de la taille maximale)</div>';
                				handleComplete(nextFile.size);
            					}
						else 
							{
                				uploadFile(nextFile, status);
            					}
        				}
				else 
					{
            			dropArea.className = '';
        				}
    			}

    	initHandlers();
	}
function myfile(src){
    if(document.getElementById('MyIg')){
        document.getElementById('MyIg').innerHTML='';
    }
    if(document.getElementById('logo-soc')){
        document.getElementById('logo-soc').innerHTML='<img src='+src+'>';
    }
    if(document.getElementById('img-src')){
        document.getElementById('img-src').value=src;
        
        //--- On envoi une requette mettant àjour l'infos --
        var num_soc=$('#num-soc').val();
        if(num_soc){
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:'save-logo=' + num_soc + '#' + $('#img-src').val(),
                success:refreshhist
            });
        }
    }
}
function refreshhist(rslt){
    window.location.reload();
}