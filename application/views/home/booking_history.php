
         <!-- Breadcrumb -->
         <div class="breadcrumb-bar">
            <div class="container-fluid">
               <div class="row align-items-center">
                  <div class="col-md-12 col-12">
                     <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                           <li class="breadcrumb-item active" aria-current="page">My Account</li>
                        </ol>
                     </nav>
                     <h2 class="breadcrumb-title">Booking History</h2>
                  </div>
               </div>
            </div>
         </div>
         <!-- /Breadcrumb -->
        <!-- Page Content -->
         <div class="content">
            <div class="container-fluid">

               <div class="row">
                  
                  <!-- Profile Sidebar -->
                  <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                     <div class="profile-sidebar">
                           <?php $this->load->view('Templates/sidebarwidget'); ?>

                     </div>
                  </div>
                  <!-- /Profile Sidebar -->
                  
                  <div class="col-md-7 col-lg-8 col-xl-9">
                     <div class="card">
                        <div class="card-body pt-0">
                        
                           <!-- Tab Menu -->
                           <nav class="user-tabs mb-4">
                              <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                                 <li class="nav-item">
                                    <a class="nav-link active" href="#pat_appointments" data-toggle="tab">Chat History</a>
                                 </li>

                                 <li class="nav-item">
                                    <a class="nav-link" href="#pat_medical_records" data-toggle="tab"><span class="med-records">Reports</span></a>
                                 </li>

                              <!--    <li class="nav-item">
                                    <a class="nav-link" href="#pat_prescriptions" data-toggle="tab">Call History</a>
                                 </li>
                                  -->
                                 <!-- <li class="nav-item">
                                    <a class="nav-link" href="#pat_billing" data-toggle="tab">Billing</a>
                                 </li> -->
                              </ul>
                           </nav>
                           <!-- /Tab Menu -->
                           
                           <!-- Tab Content -->
                           <div class="tab-content pt-0">
                     <!-- chat Tab -->
                     <div id="pat_appointments" class="tab-pane fade show active">
                        <div class="card card-table mb-0">
                           <div class="card-body">
                              <div class="table-responsive">
                                 <table class="table table-hover table-center mb-0">
                                    <thead>
                                       <tr>
                                          <th>Booking Id</th>
                                          <th>Astrologer</th>
                                          <th>Date & Time</th>
                                          <th>Duration</th>
                                          <th>Status</th>
                                          <th>Amount</th>
                                       </tr>
                                    </thead>
                                    <?php $booking_history = $this->db->get_where("bookings",array("user_id"=>$user_details->id,"type"=>3))->result(); ?>
                                    <tbody>
                                       <?php if (count($booking_history) > 0): ?>
                                          <?php $i=1; foreach ($booking_history as $key): 
                                             $duration = '';
                                             $booking_status = '';
                                             if ($key->status == 0) 
                                             {
                                                $complete_power = 1;
                                                $booking_status = 'pending';
                                             }
                                             elseif ($key->status == 2) 
                                             {
                                                $accept_power = 0;
                                                $complete_power = 0;
                                                $cancel_power = 0;
                                                $booking_status = 'confirm';
                                             }
                                             elseif ($key->status == 3 || $key->status == 5) 
                                             {
                                                $booking_status = 'cancel';
                                                $accept_power = 0;
                                                $complete_power = 0;
                                                $cancel_power = 0;

                                             }
                                             elseif ($key->status == 2)
                                             {
                                                $booking_status = 'completed';
                                                $accept_power = 0;
                                                $complete_power = 0;
                                                $cancel_power = 0;
                                             }
                                             $get_astro = $this->db->get_where("astrologers",array("id"=>$key->assign_id))->row();
                                             $specialty = '';
                                             $astrid = $get_astro->id;
                                             $get_specialty = $this->db->get_where("skills",array("user_id"=>$astrid,"type"=>1))->result();
                                             if (count($get_specialty)) 
                                             {
                                                $a = array();
                                                foreach ($get_specialty as $keys) 
                                                {
                                                   $get_name = $this->db->get_where("master_specialization",array("id"=>$keys->speciality_id))->row();
                                                   if ($get_name) 
                                                   {
                                                      array_push($a, ucfirst($get_name->name));
                                                      // $skills[] = array("skill_id"=>$keys->speciality_id,
                                                                 // "skill_name"=>$get_name->name);
                                                   }
                                                }

                                                if (!empty($a)) 
                                                {
                                                   $specialty = implode(', ', $a);
                                                }
                                             }
                                          ?>
                                             <tr>
                                                <td>#<?=$i?></td>
                                                <td>
                                                   <h2 class="table-avatar">
                                                      <a href="<?=base_url('home/astrologer_profile/'.$get_astro->id)?>" class="avatar avatar-sm mr-2">
                                                      <img class="avatar-img rounded-circle" src="<?= BASE_URL_IMAGE.'astrologers/'.$get_astro->image ?>" alt="User Image">
                                                      </a>
                                                      <a href="#"><?=$get_astro->name?> <span><?=$specialty = '';
                                             ?></span></a>
                                                   </h2>
                                                </td>
                                                <td><?=date('d M Y', strtotime($key->schedule_date_time))?> <span class="d-block text-info"><?=date('h:i a', strtotime($key->schedule_date_time))?></span></td>
                                                <td><?=$duration?></td>
                                                <td><?=$booking_status?></td>
                                                <td>₹ <?=$key->payable_amount?></td>
                                             </tr>
                                          <?php $i++;endforeach ?>
                                       <?php endif ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- /chat Tab -->
                     <!-- call Tab -->
                     <div class="tab-pane fade" id="pat_prescriptions">
                        <div class="card card-table mb-0">
                           <div class="card-body">
                              <div class="table-responsive">
                                 <table class="table table-hover table-center mb-0">
                                    <thead>
                                       <tr>
                                          <th>Booking Id</th>
                                          <th>Astrologer</th>
                                          <th>Date & Time</th>
                                          <th>Duration</th>
                                          <th>Amount</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td>#12345</td>
                                          <td>
                                             <h2 class="table-avatar">
                                                <a href="#" class="avatar avatar-sm mr-2">
                                                <img class="avatar-img rounded-circle" src="<?php echo base_url();?>assets/img/astro-profile.png" alt="User Image">
                                                </a>
                                                <a href="#">Vipul Pandey <span>Vedic Astrology</span></a>
                                             </h2>
                                          </td>
                                          <td>14 Nov 2019 <span class="d-block text-info">10:00 AM</span></td>
                                          <td>15 Min</td>
                                          <td>₹ 160</td>
                                       </tr>
                                       <tr>
                                          <td>#12345</td>
                                          <td>
                                             <h2 class="table-avatar">
                                                <a href="#" class="avatar avatar-sm mr-2">
                                                <img class="avatar-img rounded-circle" src="<?php echo base_url();?>assets/img/astro-profile.png" alt="User Image">
                                                </a>
                                                <a href="#">Vipul Pandey <span>Vedic Astrology</span></a>
                                             </h2>
                                          </td>
                                          <td>14 Nov 2019 <span class="d-block text-info">10:00 AM</span></td>
                                          <td>15 Min</td>
                                          <td>₹ 160</td>
                                       </tr>
                                       <tr>
                                          <td>#12345</td>
                                          <td>
                                             <h2 class="table-avatar">
                                                <a href="#" class="avatar avatar-sm mr-2">
                                                <img class="avatar-img rounded-circle" src="<?php echo base_url();?>assets/img/astro-profile.png" alt="User Image">
                                                </a>
                                                <a href="#">Vipul Pandey <span>Vedic Astrology</span></a>
                                             </h2>
                                          </td>
                                          <td>14 Nov 2019 <span class="d-block text-info">10:00 AM</span></td>
                                          <td>15 Min</td>
                                          <td>₹ 160</td>
                                       </tr>
                                       <tr>
                                          <td>#12345</td>
                                          <td>
                                             <h2 class="table-avatar">
                                                <a href="#" class="avatar avatar-sm mr-2">
                                                <img class="avatar-img rounded-circle" src="<?php echo base_url();?>assets/img/astro-profile.png" alt="User Image">
                                                </a>
                                                <a href="#">Vipul Pandey <span>Vedic Astrology</span></a>
                                             </h2>
                                          </td>
                                          <td>14 Nov 2019 <span class="d-block text-info">10:00 AM</span></td>
                                          <td>15 Min</td>
                                          <td>₹ 160</td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- /call Tab -->
                     <!-- report Tab -->
                     <div id="pat_medical_records" class="tab-pane fade">
                        <div class="card card-table mb-0">
                           <div class="card-body">
                              <div class="table-responsive">
                                 <table class="table table-hover table-center mb-0">
                                    <thead>
                                       <tr>
                                          <th>ID</th>
                                          <th>Date & Time </th>
                                          <th>Status</th>
                                          <th>Description</th>
                                          <th>Amount</th>
                                          <th></th>
                                       </tr>
                                    </thead>
                                    <?php $booking_history_report = $this->db->get_where("bookings",array("user_id"=>$user_details->id,"type"=>4))->result(); 

                                    // echo "<pre>";
                                    // print_r($booking_history_report); 
                                    ?>
                                    <tbody>
                                       <?php if (count($booking_history_report) > 0): ?>
                                          <?php $ix=1; foreach ($booking_history_report as $ke): 
                                             $duration = '';
                                             $booking_status = '';
                                             if ($ke->status == 0) 
                                             {
                                                $complete_power = 1;
                                                $booking_status = 'pending';
                                             }
                                           
                                             elseif ($ke->status == 3 || $ke->status == 5) 
                                             {
                                                $booking_status = 'cancel';
                                             }
                                             elseif ($ke->status == 2)
                                             {
                                                $booking_status = 'completed';
                                             }
                                             $get_astro = $this->db->get_where("astrologers",array("id"=>$ke->assign_id))->row();
                                             $specialty = '';
                                             $astrid = $get_astro->id;
                                             $get_specialty = $this->db->get_where("skills",array("user_id"=>$astrid,"type"=>1))->result();
                                             if (count($get_specialty)) 
                                             {
                                                $a = array();
                                                foreach ($get_specialty as $keys) 
                                                {
                                                   $get_name = $this->db->get_where("master_specialization",array("id"=>$keys->speciality_id))->row();
                                                   if ($get_name) 
                                                   {
                                                      array_push($a, ucfirst($get_name->name));
                                                      // $skills[] = array("skill_id"=>$keys->speciality_id,
                                                                 // "skill_name"=>$get_name->name);
                                                   }
                                                }

                                                if (!empty($a)) 
                                                {
                                                   $specialty = implode(', ', $a);
                                                }
                                             }
                                          ?>
                                       <tr>
                                          <td>#<?=$ix?></td>

                                           <td><?=date('d M Y', strtotime($ke->created_at))?> <span class="d-block text-info"><?=date('h:i a', strtotime($ke->created_at))?></span></td>
                                         

                                         
                                          <td> <?=$booking_status ?></td>
                                          <td> <?=$ke->horoscope_name ?></td>
                                          <td>₹ <?=$ke->subtotal ?></td>
                                          <td class="text-right">
                                             <div class="table-action">
                                                <a href="<?php echo base_url("") ?>" class="btn btn-sm bg-info-light">
                                                <i class="far fa-eye"></i> View
                                                </a>
                                             </div>
                                          </td>
                                       </tr>
                                     <?php $i++;endforeach ?>
                                    <?php endif ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- /Medical Records Tab -->
                  </div>
                           <!-- Tab Content -->
                           
                        </div>
                     </div>
                  </div>
               </div>

            </div>

         </div>      
         <!-- /Page Content -->
