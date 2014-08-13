function iBrowser() {
		// browser check
		this.isMSIE  = (navigator.appName == 'Microsoft Internet Explorer');
		this.isGecko = navigator.userAgent.indexOf('Gecko') != -1;		
};

var iBrowser = new iBrowser();

function init() {
	tinyMCEPopup.resizeToInnerSize();
	
	var inst = tinyMCE.getInstanceById(tinyMCE.getWindowArg('editor_id'));
	var elm = inst.getFocusElement();
	var action = "insert";
	var html;
}

function updateinvisible(filepath) {
	var pole = filepath.split("/");
	document.getElementById('filename').value = pole[2];
	document.getElementById('filepath').value = pole[0]+'/'+pole[1]+'/'+pole[2];
}


function gettype(koncovka) {
	var vystup;
	switch (koncovka.toLowerCase()) {
		case 'doc': vystup = '<acronym title="dokument MS Word">DOC</acronym>';
					 break;
		case 'xls': vystup = '<acronym title="dokument MS Excel">XLS</acronym>';
					 break;
		case 'ppt': vystup = '<acronym title="dokument MS PowerPoint">PPT</acronym>';
					 break;
		case 'txt': vystup = '<acronym title="textov dokument">TXT</acronym>';
					 break;
		case 'pdf': vystup = '<acronym title="dokument PDF">PDF</acronym>';
					 break;
		case 'rar': vystup = '<acronym title="komprimovan data">RAR</acronym>';
					break;
		case 'zip': vystup = '<acronym title="komprimovan data">ZIP</acronym>';
					 break;
		case 'exe': vystup = '<acronym title="spustiteln soubor">EXE</acronym>';
					 break;
		case 'jpg': vystup = '<acronym title="obrzek typu JPEG">JPG</acronym>';
					 break;
		case 'gif': vystup = '<acronym title="obrzek typu GIF">GIF</acronym>';
					 break;
		case 'wav': vystup = '<acronym title="zvukov soubor">WAV</acronym>';
					break;
		case 'mp3': vystup = '<acronym title="zvukov soubor">MP3</acronym>';
					 break;
		default: vystup = '<acronym title="dokument '+koncovka.toUpperCase()+'">'+koncovka.toUpperCase()+'</acronym>';
	} 
	return vystup;
	
}

function insertFile() {
	var inst = tinyMCEPopup.editor;	
	
	if (document.getElementById('filepath').value!="") {
				var pridavek;
				var html = '<a href="'+document.getElementById('filepath').value+'" title="'+document.getElementById('filetitle').value+'">'+document.getElementById('filename').value+'</a>';
		if (document.getElementById('insertsize').checked) {
				pridavek = document.getElementById('fsize').value;
		}
		if (document.getElementById('inserttype').checked) {
			if (pridavek==undefined) pridavek = gettype(document.getElementById('filepath').value.substring(document.getElementById('filepath').value.lastIndexOf('.')+1,document.getElementById('filepath').value.length));		
			else pridavek += ', '+gettype(document.getElementById('filepath').value.substring(document.getElementById('filepath').value.lastIndexOf('.')+1,document.getElementById('filepath').value.length));		
		}
		if (pridavek!=undefined) html += ' [ '+pridavek+' ]';
		tinyMCE.execCommand('mceInsertContent', false, html);	
		tinyMCEPopup.close();
	}
	else tinyMCE.activeEditor.windowManager.alert(inst.getLang('wfpfile.alert_text'));
}

function setNewPath(path, size)
{
	document.getElementById('filepath').value=path;
	document.getElementById('fsize').value=size;
	updateinvisible(path);
}	

function file_explore(elm, umisteni, vyska, sirka) {				

tinyMCE.activeEditor.windowManager.open({
				url : tinymce.baseURL + '/plugins/wfpfile/scripts/fexplorer.php',
				width : 600 ,
				height : 355 ,
				close_previous : false,
				inline : true
			}, {
				func : setNewPath,
				theme_url : this.url
			});
	}

function setSymbol(editor, sender, rArgs) {		
		if (!rArgs) { // Gecko		
			var rArgs = sender.returnValue;				
		}
		if (rArgs.chr != null) {
			var chr = rArgs.chr;
			var elm = rArgs.elm;	
			var chr1 = rArgs.chr1;
			var elm1 = rArgs.elm1;	
			document.getElementById(elm).value = chr;
			document.getElementById(elm1).value = chr1;
			updateinvisible(chr);
		}			
  }		 
  
 function predejparametr() {
	 var args = window.dialogArguments;
	 window.dialogArguments = args;
 }
 
function insertfile(chr, size) {   
	var f = tinyMCEPopup.getWindowArg('func');

	tinyMCEPopup.restoreSelection();

	if (f) f(chr, size);
	tinyMCEPopup.close();	
		
}	
	
function potvrd(co) {
if (co=="" || co==null) co="Delete this file";
return window.confirm(co + " ?");

 }