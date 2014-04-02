<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Receipt</title>
</head>

<body style="padding:25px;border:5px double #000;font:small courier;line-height:4px;">
<center>
<table style="width:100%;text-align:center;">
<tr><td style= "font-weight:bold;font-size:25px;">GLOBAL VOYAGES</td></tr>
<tr><td style = "font-size:12px;letter-spacing:-1px;padding-top:7px;padding-bottom:7px;">24/ 1ST FLOOR, BHABHA HOUSE, 191, BORA BAZAAR STREET, FORT, MUMBAI. 400-001.</td></tr>
<tr><td style = "font-size:12px;letter-spacing:-1px;padding-bottom:7px;">022-22623252, 22693261 accounts@global-voyages.in</td></tr>
</table>

<table style="width:100%;padding-bottom:8px;font-size:12px;">
<tr >
<td style = "padding-bottom:10px;text-align:center;">SERVICE TAX NO. : APZPK8885RSD001</td>
</tr>
<tr>
<td style="text-align:center;font-size:20px;">INVOICE</td>
</tr>
</table>

<table style="width:100%;font-size:12px;" >
<tr><td style = "width:40%;">
<p ><span style= "font-weight:bold;">To M/s.</span> : <?php if(isset($user['bus_name'])) echo $user['bus_name'];?></p>
<p style="margin-left: 56px;">: <?php if(isset($user['city'])) echo $user['city'];  if(isset($user['pin'])) echo ' - '.$user['pin']; ?></p>
<p style="margin-left: 56px;">: <?php if(isset($user['state'])) echo $user['state'];?></p>
<p style="margin-left: 56px;"> <?php if(isset($user['mob_no'])) echo "Ph No. : ".$user['mob_no'];?></p>
</td>

<td style = "width:34%;">
<p ><span style= "font-weight:bold;">Invoice No.</span> : <?php  if(isset($data['ext_id'])) echo $data['ext_id'];?></p>
<p style="margin-left: 85px;">: </p>
<p ><span style= "font-weight:bold;">Reference</span> <span style = "margin-left:12px;">:</span> <?php if(isset($data['ext_no'])) echo $data['ext_no'];?> </p>
<p style="margin-left: 85px;">: </p>
</td>
<td style = "width:24%;">
<p ><span style= "font-weight:bold;">Date</span> <span style = "margin-left:10px;">:</span> <?php echo date('d/m/Y');?></p>
<p style="margin-left: 46px;">: </p>
<p><span style= "font-weight:bold;">Page</span> <span style = "margin-left:10px;">:</span> 1</p>
<p style="margin-left: 46px;">: </p>
</td>
</tr>
</table>
</center>
<span>==============================================================================</span>

<table style="font-weight:bold;width:100%;"><tr >
<td style="width:5%;padding-top:7px;">Sr.</td>
<td style="width:2%;padding-top:7px;">|</td>
<td style="width:70%;padding-top:7px;">Account Description / Narration</td>
<td style="width:2%;padding-top:7px;">|</td>
<td style="width:20%;padding-top:7px;">Total Amount</td>
</tr></table>
<p>-------------------------------------------------------------------------------</p>
<div >
<?php $val1 = 3; ?>
<table style="width:100%;padding-bottom:5px;">
<tr >
<td style="width:5%;">&nbsp;</td>
<td style="width:2%;">|</td>
<td style="width:70%;">Extension Visa Application</td>
<td style="width:2%;">|</td>
<td style="width:20%;">&nbsp;</td>
</tr>
<?php if(isset($data) && count($data) > 0){ ?>
<tr >
<td style="width:5%;padding-top:7px;">1. </td>
<td style="width:2%;padding-top:7px;">|</td>
<td style="width:70%;padding-top:7px;"><?php if(isset($name)){ echo $name; }else{?>&nbsp; <?php } ?></td>
<td style="width:2%;padding-top:7px;">|</td>
<td style="width:20%;padding-top:7px;text-align:right;"><?php if(isset($price)) echo $price; echo '.00';  ?></td>
</tr>
<?php }?>

<tr >
<td style="width:5%;padding-top:7px;">&nbsp;</td>
<td style="width:2%;padding-top:7px;">|</td>
<td style="width:70%;padding-top:7px;"><?php if(isset($visa)) echo '( '.$visa.' )'; else{ ?> &nbsp;<?php } ?></td>
<td style="width:2%;padding-top:7px;">|</td>
<td style="width:20%;padding-top:7px;">&nbsp;</td>
</tr>

<?php if(isset($admin) && $admin == 1){ $val1 = $val1 + 2;  ?>
<tr >
<td style="width:5%;padding-top:7px;">&nbsp;</td>
<td style="width:2%;padding-top:7px;">|</td>
<td style="width:70%;padding-top:7px;text-align:right;">ADD : SERVICE CHARGES</td>
<td style="width:2%;padding-top:7px;">|</td>
<td style="width:20%;padding-top:7px;text-align:right;""><?php if(isset($charge)){ echo $charge; }else echo '0.00 INR' ?></td>
</tr>

<tr >
<td style="width:5%;padding-top:7px;">&nbsp;</td>
<td style="width:2%;padding-top:7px;">|</td>
<td style="width:70%;padding-top:7px;text-align:right;">ADD : STX = <?php if(isset($tax)) echo $tax; else echo '00'; ?> EDU. CESS = <?php if(isset($edu)) echo $edu; else echo '00'; ?></td>
<td style="width:2%;padding-top:7px;">|</td>
<td style="width:20%;padding-top:7px;text-align:right;""><?php if(isset($tax) && isset($edu)){ echo $tax + $edu; }else echo '0.00'; ?></td>
</tr>
<?php } ?>

<?php $val = 46 - $val1; for($j = 1; $j <= $val; $j++){ ?>
<tr >
<td style="width:5%;padding-top:7px;">&nbsp;</td>
<td style="width:2%;padding-top:7px;">|</td>
<td style="width:70%;padding-top:7px;">&nbsp;</td>
<td style="width:2%;padding-top:7px;">|</td>
<td style="width:20%;padding-top:7px;">&nbsp;</td>
</tr>
<?php } ?>

</table>
</div>
<span>==============================================================================</span>
<?php if(isset($sprice)){ 
$fee =  $sprice.'.00'; 
$fee_in_words = $this->NumberToWord->convert_number_to_words($sprice);
$fee_in_words = strtoupper($fee_in_words);
} 
  ?>

<table style="width:100%;padding-top:5px;">
<tr >
<td style="width:78%;font-weight:bold;"><?php if(isset($fee_in_words) && strlen($fee_in_words) > 0){ if(isset($curr) && strlen($curr) > 0) echo $curr; else echo ' INR'; echo ' '.$fee_in_words.' ONLY';  }else echo "&nbsp;"; ?></td>
<td style="width:2%;">|</td>
<td style="width:20%;font-weight:bold;text-align:right;"><?php if(isset($fee) && strlen($fee) > 0) echo $fee; else echo 0;  ?></td>
</tr>
<tr>
<td style="width:78%;font-weight:bold;">&nbsp;</td>
<td style="width:2%;">|</td>
<td style="width:20%;font-weight:bold;">____________</td>
</tr>
</table>

<table style="width:100%;padding-bottom:8px;">
<tr >
<td style="width:70%;font-weight:bold;">E.& O.E.</td>
<td style="width:30%;">For GLOBAL VOYAGES</td>
</tr>
</table>

<div style="margin-top:10px;font-weight:bold;"><span ><u>Terms & Conditions :</u></span></div>
<table style="font-size:12px;letter-spacing:-1px;">
<tr><td style="padding-top:10px;">CASH</td><td style="padding-top:10px;">: Payment to be made to the cashier & printed Official Receipt must be obtained.</td></tr>
<tr><td style="padding-top:10px;">CHEQUE</td><td style="padding-top:10px;">: All cheques / demand drafts in payment of bills must be crossed "A/c Payee Only"</td></tr>
<tr><td style="padding-top:10px;">&nbsp;</td><td style="padding-top:10px;">: and drawn in favour of GLOBAL VOYAGES.</td></tr>
<tr><td style="padding-top:10px;">LATE PAYMENT</td><td style="padding-top:10px;">: Interest @ 24% per annum will be charged on all outstanding bills after due date.</td></tr>
<tr><td style="padding-top:10px;">VERY IMP.</td><td style="padding-top:10px;">: Kindly check all details carefully to avoid un-necessary complications.</td></tr>
</table>
</body>
</html>