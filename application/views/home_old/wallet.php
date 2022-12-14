<!-- /Header -->
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
   <div class="container-fluid">
      <div class="row align-items-center">
         <div class="col-md-8 col-12">
            <nav aria-label="breadcrumb" class="page-breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>home/index">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Wallet</li>
               </ol>
            </nav>
            <h2 class="breadcrumb-title">Wallet</h2>
         </div>
      </div>
   </div>
</div>
<!-- /Breadcrumb -->
<!-- Page Content -->
<div class="content">
   <div class="container">
      <div class="row">
         <div class="col-md-12 col-lg-12">
            <div class="card">
               <div class="card-body text-center">
                  <img src="<?php echo base_url();?>assets/img/wallet.png" alt="User Image" width="100" class="mb-3">
                  <h4>Available Wallet Balance</h4>
                  <h2><Strong>₹ <?=$user_details->wallet?></Strong></h2>
                  <div class="submit-section mt-4">
                     <a href="<?php echo base_url();?>home/recharge_wallet" class="btn btn-primary submit-btn">Add Money to wallet</a>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-12 col-lg-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">Wallet Summary</h4>
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table class="table table-hover  table-striped-1 table-center mb-0">
                        <thead style="background-color: #f7f7f7;">
                           <tr>
                              <th>#</th>
                              <th>Txn ID</th>
                              <th>Date & Time </th>
                              <th>Description</th>
                              <th>Amount</th>
                           </tr>
                        </thead>
                        <?php $trxnlist = $this->db->order_by('created_at','DESC')->get_where("transactions",array("user_id"=>$user_details->id))->result();
                       ?>
                        <tbody>
                          <?php if (count($trxnlist) > 0): ?>
                            <?php $i=1; foreach ($trxnlist as $key):
                              $for = '';
                              if ($key->booking_id > 0) 
                              {
                                  $get_booking_details = $this->db->get_where("bookings",array("id"=>$key->booking_id))->row();
                                  if ($get_booking_details) 
                                  {
                                      if ($get_booking_details->type == '1') 
                                      {
                                          $for = 'Video Call';
                                      }
                                      elseif ($get_booking_details->type == '2') 
                                      {
                                          $for = 'Audio Call';
                                      }
                                      elseif ($get_booking_details->type == '3') 
                                      {
                                          $for = 'Chat';
                                      }
                                      elseif ($get_booking_details->type == '4') 
                                      {
                                          $for = 'Report';
                                      }
                                  }
                              }
                              elseif ($key->txn_for == 'wallet') 
                              {
                                  if ($key->type == 'credit') 
                                  {
                                      $for = 'Add Wallet';
                                  }
                              }

                             ?>
                               <tr>
                                <td><?=$i?>.</td>
                                <td><?=$key->booking_txn_id?></td>
                                <td><?=date('d M Y', strtotime($key->created_at))?> | <?=date('h:i a', strtotime($key->created_at))?></td>
                                <td><?=$for?></td>
                                <td>₹ <?=$key->txn_amount?></td>
                             </tr>
                            <?php $i++; endforeach ?>
                          <?php endif ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- /Page Content -->
<!-- Footer -->