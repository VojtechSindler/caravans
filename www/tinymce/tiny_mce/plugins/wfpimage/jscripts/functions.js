tinyMCEPopup.requireLangPack();

function iBrowser() {
		// browser check
		this.isMSIE  = (navigator.appName == 'Microsoft Internet Explorer');
		this.isGecko = navigator.userAgent.indexOf('Gecko') != -1;		
};

var iBrowser = new iBrowser();
var size_of_pict = '';
var type_of_pict = '';

function init() {
	tinyMCEPopup.resizeToInnerSize();
	/*
	var inst = tinyMCE.getInstanceById(tinyMCE.getWindowArg('editor_id'));
	var elm = inst.getFocusElement();
	var action = "insert";
	var html;
	
	elm = tinyMCE.getParentElement(elm, "img");
	if (elm != null && elm.nodeName == "IMG")
		action = "update";

	if (action == "update") {
		//document.getElementById('imgpath').value=tinyMCE.getAttrib(elm, 'src');
		var cesta = tinyMCE.getAttrib(elm, 'src').split("/");
		
		if (cesta[cesta.length-1].substring(0,2)=='m_') { //nahled
			
			var cesticka = cesta[cesta.length-3]+'/'+cesta[cesta.length-2]+'/'+cesta[cesta.length-1].substring(2);
			document.getElementById('imgpath').value = cesticka;	
			document.getElementById('doaslink').checked = 'checked';
		}
		else {
			var cesticka = cesta[cesta.length-3]+'/'+cesta[cesta.length-2]+'/'+cesta[cesta.length-1];
			document.getElementById('imgpath').value = cesticka;
		}
		var styles = tinyMCE.parseStyle(tinyMCE.getAttrib(elm, "style"));
		var marginarray = styles['margin'].split(" ");
	
		if (!marginarray[3]) {
			//margin is same for all
			if (!marginarray[2]) {
				//margin is same for top and bottom	
				var martop = marginarray[0],marbot = marginarray[0],marlef = marginarray[1],marrig = marginarray[1];
			}
			else var martop = marginarray[0],marbot = marginarray[0],marlef = marginarray[0],marrig = marginarray[0];
		}
		else var martop = marginarray[0],marbot = marginarray[2],marlef = marginarray[3],marrig = marginarray[1];
		document.getElementById('imgmarginleft').value = marlef.replace('pt', '').replace('px', '');
		document.getElementById('imgmarginright').value = marrig.replace('pt', '').replace('px', '');
		document.getElementById('imgmargintop').value = martop.replace('pt', '').replace('px', '');
		document.getElementById('imgmarginbottom').value = marbot.replace('pt', '').replace('px', '');

		
		document.getElementById('imgwidth').value = tinyMCE.getAttrib(elm, 'width');
		document.getElementById('imgheight').value = tinyMCE.getAttrib(elm, 'height');
		document.getElementById('alttext').value = tinyMCE.getAttrib(elm, 'alt');
		document.getElementById('imgtitle').value = tinyMCE.getAttrib(elm, 'title');
		document.getElementById(tinyMCE.getAttrib(elm, 'align')).selected = true;
	
		document.getElementById('imgborder').value = styles['border-top'].substring(styles['border-top'].indexOf(' '),styles['border-top'].indexOf('px'));
		document.getElementById('tajnyobrazek').src='../../../../../../'+cesticka;
		zmenanahledu();
		
		
		// Use mce_href if found
		var mceRealHref = tinyMCE.getAttrib(elm, 'mce_href');
		if (mceRealHref != "") {
			href = mceRealHref;

			if (tinyMCE.getParam('convert_urls'))
				href = convertURL(href, elm, true);
		}

		var onclick = tinyMCE.cleanupEventStr(tinyMCE.getAttrib(elm, 'onclick'));
	}
	*/
}

function updateinvisible(imgpath) {
	var ImgObj=document.getElementById('tajnyobrazek');
	tinymce.dom.Event.add(ImgObj, 'load', setheight);
	tinymce.dom.Event.add(ImgObj, 'error', clearheight);
	
	ImgObj.src='../../../../../../'+imgpath;
	
	document.getElementById('idloadinginfo').style.display = '';

}

function setNewPath(path)
{
	document.getElementById('imgpath').value=path;
	updateinvisible(path);
}	

function clearheight() {
	document.getElementById('imgwidth').value = document.getElementById('imgheight').value = "";	
	document.getElementById('idloadinginfo').disabled = true;
	document.getElementById('idloadinginfo').style.display = 'none';
}

function setheight() {
	var ImgObj = document.getElementById('tajnyobrazek');
	document.getElementById('imgwidth').value = ImgObj.width;
	document.getElementById('imgheight').value = ImgObj.height;
	document.getElementById('idloadinginfo').style.display = 'none';
}


function vlozImg() {
	var inst = tinyMCEPopup.editor;	
	if (document.getElementById('imgpath').value!="") {
		if (document.getElementById('imgalign').value=="") var imgalign = '';
		else var imgalign = ' align="'+document.getElementById('imgalign').value+'" ';
		
		if (document.getElementById('alttext').value=="") var alttext = '';
		else var alttext = ' alt="'+document.getElementById('alttext').value+'" ';
						
		if (document.getElementById('imgmargintop').value=="") var imgmargintop = 0;
		else var imgmargintop = document.getElementById('imgmargintop').value;
		if (document.getElementById('imgmarginright').value=="") var imgmarginright = 0;
		else var imgmarginright = document.getElementById('imgmarginright').value;
		if (document.getElementById('imgmarginbottom').value=="") var imgmarginbottom = 0;
		else var imgmarginbottom = document.getElementById('imgmarginbottom').value;
		if (document.getElementById('imgmarginleft').value=="") var imgmarginleft = 0;
		else var imgmarginleft = document.getElementById('imgmarginleft').value;
		
		var pole = document.getElementById('imgpath').value.split("/");
		var linkpath = pole[0]+'/'+pole[1]+'/'+pole[2]+'/m_'+pole[3];

		if (!document.getElementById('doaslink').checked) {
			if (document.getElementById('imgborder').value=="") var imgborder = '';
			else var imgborder = ' border: '+document.getElementById('imgborder').value+'px solid #000000;" ';
			var html = '<img src="'+document.getElementById('imgpath').value+'"'+alttext+' title="'+document.getElementById('imgtitle').value+'" width="'+document.getElementById('imgwidth').value+'" height="'+document.getElementById('imgheight').value+'"'+imgalign+'style="margin: '+imgmargintop+' '+imgmarginright+' '+imgmarginbottom+' '+imgmarginleft+';'+imgborder+';" />';
		}
		else {
			if (document.getElementById('imgborder').value=="") var imgborder = 'border: 0px';
			else var imgborder = ' border: '+document.getElementById('imgborder').value+'px solid #000000;" ';
			var html = '<a href="'+document.getElementById('imgpath').value+'" class="thickbox" title="'+document.getElementById('imgtitle').value+'"><img src="'+linkpath+'"'+alttext+' alt="'+document.getElementById('imgtitle').value+'"'+imgalign+'style="margin: '+imgmargintop+' '+imgmarginright+' '+imgmarginbottom+' '+imgmarginleft+';'+imgborder+';" /></a>';
		}
		tinyMCE.execCommand('mceInsertContent', false, html);	
		tinyMCEPopup.close();
	}
	else tinyMCE.activeEditor.windowManager.alert(inst.getLang('wfpimage.alert_text'));
}

function zmenanahledu() {
	var formular = document.getElementById('formik');
	var img = document.getElementById('imgukazkovy');
	
	if (document.getElementById('imgmargintop').value=="") var imgmargintop = 0;
	else var imgmargintop = document.getElementById('imgmargintop').value;
	if (document.getElementById('imgmarginright').value=="") var imgmarginright = 0;
	else var imgmarginright = document.getElementById('imgmarginright').value;
	if (document.getElementById('imgmarginbottom').value=="") var imgmarginbottom = 0;
	else var imgmarginbottom = document.getElementById('imgmarginbottom').value;
	if (document.getElementById('imgmarginleft').value=="") var imgmarginleft = 0;
	else var imgmarginleft = document.getElementById('imgmarginleft').value;
	
	if (img) {
		img.align = formular.imgalign.value;
		img.border = formular.imgborder.value;
		img.style.margin = imgmargintop+' '+imgmarginright+' '+imgmarginbottom+' '+imgmarginleft;
	//	img.vspace = formular.imgvspace.value;
	}
}

function changewidth() {
	var ImgObj=document.getElementById('tajnyobrazek');
	if (!document.getElementById('proportions').checked) {
		return;
	}

	if (document.getElementById('imgwidth').value == "" || document.getElementById('imgheight').value == "")
		return;
	var newwidth = (document.getElementById('imgheight').value / ImgObj.height) * ImgObj.width;
	document.getElementById('imgwidth').value = newwidth.toFixed(0);
}

function changeheight() {
	var ImgObj=document.getElementById('tajnyobrazek');
	if (!document.getElementById('proportions').checked) {
		return;
	}

	if (document.getElementById('imgwidth').value == "" || document.getElementById('imgheight').value == "")
		return;
	var newheight = (document.getElementById('imgwidth').value / ImgObj.width) * ImgObj.height;
	document.getElementById('imgheight').value = newheight.toFixed(0);
}

function imgexplore() {		

tinyMCE.activeEditor.windowManager.open({
				url : tinymce.baseURL + '/plugins/wfpimage/scripts/imgexplorer.php',
				width : 615 ,
				height : 370 ,
				close_previous : false,
				inline : true
			}, {
				func : setNewPath,
				theme_url : this.url
			});
	}

function setImage(editor, sender, rArgs) {	
		if (!rArgs) { // Gecko		
			var rArgs = sender.returnValue;				
		}
		if (rArgs.chr != null) {
			var chr = rArgs.chr;
			var elm = rArgs.elm;		
			document.getElementById(elm).value = chr;
			updateinvisible(chr);
		}			
  }		 
  
 function predejparametr() {
	 var args = window.dialogArguments;
	 window.dialogArguments = args;
 }
 
 function clearalt() {
	 if (document.getElementById('alttext').value == '- - -') document.getElementById('alttext').value = '';
 }
 
 function insertimg(chr) {   	
		var f = tinyMCEPopup.getWindowArg('func');

		tinyMCEPopup.restoreSelection();

		if (f) f(chr);

		tinyMCEPopup.close();
    }	
	
function potvrd(co) {
if (co=="" || co==null) co="Delete this picture";
return window.confirm(co + " ?");
}
 
addEventeForExp = function(o, n, h) {
	if (o.attachEvent)
		o.attachEvent("on" + n, h);
	else
		o.addEventListener(n, h, false);
};

function file_size(velikost) {
        //Setup some common file size measurements.
        var size_kb = 1024;
        var size_mb = 1048576;
        var size_gb = 1073741824;
        var size_tb = 1099511627776;
         
        //Format file size
        
        if(velikost < size_kb) {
        return velikost+" B";
        }
        else if(velikost < size_mb) {
        return Math.round(velikost/size_kb)+" kB";
        }
        else if(velikost < size_gb) {
        return Math.round(velikost/size_mb)+" MB";
        }
        else if(velikost < size_tb) {
        return Math.round(velikost/size_gb)+" GB";
        }
        else {
        return Math.round(velikost/size_tb)+" TB";
        }
}

function hideInfoDIV(){
	document.getElementById('infoDiv').style.display='none';
   } 
   
function Mausklick (Ereignis) {
   if (!Ereignis)
    Ereignis = window.event;

 if (document.getElementById) {
//	  alert(Ereignis.clientX + "px");
	
    document.getElementById("infoDiv").style.left  = Ereignis.clientX-40 + "px";
    document.getElementById("infoDiv").style.top = Ereignis.clientY-110 + "px";
  } else if (document.all) {
	
    document.all.infoDiv.style.left = Ereignis.clientX;
    document.all.infoDiv.style.top = Ereignis.clientY;
  }	
  document.onmousemove = null;
}   

function showInfoDIV(x, velikost){
	if (iBrowser.isGecko) {	
		document.captureEvents(Event.MOUSEMOVE);
	}
	document.onmousemove = Mausklick; 
	var ImgObject=document.getElementById('tajnyobrazek2');
	size_of_pict = file_size(velikost);

	if (x.substring(x.length-4) == '.jpg' || x.substring(x.length-4) == 'jpeg') type_of_pict = 'JPG - JPEG file'; 
	else if  (x.substring(x.length-4) == '.gif') type_of_pict = 'GIF file'; 
	else type_of_pict = 'PNG file'; 

	addEventeForExp(ImgObject, "load", showInfoWait);
	addEventeForExp(ImgObject, "error", showInfoErr);
	
	ImgObject.src='../../../../../../../'+x;

	document.getElementById('infoTexts').style.display = 'none';
	document.getElementById('infoWaitText').style.display = '';
	document.getElementById('infoDiv').style.display='';	
	
   }
   
function showInfoWait() {
	var ImgObject=document.getElementById('tajnyobrazek2');
	
	document.getElementById('infoTexts').style.display = '';

	document.getElementById('divWidthText').innerHTML = ImgObject.width+'px';
	document.getElementById('divHeightText').innerHTML = ImgObject.height+'px';
	document.getElementById('divSizeText').innerHTML = size_of_pict;
	document.getElementById('divTypeText').innerHTML = type_of_pict;

	document.getElementById('infoWaitText').style.display = 'none';
}

function showInfoErr() {
	alert('chyba');
	document.getElementById('infoDiv').style.visibility="hidden";	
}

tinyMCEPopup.onInit.add(init);