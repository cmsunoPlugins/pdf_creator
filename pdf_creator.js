//
// CMSUno
// Plugin Box
//
function f_save_pdfc(){
	var a=document.getElementById("frmPdfc").getElementsByTagName("textarea"),b,h=[];
	h.push({name:'action',value:'save'});
	h.push({name:'unox',value:Unox});
	for(v=0;v<a.length;v++){if(a[v].name.substr(0,1)=='E')b=CKEDITOR.instances[a[v].name].getData();else b=a[v].value;h.push({name:a[v].name,value:b});};
	jQuery.post('uno/plugins/pdf_creator/pdf_creator.php',h,function(r){
		f_alert(r);
		f_load_pdfc(0);
	});
}
//
function f_config_pdfc(){
	var h=[];
	h.push({name:'action',value:'config'});
	h.push({name:'unox',value:Unox});
	h.push({name:'page',value:document.getElementById('pdfcPage').options[document.getElementById('pdfcPage').selectedIndex].value});
	h.push({name:'format',value:document.getElementById('pdfcFormat').options[document.getElementById('pdfcFormat').selectedIndex].value});
	h.push({name:'font',value:document.getElementById('pdfcFont').options[document.getElementById('pdfcFont').selectedIndex].value});
	h.push({name:'size',value:document.getElementById('pdfcSize').options[document.getElementById('pdfcSize').selectedIndex].value});
	h.push({name:'left',value:document.getElementById("pdfcMargleft").value});
	h.push({name:'right',value:document.getElementById("pdfcMargright").value});
	h.push({name:'top',value:document.getElementById("pdfcMargtop").value});
	h.push({name:'bottom',value:document.getElementById("pdfcMargbottom").value});
	h.push({name:'head',value:document.getElementById("pdfcMarghead").value});
	h.push({name:'foot',value:document.getElementById("pdfcMargfoot").value});
	jQuery.post('uno/plugins/pdf_creator/pdf_creator.php',h,function(r){
		f_alert(r);
	});
}
//
function f_send_pdfc(){
	jQuery.post('uno/plugins/pdf_creator/pdf_creator.php',{
			'action':'send',
			'unox':Unox,
			'mail':document.getElementById("pdfcEmail").value,
			'comp':document.getElementById("pdfcComp").value,
			'subj':document.getElementById("pdfcSubjmail").value,
			'cont':document.getElementById("pdfcContmail").value
		},function(r){
		f_alert(r);
		f_pdfcA();
	});
}
//
function f_check_pdfc(){
	var a=document.getElementById("pdfcComp").value;
	if(a.length>0){
		jQuery.post('uno/plugins/pdf_creator/pdf_creator.php',{'action':'check','unox':Unox,'comp':a},function(r){
			document.getElementById("pdfcCheck").innerHTML=r;
		});
	}
	else document.getElementById("pdfcCheck").innerHTML="";
}
//
function f_delete_pdfc(f){
	jQuery.post('uno/plugins/pdf_creator/pdf_creator.php',{'action':'delete','unox':Unox,'nom':f},function(r){
		f_alert(r);
		f_load_pdfc(0);
	});
}
//
function f_makepdf_pdfc(f,g){
	jQuery("#wait").show();
	jQuery.post('uno/plugins/pdf_creator/pdf_creator.php',{'action':'makepdf','unox':Unox,'nom':f,'comp':g},function(r){
		f_alert(r);
	});
}
//
function f_add_pdfc(f){ // T
	a=document.getElementById('curPdfc');
	b=document.createElement('tr');
	b.className="pdfTrTxt";
	c=document.createElement('td');
	f=f.replace(/[^\w]/gi, '');
	c.innerHTML=f;
	c.style.width='110px';
	c.style.verticalAlign='middle';
	c.style.paddingLeft='40px';
	b.appendChild(c);
	c=document.createElement('td');
	d=document.createElement('textarea');
	d.name='T'+f;
	d.style.width='100%';
	c.appendChild(d);
	b.appendChild(c);
	c=document.createElement('td');
	c.style.backgroundImage='url('+Udep+'includes/img/close.png)';
	c.style.backgroundPosition='center center';
	c.style.backgroundRepeat='no-repeat';
	c.style.cursor='pointer';
	c.width='30px';
	c.onclick=function(){this.parentNode.parentNode.removeChild(this.parentNode);}
	b.appendChild(c);
	a.appendChild(b);
	document.getElementById('pdfcName').value='';
}
//
function f_create_pdfc(f){ // E
	//
	a=document.getElementById('curPdfc');
	b=document.createElement('tr');
	b.className="pdfTrEd";
	c=document.createElement('td');f=f.replace(/[^\w]/gi, '');c.innerHTML=f+' head';c.style.width='110px';c.style.verticalAlign='middle';c.style.paddingLeft='40px';b.appendChild(c);
	c=document.createElement('td');d=document.createElement('textarea');d.name='E'+f+'head';d.style.width='100%';c.appendChild(d);b.appendChild(c);
	c=document.createElement('td');c.style.backgroundImage='url('+Udep+'includes/img/close.png)';c.style.backgroundPosition='center center';c.style.backgroundRepeat='no-repeat';c.style.cursor='pointer';c.width='30px';c.onclick=function(){this.parentNode.parentNode.removeChild(this.parentNode);}
	b.appendChild(c);a.appendChild(b);
	CKEDITOR.replace('E'+f+'head',{height:'300'});
	b=document.createElement('tr');
	b.className="pdfTrEd";
	c=document.createElement('td');f=f.replace(/[^\w]/gi, '');c.innerHTML=f;c.style.width='110px';c.style.verticalAlign='middle';c.style.paddingLeft='40px';b.appendChild(c);
	c=document.createElement('td');d=document.createElement('textarea');d.name='E'+f;d.style.width='100%';c.appendChild(d);b.appendChild(c);
	c=document.createElement('td');c.style.backgroundImage='url('+Udep+'includes/img/close.png)';c.style.backgroundPosition='center center';c.style.backgroundRepeat='no-repeat';c.style.cursor='pointer';c.width='30px';c.onclick=function(){this.parentNode.parentNode.removeChild(this.parentNode);}
	b.appendChild(c);a.appendChild(b);
	CKEDITOR.replace('E'+f,{height:'300'});
	b=document.createElement('tr');
	b.className="pdfTrEd";
	c=document.createElement('td');f=f.replace(/[^\w]/gi, '');c.innerHTML=f+' foot';c.style.width='110px';c.style.verticalAlign='middle';c.style.paddingLeft='40px';b.appendChild(c);
	c=document.createElement('td');d=document.createElement('textarea');d.name='E'+f+'foot';d.style.width='100%';c.appendChild(d);b.appendChild(c);
	c=document.createElement('td');c.style.backgroundImage='url('+Udep+'includes/img/close.png)';c.style.backgroundPosition='center center';c.style.backgroundRepeat='no-repeat';c.style.cursor='pointer';c.width='30px';c.onclick=function(){this.parentNode.parentNode.removeChild(this.parentNode);}
	b.appendChild(c);a.appendChild(b);
	CKEDITOR.replace('E'+f+'foot',{height:'300'});
	document.getElementById('pdfcName').value='';
	jQuery('#pdfcAdd').show();
	jQuery('#pdfcCreate').hide();
}
//
function f_load_pdfc(f){
	jQuery(document).ready(function(){
		jQuery('#curPdfc').empty();
		jQuery.ajax({type:"POST",url:'uno/plugins/pdf_creator/pdf_creator.php',data:{'action':'load','unox':Unox,'nom':f},dataType:'json',async:true,success:function(data){
			jQuery('#curPdfc').append('<input type="hidden" id="pdfcActif" value="'+data.nom+'" />');
			if(data.nom=='_new_'||typeof data.pdfc==='undefined'||data.pdfc.length==0){
				jQuery('#pdfcAdd').hide();
				jQuery('#pdfcCreate').show();
			}
			else{
				jQuery('#pdfcAdd').show();
				jQuery('#pdfcCreate').hide();
			}
			if(data.nom!='_new_'&&typeof data.pdfc!=='undefined'){
				jQuery.each(data.pdfc,function(k,d){
					if(d.t=='T')jQuery('#curPdfc').append('<tr class="pdfTrTxt"><td style="width:100px;vertical-align:middle;padding-left:40px;">'+d.n+'<br />[['+d.n.replace(/[^a-z0-9]/gi,'')+']]</td><td style="'+(d.t=='E'?'padding-bottom:10px;padding-top:10px':'padding-right:8px;')+'"><textarea style="width:100%;" name="'+d.t+d.n+'">'+d.b+'</textarea></td><td width="30px" style="cursor:pointer;background:transparent url(\''+Udep+'includes/img/close.png\') no-repeat scroll center center;" onClick="this.parentNode.parentNode.removeChild(this.parentNode);"></td></tr>');
				});
				jQuery.each(data.pdfc,function(k,d){
					if(d.t=='E'){
						jQuery('#curPdfc').append('<tr class="pdfTrEd"><td style="width:100px;vertical-align:middle;padding-left:40px;">'+d.n+'</td><td style="'+(d.t=='E'?'padding-bottom:10px;padding-top:10px':'padding-right:8px;')+'"><textarea style="width:100%;" name="'+d.t+d.n+'">'+d.b+'</textarea></td><td width="30px" style="cursor:pointer;background:transparent url(\''+Udep+'includes/img/close.png\') no-repeat scroll center center;" onClick="this.parentNode.parentNode.removeChild(this.parentNode);"></td></tr>');
						CKEDITOR.replace(d.t+d.n,{height:'300'});
					}
				});
			}
			jQuery('#pdfcOpen').empty();
			jQuery('#pdfcOpen').append('<option value="_new_">'+data.nouv+'</option>');
			jQuery.each(data.file,function(k,d){
				jQuery('#pdfcOpen').append('<option value="'+d+'">'+d+'</option>');
			});
			if(typeof data.config!=='undefined'){
				var t=document.getElementById('pdfcPage'),to;to=t.options;
				for(v=0;v<to.length;v++){if(to[v].value==data.config.page){to[v].selected=true;v=to.length;}}
				t=document.getElementById('pdfcFormat');to=t.options;
				for(v=0;v<to.length;v++){if(to[v].value==data.config.format){to[v].selected=true;v=to.length;}}
				t=document.getElementById('pdfcFont');to=t.options;
				for(v=0;v<to.length;v++){if(to[v].value==data.config.font){to[v].selected=true;v=to.length;}}
				t=document.getElementById('pdfcSize');to=t.options;
				for(v=0;v<to.length;v++){if(to[v].value==data.config.size){to[v].selected=true;v=to.length;}}
				document.getElementById("pdfcMargleft").value=data.config.left;
				document.getElementById("pdfcMargright").value=data.config.right;
				document.getElementById("pdfcMargtop").value=data.config.top;
				document.getElementById("pdfcMargbottom").value=data.config.bottom;
				document.getElementById("pdfcMarghead").value=data.config.head;
				document.getElementById("pdfcMargfoot").value=data.config.foot;
				document.getElementById("pdfcSubjmail").value=data.subjmail;
				document.getElementById("pdfcContmail").value=data.contmail;
			}
		}});
	});
}
//
function f_pdfcA(){
	document.getElementById('pdfcBlocA').style.display="block";
	document.getElementById('pdfcBlocB').style.display="none";
	document.getElementById('pdfcBlocC').style.display="none";
	document.getElementById('pdfcA').className="bouton fr current";
	document.getElementById('pdfcB').className="bouton fr";
	document.getElementById('pdfcC').className="bouton fr";
}
//
function f_pdfcB(){
	document.getElementById('pdfcBlocB').style.display="block";
	document.getElementById('pdfcBlocA').style.display="none";
	document.getElementById('pdfcBlocC').style.display="none";
	document.getElementById('pdfcB').className="bouton fr current";
	document.getElementById('pdfcA').className="bouton fr";
	document.getElementById('pdfcC').className="bouton fr";
}
//
function f_pdfcC(){
	document.getElementById('pdfcBlocC').style.display="block";
	document.getElementById('pdfcBlocB').style.display="none";
	document.getElementById('pdfcBlocA').style.display="none";
	document.getElementById('pdfcC').className="bouton fr current";
	document.getElementById('pdfcB').className="bouton fr";
	document.getElementById('pdfcA').className="bouton fr";
}
//
f_load_pdfc(0);
