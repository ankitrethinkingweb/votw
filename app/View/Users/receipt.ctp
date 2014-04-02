<html><head><style type="text/css">
<!--
.style1 {font-size: 24px}
-->
</style>


</head><body>
<div id = 'receipt'>
<table width="562" border="0">
  <tbody><tr>
    <td width="556"><table width="98%" border="0" align="center">
  <tbody><tr>
    <td height="74" colspan="3"><div class="style1">
      <div align="center">Global Voyages, Online Visa Applications</div>
      <hr>
    </div></td>
  </tr>
  <tr>
    <td width="47%"><span class="style1">
      <label>Group No.</label>
    </span></td>
    <td width="3%"><div align="center" class="style1">:</div></td>
    <td width="50%" class="style1"><span class="style1"><?php if(isset($data['visa_tbl']['group_no']) and strlen($data['visa_tbl']['group_no']) > 0) echo $data['visa_tbl']['group_no'];else echo 'Not Mentioned';?></span></td>
  </tr>
  <tr>
    <td><span class="style1">
      <label>Application Received by </label>
    </span></td>
    <td><div align="center" class="style1">:</div></td>
    <td class="style1"><span class="style1">Global Voyages</span></td>
  </tr>
  <tr>
    <td><span class="style1">
      <label>Receipt Printed</label>
    </span></td>
    <td><div align="center" class="style1">:</div></td>
    <td class="style1"><span class="style1"><?php echo date('d-m-Y h:i:s A');?></span></td>
  </tr>
  <tr>
    <td><span class="style1">
      <label>Application Date</label>
    </span></td>
    <td><div align="center" class="style1">:</div></td>
    <td class="style1"><span class="style1"><?php if(isset($data['visa_tbl']['create_date']) and strlen($data['visa_tbl']['create_date']) > 0) echo $data['visa_tbl']['create_date'];else echo 'Not Mentioned';?></span></td>
  </tr>
  <tr>
    <td><span class="style1">
      <label>Applicant Name</label>
    </span></td>
    <td><div align="center" class="style1">:</div></td>
    <td class="style1"><span class="style1"><?php if(isset($data['visa_tbl']['app_name']) and strlen($data['visa_tbl']['app_name']) > 0) echo $data['visa_tbl']['app_name'];else echo 'Not Mentioned';?></span></td>
  </tr>
  <tr>
    <td><span class="style1">
      <label>Passport No</label>
    </span></td>
    <td><div align="center" class="style1">:</div></td>
    <td class="style1"><span class="style1"><?php if(isset($data['visa_tbl']['passport_no']) and strlen($data['visa_tbl']['passport_no']) > 0) echo $data['visa_tbl']['passport_no'];else echo 'Not Mentioned';?></span></td>
  </tr>
  <tr>
    <td><span class="style1">
      <label>No. of Applications</label>
    </span></td>
    <td><div align="center" class="style1">:</div></td>
    <td><span class="style1"><?php if(isset($data['visa_tbl']['adult']) and isset($data['visa_tbl']['children']) and isset($data['visa_tbl']['infants'])) echo $data['visa_tbl']['adult'] + $data['visa_tbl']['children'] + $data['visa_tbl']['infants'];else echo 0;?></span></td>
  </tr>
  <tr>
    <td><span class="style1">
      <label>Visa Type</label>
    </span></td>
    <td><div align="center" class="style1">:</div></td>
    <td class="style1"><span class="style1"><?php if(isset($data['visa_tbl']['visa_type']) and strlen($data['visa_tbl']['visa_type']) > 0) echo $data['visa_tbl']['visa_type'];else echo 'Not Mentioned';?></span></td>
  </tr>
  <tr>
    <td><span class="style1">
      <label>Tentative Date</label>
    </span></td>
    <td><div align="center" class="style1">:</div></td>
    <td class="style1"><span class="style1"><?php if(isset($data['visa_tbl']['tent_date']) and strlen($data['visa_tbl']['tent_date']) > 0) echo date('d-m-Y',strtotime($data['visa_tbl']['tent_date']));else echo 'Not Mentioned';?></span></td>
  </tr>
  <tr>
    <td><span class="style1">
      <label>Destination</label>
    </span></td>
    <td><div align="center" class="style1">:</div></td>
    <td class="style1"><span class="style1"><?php if(isset($data['visa_tbl']['destination']) and strlen($data['visa_tbl']['destination']) > 0) echo $data['visa_tbl']['destination'];else echo 'Not Mentioned';?></span></td>
  </tr>
  <tr>
    <td><span class="style1">
      <label>No. Of Travellers</label>
    </span></td>
    <td><div align="center" class="style1">:</div></td>
    <td class="style1"><span class="style1"><?php if(isset($data['visa_tbl']['adult']) and isset($data['visa_tbl']['children']) and isset($data['visa_tbl']['infants'])) echo 'Adult(s) : '.$data['visa_tbl']['adult'].'<br/>Children(s) : '.$data['visa_tbl']['children'].'<br/>Infants : '.$data['visa_tbl']['infants']; else echo 'Not Mentioned';?></span></td>
  </tr>
 
  <tr>
    <td colspan="3"><br>
<p class="style1">Disclaimer: </p>
      <ul class="style1">
		<li>The decision to accept or refuse visa is the sole prerogative of the govt of Dubai. Global Voyages Visa Application centre does not in anyway influence the same.</li>
    </ul>      <h2 align="center" class="style1">Thank You </h2></td>
  </tr>
  
</tbody></table></td>
  </tr>
</tbody></table>
</div>
</body>
<input type="button" value="Print" onclick="printpage()">
</html>

<script>
function printpage()
  {
  var printContents = document.getElementById('receipt').innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
  }
</script>