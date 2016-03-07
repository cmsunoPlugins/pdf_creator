<?php
session_start(); 
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])!='xmlhttprequest') {sleep(2);exit;} // ajax request
if(!isset($_POST['unox']) || $_POST['unox']!=$_SESSION['unox']) {sleep(2);exit;} // appel depuis uno.php
?>
<?php
include('../../config.php');
include('lang/lang.php');
if(!is_dir('../../data/_pdf_creator/')) mkdir('../../data/_pdf_creator/');
// ********************* actions *************************************************************************
if (isset($_POST['action']))
	{
	switch ($_POST['action'])
		{
		// ********************************************************************************************
		case 'plugin': ?>
		<div class="blocForm">
			<div id="pdfcC" class="bouton fr" onClick="f_pdfcC();" title="<?php echo _("Send");?>"><?php echo _("Send");?></div>
			<div id="pdfcB" class="bouton fr" onClick="f_pdfcB();" title="<?php echo _("Config");?>"><?php echo _("Config");?></div>
			<div id="pdfcA" class="bouton fr current" onClick="f_pdfcA();" title="<?php echo _("Creation");?>"><?php echo _("Creation");?></div>
			<h2>PDF Creator</h2>
			<div id="pdfcBlocA">
				<p><?php echo _("This plugin allows you to create PDF files from the HTML Editor. Output will be directly in the file manager.");?></p>
				<p><?php echo _("You can insert small text content (name, date...) in the 3 part of the page (head, content and footer) by adding the shortcode [[name-of-the-small-content]] at the right place.");?></p>
				<p><?php echo _("This plugin is not active in the site creation.");?></p>
				<h3><?php echo _("Creation :");?></h3>
				<table class="hForm">
					<tr>
						<td><label><?php echo _("Existing files");?></label></td>
						<td>
							<select name="pdfcOpen" id="pdfcOpen">
							</select>
							<div class="bouton" style="margin:0;" onClick="f_load_pdfc(document.getElementById('pdfcOpen').options[document.getElementById('pdfcOpen').selectedIndex].value)" title="<?php echo _("Open");?>"><?php echo _("Open");?></div>
						</td>
					</tr>
					<tr id="pdfcCreate">
						<td><label><?php echo _("Create new file");?></label></td>
						<td>
							<input class="input" type="text" class="input" name="pdfcFile" id="pdfcFile" style="width:80px;margin-right:20px;" value="" />
							<div class="bouton" style="margin:0;" onClick="f_create_pdfc(document.getElementById('pdfcFile').value);" title="<?php echo _("Create new file");?>"><?php echo _("Create");?></div>
						</td>
					</tr>
					<tr id="pdfcAdd">
						<td><label><?php echo _("Name of the field");?></label></td>
						<td>
							<input class="input" type="text" class="input" name="pdfcName" id="pdfcName" style="width:80px;margin-right:20px;" value="" />
							<div class="bouton" style="margin:0;" onClick="f_add_pdfc(document.getElementById('pdfcName').value);" title="<?php echo _("Add the field");?>"><?php echo _("Add");?></div>
						</td>
					</tr>
				</table>
				<h3><?php echo _("Existing fields :");?></h3>
				<form id="frmPdfc">
					<table id="curPdfc"></table>
				</form>
				<div class="bouton fr" onClick="f_delete_pdfc(document.getElementById('pdfcActif').value);" title="<?php echo _("Delete");?>"><?php echo _("Delete");?></div>
				<div class="bouton fr" onClick="f_save_pdfc();" title="<?php echo _("Save settings");?>"><?php echo _("Save");?></div>
				<div class="clear"></div>
				<div class="fr">
					<label><?php echo _("File name add");?> :</label>
					<input class="input" type="text" class="input" name="pdfcFileName" id="pdfcFileName" style="width:80px;margin-right:20px;" value="" />
					<div class="bouton" onClick="f_makepdf_pdfc(document.getElementById('pdfcActif').value,document.getElementById('pdfcFileName').value);" title="<?php echo _("Create PDF");?>"><?php echo _("Create PDF");?></div>
				</div>
				<div class="clear"></div>
			</div>
			<div id="pdfcBlocB" style="display:none;">
				<h3><?php echo _("Options");?>&nbsp;:</h3>
				<table class="hForm">
					<tr>
						<td><label><?php echo _("Size");?></label></td>
						<td>
							<select name="pdfcPage" id="pdfcPage">
								<option value="210,297">A4 <?php echo _("Default");?></option>
								<option value="594,841">A1</option>
								<option value="420,594">A2</option>
								<option value="297,420">A3</option>
								<option value="148,210">A5</option>
								<option value="105,148">A6</option>
								<option value="707,1000">B1</option>
								<option value="500,707">B2</option>
								<option value="353,500">B3</option>
								<option value="250,353">B4</option>
								<option value="176,250">B5</option>
								<option value="125,176">B6</option>
							</select>
						</td>
						<td><em><?php echo _("Output Page Size.");?></em></td>
					</tr>
					<tr>
						<td><label><?php echo _("Format");?></label></td>
						<td>
							<select name="pdfcFormat" id="pdfcFormat">
								<option value="P"><?php echo _("Portrait");?></option>
								<option value="L"><?php echo _("Landscape");?></option>
							</select>
						</td>
						<td><em><?php echo _("Output Page Format : Portrait or Landscape.");?></em></td>
					</tr>
					<tr>
						<td><label><?php echo _("Font Family");?></label></td>
						<td>
							<select name="pdfcFont" id="pdfcFont">
								<option value="dejavuserif">DejaVu Serif (<?php echo _("Default");?>)</option>
								<option value="dejavusans">DejaVu Sans-Serif</option>
								<option value="dejavusanscondensed">DejaVu Sans-Serif Condensed</option>
								<option value="dejavusansmono">DejaVu Mono</option>
								<option value="freeserif">Free Serif</option>
								<option value="freesans">Free Sans-Serif</option>
								<option value="freemono">Free Mono</option>
								<option value="garuda">Garuda Sans-Serif</option>
							</select>
						</td>
						<td><em><?php echo _("Font Family");?>.</em></td>
					</tr>
					<tr>
						<td><label><?php echo _("Font Size");?></label></td>
						<td>
							<select name="pdfcSize" id="pdfcSize">
								<option value=""><?php echo _("Default");?></option>
								<option value="8">8 pt</option>
								<option value="9">9 pt</option>
								<option value="10">10 pt</option>
								<option value="11">11 pt</option>
								<option value="12">12 pt</option>
								<option value="13">13 pt</option>
								<option value="14">14 pt</option>
								<option value="15">15 pt</option>
								<option value="16">16 pt</option>
							</select>
						</td>
						<td><em><?php echo _("Font Size");?>.</em></td>
					</tr>
					<tr>
						<td><label><?php echo _("Margin left");?></label></td>
						<td>
							<input class="input" style="width:50px;" type="text" name="pdfcMargleft" id="pdfcMargleft" />
						</td>
						<td><em><?php echo _("Empty => default");?>.</em></td>
					</tr>
					<tr>
						<td><label><?php echo _("Margin right");?></label></td>
						<td>
							<input class="input" style="width:50px;" type="text" name="pdfcMargright" id="pdfcMargright" />
						</td>
						<td><em><?php echo _("Empty => default");?>.</em></td>
					</tr>
					<tr>
						<td><label><?php echo _("Margin top");?></label></td>
						<td>
							<input class="input" style="width:50px;" type="text" name="pdfcMargtop" id="pdfcMargtop" />
						</td>
						<td><em><?php echo _("Empty => default");?>.</em></td>
					</tr>
					<tr>
						<td><label><?php echo _("Margin bottom");?></label></td>
						<td>
							<input class="input" style="width:50px;" type="text" name="pdfcMargbottom" id="pdfcMargbottom" />
						</td>
						<td><em><?php echo _("Empty => default");?>.</em></td>
					</tr>
					<tr>
						<td><label><?php echo _("Margin head");?></label></td>
						<td>
							<input class="input" style="width:50px;" type="text" name="pdfcMarghead" id="pdfcMarghead" />
						</td>
						<td><em><?php echo _("Empty => default");?>.</em></td>
					</tr>
					<tr>
						<td><label><?php echo _("Margin foot");?></label></td>
						<td>
							<input class="input" style="width:50px;" type="text" name="pdfcMargfoot" id="pdfcMargfoot" />
						</td>
						<td><em><?php echo _("Empty => default");?>.</em></td>
					</tr>
				</table>
				<div class="bouton fr" onClick="f_config_pdfc();" title="<?php echo _("Save settings");?>"><?php echo _("Save");?></div>
				<div class="clear"></div>
			</div>
			<div id="pdfcBlocC" style="display:none;">
				<p><?php echo _("Send the PDF created to an email address. They should have the same file name add.");?></p>
				<h3><?php echo _("Send");?>&nbsp;:</h3>
				<table class="hForm">
					<tr>
						<td><label><?php echo _("Email");?></label></td>
						<td>
							<input class="input" style="width:250px;" type="text" name="pdfcEmail" id="pdfcEmail" />
						</td>
						<td><em><?php echo _("Recipient's email address");?>.</em></td>
					</tr>
					<tr>
						<td><label><?php echo _("File name add");?></label></td>
						<td>
							<input class="input" style="width:100px;" type="text" name="pdfcComp" id="pdfcComp" />
							<div class="bouton" onClick="f_check_pdfc();" title="<?php echo _("Check");?>"><?php echo _("Check");?></div>
							<span id="pdfcCheck"></span>
						</td>
						<td><em><?php echo _("The PDF will be selected with this add to the file name");?>.</em></td>
					</tr>
					<tr>
						<td><label><?php echo _("Email subject");?></label></td>
						<td>
							<input class="input" style="width:250px;" type="text" name="pdfcSubjmail" id="pdfcSubjmail" />
						</td>
						<td><em><?php echo _("Subject for the email");?>.</em></td>
					</tr>
					<tr>
						<td><label><?php echo _("Email content");?></label></td>
						<td>
							<textarea style="width:250px;height:100px;" name="pdfcContmail" id="pdfcContmail">bla</textarea>
						</td>
						<td><em><?php echo _("Content for the email");?>.</em></td>
					</tr>
				</table>
				<div class="bouton fr" onClick="f_send_pdfc();" title="<?php echo _("Send");?>"><?php echo _("Send");?></div>
				<div class="clear"></div>
			</div>
		</div>
		<?php break;
		// ********************************************************************************************
		case 'load':
		$a = array(); $c = 0;
		$q = file_get_contents('../../data/pdf_creator.json');
		if($q)
			{
			$b = json_decode($q,true);
			if(!isset($b['nom']) || !file_exists('../../data/_pdf_creator/'.$b['nom'].'.json')) $c = 1; // FILE DELETED
			if(!$_POST['nom']) $n = $b['nom'];
			else $n = $_POST['nom'];
			if($n!='_new_' && !$c)
				{
				$q = file_get_contents('../../data/_pdf_creator/'.$n.'.json');
				if($q) $a = json_decode($q,true);
				}
			$h = opendir('../../data/_pdf_creator/');
			while(($d=readdir($h))!==false)
				{
				if(is_file('../../data/_pdf_creator/'.$d))
					{
					$e = explode('.json',$d);
					$a['file'][] = $e[0];
					if($c==1) // FILE DELETED
						{
						$b['nom'] = $e[0];
						$out1 = json_encode($b);
						file_put_contents('../../data/pdf_creator.json', $out1);
						$c = $e[0];
						}
					}
				}
			closedir($h);
			$a['nom'] = (($c && $c!=1)?$c:$n);
			$a['nouv'] = _("New");
			if(isset($b['config'])) $a['config'] = $b['config'];
			if(isset($b['subjmail'])) $a['subjmail'] = $b['subjmail'];
			if(isset($b['contmail'])) $a['contmail'] = $b['contmail'];
			echo json_encode($a);
			exit;
			}
		echo '!'._('Error');
		break;
		// ********************************************************************************************
		case 'save':
		$a = array(); $c=0; $n = '';
		$q = file_get_contents('../../data/pdf_creator.json');
		if($q) $b = json_decode($q,true); else $b = array();
		foreach($_POST as $k=>$v)
			{
			if ($k!='action' && $k!='unox')
				{
				$a['pdfc'][$c]['n'] = substr($k,1); // name
				$a['pdfc'][$c]['t'] = substr($k,0,1); // type
				$a['pdfc'][$c]['b'] = stripslashes(str_replace('<','&lt;',$v)); // field content
				if($a['pdfc'][$c]['t']=='E' && strpos($a['pdfc'][$c]['n'],'head')===false && strpos($a['pdfc'][$c]['n'],'foot')===false) $n = $a['pdfc'][$c]['n'];
				++$c;
				}
			}
		$out = json_encode($a);
		$b['nom'] = $n;
		$out1 = json_encode($b);
		if($n && file_put_contents('../../data/_pdf_creator/'.$n.'.json', $out) && file_put_contents('../../data/pdf_creator.json', $out1)) echo _('Backup performed');
		else echo '!'._('Impossible backup');
		break;
		// ********************************************************************************************
		case 'config':
		$a = array();
		$q = file_get_contents('../../data/pdf_creator.json');
		if($q) $a = json_decode($q,true);
		foreach($_POST as $k=>$v) if($k!='action' && $k!='unox') $a['config'][$k] = $v;
		$out = json_encode($a);
		if(file_put_contents('../../data/pdf_creator.json', $out)) echo _('Backup performed');
		else echo '!'._('Impossible backup');
		break;
		// ********************************************************************************************
		case 'send':
		$q = @file_get_contents('../../data/busy.json');
		$tit = "";
		if($q)
			{
			$a = json_decode($q,true);
			$q = @file_get_contents('../../data/'.$a['nom'].'/site.json');
			if($q)
				{
				$a = json_decode($q,true);
				$tit = $a['tit'];
				}
			}
		//
		$a = array(); $b = array(); $c = 0;
		$q = file_get_contents('../../data/pdf_creator.json');
		if($q)
			{
			$a = json_decode($q,true);
			$a['subjmail'] = $_POST['subj'];
			$a['contmail'] = $_POST['cont'];
			$out = json_encode($a);
			file_put_contents('../../data/pdf_creator.json', $out);
			if(file_exists('../../data/_sdata-'.$sdata.'/ssite.json'))
				{
				$q1 = file_get_contents('../../data/_sdata-'.$sdata.'/ssite.json'); $a1 = json_decode($q1,true);
				$mail = $a1['mel'];
				}
			else $mail = false;
			$h = opendir('../../../files/');
			while(($d=readdir($h))!==false)
				{
				if(is_file('../../../files/'.$d) && strpos($d,'_'.$_POST['comp'].'.pdf'))
					{
					$b[] = array('name'=>$d, 'attach'=>chunk_split(base64_encode(file_get_contents('../../../files/'.$d))));
					++$c;
					}
				}
			closedir($h);
			// SEND
			if($c && $mail)
				{
				include ('../../template/mailTemplate.php');
				$dest = '<em>'._('Email sent to').' : '.$_POST['mail'].' - '.date("d.m.Y").'</em>';
				$bottom= str_replace('[[unsubscribe]]',$dest, $bottom); // template
				$msgT = stripslashes($_POST['cont']);
				$msgH = $top . nl2br(stripslashes($_POST['cont'])) . $bottom;
				$uid = md5(uniqid(time()));
				$rn = PHP_EOL;
				$header = "From: ".$tit." <".$mail.">".$rn;
				$header .= "Reply-To: ".$tit." <".$mail.">".$rn;
				$header .= "MIME-Version: 1.0".$rn;
				$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"".$rn;
				$content = $rn."--".$uid.$rn;
				$content .= "Content-Type: text/html; charset=\"utf-8\"".$rn;
				$content .= "Content-Transfer-Encoding: 7bit".$rn;
				$content .= $rn.$msgH.$rn;
				foreach($b as $r)
					{ 
					$content .= $rn."--".$uid.$rn;
					$content .= "Content-Type: application/octet-stream; name=\"".$r['name']."\"".$rn;
					$content .= "Content-Transfer-Encoding: base64".$rn;
					$content .= "Content-Disposition: attachment; filename=\"".$r['name']."\"".$rn;
					$content .= $rn.$r['attach'].$rn;
					}
				$content .= $rn."--".$uid."--";
				if(mail(stripslashes($_POST['mail']), stripslashes($_POST['subj']), $content, $header)) echo _('Email sent');
				else echo _('Failed to send');
				mail($mail, 'Admin - '.stripslashes($_POST['subj']), $content, $header);
				}
			else echo '!'._('Error');
			}
		else echo '!'._('Error');
		break;
		// ********************************************************************************************
		case 'check':
		$c = 0;
		$h = opendir('../../../files/');
		while(($d=readdir($h))!==false)
			{
			if(is_file('../../../files/'.$d) && strpos($d,'_'.$_POST['comp'].'.pdf')) ++$c;
			}
		if($c) echo '<em style="color:green">'.$c.' '._('PDF files').'</em>';
		else echo '<em style="color:red">'._('No result').'</em>';
		break;
		// ********************************************************************************************
		case 'delete':
		if(file_exists('../../data/_pdf_creator/'.$_POST['nom'].'.json') && unlink('../../data/_pdf_creator/'.$_POST['nom'].'.json')) echo _('Deleted');
		else echo '!'._('Error');
		clearstatcache();
		break;
		// ********************************************************************************************
		case 'makepdf':
		$a = false; $b = array();
		if(file_exists('../../data/pdf_creator.json'))
			{
			$q = file_get_contents('../../data/pdf_creator.json');
			$b = json_decode($q,true);
			}
		if(file_exists('../../data/_pdf_creator/'.$_POST['nom'].'.json'))
			{
			$q = file_get_contents('../../data/_pdf_creator/'.$_POST['nom'].'.json');
			if($q) $a = json_decode($q,true);
			}
		if($a)
			{
			include(dirname(__FILE__).'/mpdf/mpdf.php');
			if(isset($b['config']['page'])&&$b['config']['page'])
				{
				$page = explode(',',$b['config']['page']);
				}
			else $page = '';
			$mpdf = new mPDF(
				'', // mode - BLANK
				$page, // format - A4
				(isset($b['config']['size'])&&$b['config']['size']?$b['config']['size']:0), // font-size
				(isset($b['config']['font'])&&$b['config']['font']?$b['config']['font']:''), // font-family
				(isset($b['config']['left'])&&$b['config']['left']?$b['config']['left']:15), // margin left
				(isset($b['config']['right'])&&$b['config']['right']?$b['config']['right']:15), // margin right
				(isset($b['config']['top'])&&$b['config']['top']?$b['config']['top']:16), // margin top
				(isset($b['config']['bottom'])&&$b['config']['bottom']?$b['config']['bottom']:16), // margin bottom
				(isset($b['config']['head'])&&$b['config']['head']?$b['config']['head']:9), // margin head
				(isset($b['config']['foot'])&&$b['config']['foot']?$b['config']['foot']:9), // margin foot
				(isset($b['config']['format'])&&$b['config']['format']?$b['config']['format']:'P') // orientation
				);
			$mpdf->setAutoTopMargin = 'stretch';
			$mpdf->setAutoBottomMargin = 'stretch';
			$h='';$c='';$f='';
			// HTML Content
			foreach($a['pdfc'] as $k=>$v)
				{
				if($v['t']=='E' && strpos($v['n'],'head')===false && strpos($v['n'],'foot')===false)
					{
					$c = stripslashes(str_replace('&lt;','<',$v['b']));
					$n = $v['n'];
					}
				else if($v['t']=='E' && strpos($v['n'],'head')!==false) $h = stripslashes(str_replace('&lt;','<',$v['b']));
				else if($v['t']=='E' && strpos($v['n'],'foot')!==false) $f = stripslashes(str_replace('&lt;','<',$v['b']));
				}
			// Shortcode
			foreach($a['pdfc'] as $k=>$v)
				{
				if($v['t']=='T')
					{
					$c = str_replace('[['.$v['n'].']]',$v['b'],$c);
					$h = str_replace('[['.$v['n'].']]',$v['b'],$h);
					$f = str_replace('[['.$v['n'].']]',$v['b'],$f);
					}
				else if($v['t']=='E' && strpos($v['n'],'head')!==false) $h = stripslashes(str_replace('&lt;','<',$v['b']));
				else if($v['t']=='E' && strpos($v['n'],'foot')!==false) $f = stripslashes(str_replace('&lt;','<',$v['b']));
				}
			// O - set the header for ODD pages (default)
			// E - set the header for EVEN pages
			$mpdf->SetHTMLHeader($h,O,TRUE);
			$mpdf->SetHTMLFooter($f,O,TRUE);
			$mpdf->WriteHTML($c);
			// I: send the file inline to the browser. The plug-in is used if available. The name given by filename is used when one selects the "Save as" option on the link generating the PDF.
			// D: send to the browser and force a file download with the name given by filename.
			// F: save to a local file with the name given by filename (may include a path).
			// S: return the document as a string. filename is ignored.
			if(file_exists('../../../files/'.$n.'_'.$_POST['comp'].'.pdf')) unlink('../../../files/'.$n.'_'.$_POST['comp'].'.pdf');
			$mpdf->Output('../../../files/'.$n.'_'.$_POST['comp'].'.pdf','F');
			if(file_exists('../../../files/'.$n.'_'.$_POST['comp'].'.pdf')) echo _('PDF Created');
			else echo '!'._('Impossible');
			exit;
			}
		echo '!'._('no data');
		break;
		// ********************************************************************************************
		}
	clearstatcache();
	exit;
	}
?>
