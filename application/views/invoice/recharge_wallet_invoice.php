<!DOCTYPE html>
<html>
   <head>
   </head>
   <body>
      <table style="width: 100%" align="center">
         <tr align="center">
            <td><img src="https://astrohelp24.com/assets/img/logo.png" width="90"></td>
         </tr>
      </table>
      <table style="width: 100%; background-color: #ffd00d;" align="center">
         <tr align="center">
            <td style="color: #fff"> Wallet Recharge Invoice</td>
         </tr>
      </table>
      <table style="width: 100%; vertical-align: top;">
         <tr>
            <td style="width: 30%; vertical-align: top;">
               <p style="color: #828282; font-size: 10px;">Sold By:</p>
               <p style="font-size: 10px; color:#000;">Astrohelp24 Pvt. Ltd.</p>
               <span style="font-size: 10px;">173 /1 Ground Floor,</span>
               <span style="font-size: 10px;">  A-Block, Ashoke Vihar,</span>
               <span style="font-size: 10px;">Phase 1,Delhi 110052</span><br><br>
               <span style="font-size: 10px;"><span style="color: #828282;">PAN:</span>ABUFA2435Q</span><br>
               <span style="font-size: 10px;"><span style="color: #828282;">GST Registration No:</span> 07ABUFA2435Q1ZS</span>
            </td>
            <td align="right" style="width: 70%;">
               <span style="font-size: 10px; color: #828282;">Customer Address:</span><br>
               <span style="font-size: 10px;">Name: <?=$name?></span><br><br>
                <?php
               if ($address) 
                { ?>
               <span style="font-size: 10px;">Address: <?=$address?></span><br>
               <?php }
               ?>

               <?php
               if ($city) 
                { ?>
               <span style="font-size: 10px;">City: <?=$city?></span><br>
               <?php }
               ?>
               <?php
               if (!empty($state)) 
                { ?>
               <span style="font-size: 10px;">State: <?=$state?></span><br>
               <?php }
               ?>
               <?php
               if ($country) 
                { ?>
               <span style="font-size: 10px;">country: <?=$country?></span><br>
               <?php }
               ?>

            </td>
         </tr>
      </table>
      <table style="width: 100%; background-color: #f6f6f6;" cellpadding="5">
         <tr>
            <td style="width: 49%;">
               <span style="font-size: 10px;"><span style="color: #828282;">Recharge Number:</span> <?=$rechargeID?></span><br>
               <span style="font-size: 10px;"><span style="color: #828282;">Recharge Date:</span> <?=$recharge_date?></span><br>
             <!--   <span style="font-size: 10px;"><?=$schedule_time?></span> -->
            </td>
            <td align="right" style="width: 49%;">
               <span style="font-size: 10px;"><span style="color: #828282;">Recharge Invoice Number:</span> <?=$rechargeID?></span><br>
               <span style="font-size: 10px;"><span style="color: #828282;">Invoice Date:</span> <?=date('d/m/Y')?></span><br>
               <span style="font-size: 10px;"><?=date("h:i:s")?></span>
            </td>
         </tr>
      </table>
      <table style="width: 100%;">
         <tr>
            <td height="5"></td>
         </tr>
      </table>

<table style="width:100%; border-collapse: collapse; border: 1px solid #000;" border="1" cellpadding="8">
         <tr align="left">
            <th width="40" style="background-color: #ffd00d; color: #fff; font-size: 10px; text-align: center;">SI.</th>
            <th width="280" style="background-color: #ffd00d; color: #fff; font-size: 10px; text-align: center;">Transaction Name</th>
            <th width="100" style="background-color: #ffd00d; color: #fff; font-size: 10px; text-align: center;">Total Payable</th>
            <th width="100" style="background-color: #ffd00d; color: #fff; font-size: 10px; text-align: center;">GST</th>
            <th width="100" style="background-color: #ffd00d; color: #fff; font-size: 10px; text-align: center;">GST Amount</th>
             
         </tr>


         <tr>
            <td>
               <strong style="text-align: center; font-size: 10px;"><?php echo 1;?></strong>
            </td>
            <td style="font-size: 10px;"><?php echo $txn_name;?></td>
            <td style="font-size: 10px;"><?php echo round($txn_amount);?></td>
            <td style="font-size: 10px;"><?php echo round($gst_perct);?></td>
            <td style="font-size: 10px;"><?php echo round($gst_amount);?></td>

         </tr>
         


     
         <tr>
            <td colspan="4">
               <strong>Available Wallet Balance </strong>
            </td>
            <td style="text-align: center; font-size: 12px;"><strong>₹ <?php echo  round($available_wallet); ?></strong></td>
         </tr>
      </table>

<table style="width: 100%;">
         <tr>
            <td>
               <span style="font-size: 10px;">
               <span style="color: #828282;">Amount in words:</span> 


                  <?php

                    $no = round($available_wallet);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            '0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety'
        );
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] .
                    " " . $digits[$counter] . $plural . " " . $hundred
                    :
                    $words[floor($number / 10) * 10]
                    . " " . $words[$number % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
            } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ?
            "." . $words[$point / 10] . " " .
            $words[$point = $point % 10] : '';
        // return $result . "Rupees  " . $points . " Paise";
        echo ucwords($result . "Rupees Only");
         
                 // echo $this->global_config->indian_rupees_in_words(round($available_wallet));

                
                
                  ?>


               </span>
            </td>
         </tr>
      </table>
 
   </body>
</html>