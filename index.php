<?php
setlocale(LC_COLLATE,'pl_PL.UTF-8'); 

function debuglog ($m) {
	if (isset($_REQUEST['debug'])) echo '<div><span style="color:green;">(debug) </span>'.$m.'</div>';
}
?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8" />
 <meta name="format-detection" content="telephone=no" /> 
 <title>nWords</title>
 <style type="text/css"><!--

	body {background:#b0c4de;color:black;}

   .w {margin:0em 1em;font-size:.9em;}
   .w:hover {background-color:silver;}
   .w a {text-decoration:none;}
   .w a:hover, .w a:active, .w:hover a:before {text-decoration:none;color:red;}
   .w a:before {content:'znaczenie: ';color:gray;padding-left:1em;}
   .w span {font-size:1.5em;}

   p {font-size:.5em;}

   input[type="text"], input[type="number"] {
      -webkit-appearance: none; -moz-appearance: none;
     display: block;
	 margin: 0; padding:.5em;
     width: 100%; height: 5em;
     line-height: 5em; font-size: 1.1em;
     border: 1px solid #bbb;
   }

   div.tr {clear:both;border:1px solid silver;padding:.4em;margin:0.3em;}
   div.th {clear:both;font-size:1.1em;font-weight:bolder;}
   div.th.button input, button[type=submit] {
      -webkit-appearance: none; -moz-appearance: none;
      display: block;
      margin: 1.5em 0;
	  font-size: 1em; line-height: 2.5em;
      color: #333;
      font-weight: bold;
      height: 2.5em; width: 100%;
      background: #fdfdfd;
      background: -moz-linear-gradient(top, #fdfdfd 0%, #bebebe 100%);
      background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fdfdfd), color-stop(100%,#bebebe));
      background: -webkit-linear-gradient(top, #fdfdfd 0%,#bebebe 100%);
      background: -o-linear-gradient(top, #fdfdfd 0%,#bebebe 100%);
      background: -ms-linear-gradient(top, #fdfdfd 0%,#bebebe 100%);
      background: linear-gradient(to bottom, #fdfdfd 0%,#bebebe 100%);
      border: 1px solid #bbb;
      -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px;
   }
   div.th.colspan-2 {}
   div.td {}
   div.desc {clear:both;font-size:.7em;}

   /* unstyled tel links as default */
   a[href^='tel:']:link, a[href^='tel:']:visited {
      color: #6f757c;
      font-weight: normal;
      text-decoration: none;
   }
   a[href^='tel:']:hover, a[href^='tel:']:active {
      color: #6f757c;
      text-decoration: none;
   }

   /* styled tel links for small viewports */
   @media screen and (max-width: 600px) {
      a[href^='tel:']:link, a[href^='tel:']:visited {
		 color: #333;
         font-weight: bold;
         text-decoration: underline;
      }
      a[href^='tel:']:hover, a[href^='tel:']:active {
         color: #333;
         text-decoration: none;
      }
   }

 --></style>
</head>
<body style="padding-top:4em;">

<?php
$_REQUEST['letters'] = str_replace(' ', '', preg_replace('/[0-9]/u', '', $_REQUEST['letters']));
$_REQUEST['prefix'] = str_replace(' ', '', preg_replace('/[0-9]/u', '', $_REQUEST['prefix']));
$_REQUEST['length'] = (integer)$_REQUEST['length'];
$word_length = $_REQUEST['length'];
$letters_length = strlen($_REQUEST['letters']);
$letters = htmlspecialchars(strtolower($_REQUEST['letters']));
$prefix = htmlspecialchars(strtolower($_REQUEST['prefix']));
?>

<h1 style="margin:0;padding:0.4em;position:fixed;top:0;right:0;left:0;height:1em;font-size:2em;background-color:#111;color:#fff;">nwords | PL <span style="font-size:.5em;font-weight:nomral;">UTF-8</span></h1>

<a name="top"></a>
<a href="<?=dirname($_SERVER['SCRIPT_NAME']);?>"><?=dirname($_SERVER['SCRIPT_NAME']);?></a>

<p align="justify" onclick="this.style.display='none';">Dopasuj polskie wyrazy. U&#380;yteczne przy r&#243;&#380;nej ma&#347;ci gierek. Brak Ci podpowiedzi? Pozw&#243;l by maszyna zrobi&#322;a to za Ciebie! Bazuje na li&#347;cie wyraz&#243;w polskich udost&#281;pnionych przez <b>&quot;S&#322;ownik j&#281;zyka polskiego SJP&quot;</b> <a href="https://sjp.pl/">https://sjp.pl/</a></p>

<form action="<?php $_PHP_SELF ?>#list" method="get" target="_self">
 <div class="table">
  <div class="tr">
   <div class="th">Literki: </div>
   <div class="td"><input type="text" name="letters" value="<?=$letters;?>" maxlength="999" /></div>
   <div class="desc" onclick="this.style.display='none';">wszystkie z kt&#243;rych ma/mo&#380;e sk&#322;ada&#263; si&#281; szukany wyraz, r&#243;wnie&#380; te zawarte w prefix. R&#243;wnie&#380; powtarzaj&#261;ce si&#281;.</div>
  </div>
  <div class="tr">
   <div class="th">D&#322;ugo&#347;&#263;: </div>
   <div class="td"><input type="number" name="length" value="<?=$word_length;?>" min="0" max="99" /></div>
   <div class="desc" onclick="this.style.display='none';">oczekiwana d&#322;ugo&#347;&#263; szukanego s&#322;owa</div>
  </div>
  <div class="tr">
   <div class="th">Prefix: </div>
   <div class="td"><input type="text" name="prefix" value="<?=$prefix;?>" maxlength="99" /></div>
   <div class="desc" onclick="this.style.display='none';">(opcjonalne) od jakich literek zaczyna si&#281; wyraz</div>
  </div>
  <div class="tr">
	<div class="th button">
		<input type="submit" value="Szukaj..." style="font-size:1.2em;padding:.3em 1.3em" />
	</div>
	<div class="th button">
		<input type="reset" value="Nowe szukanie" />
	</div>
  </div>
 </div>
</form>

<?php

function sorted_string ($t) {
	$stringParts = preg_split('/(?!^)(?=.)/u', $t);
	sort($stringParts, SORT_LOCALE_STRING);
	return implode('', $stringParts);
}

//$slownik = file_get_contents('sjp-20170924/slowa.txt');
$slownik = 'sjp-20170924/slowa.txt';
debuglog('path to dictionary: '.$slownik);

$_pattern_length = $word_length;
if ($_REQUEST['letters']) {
	$_letters = sorted_string($_REQUEST['letters']);

	if ($_REQUEST['prefix']) {
		$_prefix = $_REQUEST['prefix'];
		$l = strlen($_prefix);
		for ($i = 0; $i < $l; ++$i) {
			$p = strpos($_letters, $_prefix[$i]);
			if ($p === false) {
				// not found
			}
			else {
				$_letters = substr($_letters, 0, $p).substr($_letters, $p + 1);
				if ($_pattern_length) --$_pattern_length;
			}
		}
	}
	$_letters = htmlspecialchars($_letters);
}

if (($word_length > 1) || (strlen($prefix) > 1) || ((strlen($letters) > 0) and ($letters != $prefix))) {

	// get doubled letters
	$doubled_letters = array();
	//if (preg_match('/(\w)\1+/u', $_letters, $doubled_letters)) {
	debuglog('check doubled letters for: '.$_letters);
	{
		/* WORKAROUND HACK
		 * Issue: preg with pattern /(\w)\1+/ not working with PHP ... so we use for-loop and if-else block
		 */
		$stringParts = preg_split('/(?!^)(?=.)/u', $_letters);
		$ll = ''; // last letter
		$_letters_cp = '';
		foreach ($stringParts as $at => $chr) {
			if ($ll == $chr) {
				if (! isset($doubled_letters[$chr])) $doubled_letters[$chr] = 1;
				++ $doubled_letters[$chr];
				debuglog('doubled letter: "'.$chr.'", times = '.$doubled_letters[$chr]);
			}
			else {
				// we need to remove repeated letters for next operations / patterns
				$_letters_cp .= $chr;
			}
			$ll = $chr;
		}
		$_letters = $_letters_cp;
		debuglog('new letters string (removed doubled letters): ['.$_letters.']');
		unset($_letters_cp);
		unset($stringParts);
	}

	$_pattern = '/\b^'.$prefix.'['.$_letters.']'
		.(($_pattern_length > 0) ? '{'.$_pattern_length.'}' : '*')
		.'$\b/u'
		;
	echo '<div style="margin:1em 0em;padding:0 1em;border-left:1.6em solid silver;">';
	debuglog('d&#322;ugo&#347;&#263; s&#322;owa: '.$word_length);
	debuglog('brakuj&#261;ce literki: '.$_letters);
	debuglog('prefix: '.$prefix);
	debuglog('wzorzec: '.$_pattern);
	echo '<div style="margin-top:1em;padding-top:1em;border-top:1px dotted silver;"></div>';
	$f = fopen($slownik, 'r');
	if ($f) {
		echo '<a name="list"></a>';
		echo '<h1>lista wyraz&#243;w dopasowanych:</h1>';
		$lp = 0;
		$c = '';

		$_pattern_doubled = ''; // \bd(([u]{2})|([pa]?)){4}\b
		foreach ($doubled_letters as $chr => $times) { // @param times: repeated times
			// \b.*(u{2}u|(a{1}a)).*\b
			$_pattern_doubled .= (($_pattern_doubled != '') ? '|' : '').$chr.'{'.$times.'}'.$chr;
		}

		$_letters_x = preg_split('/(?!^)(?=.)/u', $_letters);
		foreach ($_letters_x as $k => $chr) {
			if (isset($doubled_letters[$chr])) continue;
			$_pattern_doubled .= (($_pattern_doubled != '') ? '|' : '').$chr.'{1}'.$chr;
		}
		unset($_letters_x);
		unset($_letters_r);
		if ($_pattern_doubled != '') {
			$_pattern_doubled = '/\b.*('.$_pattern_doubled.').*\b/u';
			debuglog('template for checker: '.$_pattern_doubled);
		}

		while (($w = fgets($f)) !== false) {
			$w = trim($w);

			$match = array();
			if (preg_match($_pattern, $w, $match)) {

				$w_sorted = sorted_string($w);
				debuglog('sorted w to check '.$w_sorted.' --- ori='.$w);
				if (preg_match($_pattern_doubled, $w_sorted, $match_doubled)) {
					// to many letters of on type in word
					continue;
				}

				++$lp;
				$c .= '<div class="w"><span>'.$w.'</span>'
					.' - <a href="https://sjp.pl/'.$w.'">https://sjp.pl/'.$w.'</a>'
					.'</div>'."\n";
			}
		}
		fclose($f);
		if ($lp == 0) {
			echo '<div>Nie odnaleziono wyraz&#243;w polskich pasuj&#261;cych do zdefiniowanego wzorca</div>';
		}
		else {
			echo '<p style="margin-bottom:1em;">Dopasowano s&#322;&#243;w: '.$lp.'</p>'."\n".$c;
		}
	} else {
		echo '<div>S&#322;ownik znikn&#261;&#322;? Pewnie aktualizacja - spr&#243;buj ponownie za chwil&#281;...</div>';
	}
	echo '<p><a href="#top">^ top</a></p>';
	echo '</div>';
}
else {
	echo '<div style="margin:1em;padding:1em;border-top:1px dotted silver;"><h2>No czeee&#347;&#263;</h2> Uzupe&#322;nij formularz powy&#380;ej i zaczynamy ;) ... ju&#380; nie mog&#281; si&#281; doczeka&#263;... a Ty?</div>';
}

if (($word_length < 2) and (strlen($prefix) == 1) and ((strlen($letters) == 0) || ($letters == $prefix))) {
	echo '<h1 style="margin:0;padding:0;text-transform:uppercase;text-align:center;border-top:1px dotted silver;font-size:13em;">'.$prefix.'</h1>';
}

if ($word_length == 1) {
	echo '<div style="margin:1em;padding:1em;border-top:1px dotted silver;"><h2>E&#281;</h2> D&#322;ugo&#347;&#263; s&#322;owa - warto&#347;&#263; nieprawid&#322;owa. Dopuszczalne warto&#347;ci to 0 (zero) oraz wi&#281;ksze ni&#380; 1 (jeden) - nie szukamy literek, a wyraz&#243;w / zwrot&#243;w. Literek w polskim alfabecie mamy 32 - z pewno&#347;ci&#261; &#322;atwo je odnajdziesz.</div>';
}

?>

	<div style="margin:1em;padding:1em;border-top:1px dotted silver;" align="right">
		<p>Copyright &copy; <?=date('Y');?> | Gidway, PL <a href="http://gidway.net">www.gidway.net</a></p>
		<p>Krzysztof Mularski</p>
	</div>

</body>
</html>
