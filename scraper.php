<?
// This is a template for a PHP scraper on morph.io (https://morph.io)
// including some code snippets below that you should find helpful
 require 'scraperwiki.php';
 require 'scraperwiki/simple_html_dom.php';
//
 
 $cHeadres = array(
      'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
      'Accept-Language: en-US,en;q=0.5',
      'Connection: Keep-Alive',
      'Pragma: no-cache',
      'Cache-Control: no-cache'
     );
 $MyWebsite = 'http://web.archive.org/web/20140824112027/http://www.peshawarhighcourt.gov.pk/PHCCMS/reportedJudgments.php?action=search';
 function dlPage($href) {
  global $cHeadres;
  $ch = curl_init();
  if($ch){
   curl_setopt($ch, CURLOPT_URL, $href);
   curl_setopt($ch, CURLOPT_HTTPHEADER, $cHeadres);
   curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
   curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
   curl_setopt($ch, CURLOPT_HEADER, false);
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
   curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)");
   $str = curl_exec($ch);
   curl_close($ch);
   $dom = new simple_html_dom();
   $dom->load($str);
   return $dom;
  }
 }
 $maincode = dlPage($MyWebsite);
 
 foreach($maincode->find("//*[@id='employee_list']/tbody[1]/tr") as $element) {
  
   $a = $element->find("td", 0)->plaintext;
   $b = $element->find("td", 1)->plaintext;
   $c = $element->find("td", 2)->plaintext;
   $d = $element->find("td", 3)->plaintext;
   $e = $element->find("td", 4)->plaintext;
   $f = $element->find("td", 5)->plaintext;
   $g = $element->find("td", 6)->plaintext;
   $h = $element->find("td/a", 0)->href;
   
   echo "$b\n";
  	/*
   ,'remarks' => $c
                                            ,'citation' => $d
                                            ,'decision_date' => $e
                                            ,'sc_date' => $f
                                            ,'cate' => $g
                                            ,'pdflink' => $h
 */
scraperwiki::save_sqlite(array('num'), array('num'=> $a,'casename'=> $b,'remarks'=> $c,'citation'=> $d,'de_date'=> $e,'sc_status'=> $f,'cat'=> $g,'pdflink'=> $h));
 
 } 
 
?>
