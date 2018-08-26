function getFileParam() { 			
	try { 				
		var file = document.getElementById('uploaded-file1').files[0]; 				
		
		if (file) { 					
			var fileSize = 0; 					
			
			if (file.size > 1024 * 1024) {
				fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
			}else {
				fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
			}
				
			document.getElementById('file-name1').innerHTML = 'Имя: ' + file.name;
			document.getElementById('file-size1').innerHTML = 'Размер: ' + fileSize;
			
			if (/\.(jpe?g|bmp|gif|png)$/i.test(file.name)) {		
				var elPreview = document.getElementById('preview1');
				elPreview.innerHTML = '';
				var newImg = document.createElement('img');
				newImg.className = "preview-img";
				
				if (typeof file.getAsDataURL=='function') {
					if (file.getAsDataURL().substr(0,11)=='data:image/') {
						newImg.onload=function() {
							document.getElementById('file-name1').innerHTML+=' ('+newImg.naturalWidth+'x'+newImg.naturalHeight+' px)';
						}
						newImg.setAttribute('src',file.getAsDataURL());
						elPreview.appendChild(newImg);								
					}
				}else {
					var reader = new FileReader();
					reader.onloadend = function(evt) {
						if (evt.target.readyState == FileReader.DONE) {
							newImg.onload=function() {
								document.getElementById('file-name1').innerHTML+=' ('+newImg.naturalWidth+'x'+newImg.naturalHeight+' px)';
							}
						
							newImg.setAttribute('src', evt.target.result);
							elPreview.appendChild(newImg);
						}
					};
					
					var blob;		
					if (file.slice) {
						blob = file.slice(0, file.size);
					}else if (file.webkitSlice) {
							blob = file.webkitSlice(0, file.size);
						}else if (file.mozSlice) {
							blob = file.mozSlice(0, file.size);
						}
					reader.readAsDataURL(blob);
				}
			}
		}
	}catch(e) {
		var file = document.getElementById('uploaded-file1').value;
		file = file.replace(/\\/g, "/").split('/').pop();
		document.getElementById('file-name1').innerHTML = 'Имя: ' + file;
	}
}