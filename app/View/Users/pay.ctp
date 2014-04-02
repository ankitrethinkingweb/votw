<?php
//TEST//
// Merchant key here as provided by Payu
//$MERCHANT_KEY = "C0Dr8m";
// Merchant Salt as provided by Payu
//$SALT = "3sf0jURk";


//LIVE
// Merchant key here as provided by Payu
$MERCHANT_KEY = "tCFLTu";
// Merchant Salt as provided by Payu
$SALT = "fzYMb38B";

// End point - change to https://secure.payu.in for LIVE mode
//$PAYU_BASE_URL = "https://test.payu.in";
$PAYU_BASE_URL = "https://secure.payu.in";
$action = '';

$posted = array();
if(!empty($data)) {
   // print_r($data);
  foreach($data as $key => $value) {    
    $posted[$key] = $value;
  }
  $posted['amount'] = $data['User']['amt'];
}

/*foreach ($posted as $key => $value) {
    echo "posted[".$key."]=".$value."<br>";
}*/

$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
$posted['txnid'] = $txnid;
} else {
  $txnid = $posted['txnid'];
}

$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($txnid)
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
  ) {
    $formError = 1;
  } else {
    $hashVarsSeq = explode('|', $hashSequence);
    $hash_sing = '';
    foreach($hashVarsSeq as $hash_var) {
	if($hash_var == 'txnid')
	$hash_sing .= $txnid;
	else
      $hash_sing .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_sing .= '|';
    }
    $hash_sing .= $SALT;
    $hash = strtolower(hash('sha512', $hash_sing));
    $action = $PAYU_BASE_URL . '/_payment';
	$posted['hash'] = $hash;
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
$_SESSION['trans_data'] = $posted;

//$this->Session->write('trans_data',$posted);
	//print_r($this->Session->read('trans_data'));

?>

<html>
  <script>
    var hash = '<?php echo $hash ?>';
	function submitPayuForm() {
      if(hash == '') {
        return;
      }
     var payuForm = document.forms.payuForm;
     payuForm.submit();
    }
	 
  </script>
  <body onload="submitPayuForm();" >
 <!-- <img src = "" /><br/><h3>Loading...</h3> -->
    <br/>
    <?php if($formError) { ?>
      <span style="color:red">Please fill all mandatory fields.</span>
      <br/>
      <br/>
    <?php } ?>

    <form action="<?php echo $action; ?>" method="post" name="payuForm" >
	
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />

          <input type = "hidden" name="amount" value="<?php echo (empty($posted['User']['amt'])) ? '' : $posted['User']['amt'] ?>" />
         
          <input type = "hidden" name="firstname" id="firstname" value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname']; ?>" />
        
        
          
          <input type = "hidden" name="email" id="email" value="<?php echo (empty($posted['email'])) ? '' : $posted['email']; ?>" />
          
          <input type = "hidden" name="phone" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone']; ?>" />
        
        
         
          <input type = "hidden" name="productinfo" value="<?php echo (empty($posted['productinfo'])) ? '' : $posted['productinfo'] ?>" size="64" />
        
        
         
          <input type = "hidden" name="surl" value="<?php echo (empty($posted['surl'])) ? '' : $posted['surl'] ?>" size="64" />
        
        
          
          <input type = "hidden" name="furl" value="<?php echo (empty($posted['furl'])) ? '' : $posted['furl'] ?>" size="64" />
        
        
        
        
        
          
          <input type = "hidden" name="lastname" id="lastname" value="<?php echo (empty($posted['lastname'])) ? '' : $posted['lastname']; ?>" />
          
          <input type = "hidden" name="curl" value="" />
        
        
         
          <input type = "hidden" name="address1" value="<?php echo (empty($posted['address1'])) ? '' : $posted['address1']; ?>" />
        
          <input type = "hidden" name="address2" value="<?php echo (empty($posted['address2'])) ? '' : $posted['address2']; ?>" />
        
        
        
          <input type = "hidden" name="city" value="<?php echo (empty($posted['city'])) ? '' : $posted['city']; ?>" />
          
          <input type = "hidden" name="state" value="<?php echo (empty($posted['state'])) ? '' : $posted['state']; ?>" />
        
        
         
          <input type = "hidden" name="couny" value="<?php echo (empty($posted['couny'])) ? '' : $posted['couny']; ?>" />
          
          <input type = "hidden" name="zipcode" value="<?php echo (empty($posted['zipcode'])) ? '' : $posted['zipcode']; ?>" />
        
        
         
          <input type = "hidden" name="udf1" value="<?php echo (empty($posted['udf1'])) ? '' : $posted['udf1']; ?>" />
         
          <input type = "hidden" name="udf2" value="<?php echo (empty($posted['udf2'])) ? '' : $posted['udf2']; ?>" />
        
        
          
          <input type = "hidden" name="udf3" value="<?php echo (empty($posted['udf3'])) ? '' : $posted['udf3']; ?>" />
          
          <input type = "hidden" name="udf4" value="<?php echo (empty($posted['udf4'])) ? '' : $posted['udf4']; ?>" />
        
        
          
          <input type = "hidden" name="udf5" value="<?php echo (empty($posted['udf5'])) ? '' : $posted['udf5']; ?>" />
          
          <input type = "hidden" name="pg" value="<?php echo (empty($posted['pg'])) ? '' : $posted['pg']; ?>" />
        
	
          
          <input type = "hidden" name="codurl" value="<?php echo (empty($posted['codurl'])) ? '' : $posted['codurl']; ?>" />
         
          <input type = "hidden" name="touturl" value="<?php echo (empty($posted['touturl'])) ? '' : $posted['touturl']; ?>" />
        
	
        
          <input type = "hidden" name="drop_category" value="<?php echo (empty($posted['drop_category'])) ? '' : $posted['drop_category']; ?>" />
         
          <input type = "hidden" name="custom_note" value="<?php echo (empty($posted['custom_note'])) ? '' : $posted['custom_note']; ?>" />
     
        
         <input type = "hidden" name="note_category" value="<?php echo (empty($posted['note_category'])) ? '' : $posted['note_category']; ?>" />
       
          <?php if(!$hash) { ?>
           <input style = "visibility:hidden" type="submit" value="Submit" />
          <?php } ?>
        
    </form>
  </body>
</html>
