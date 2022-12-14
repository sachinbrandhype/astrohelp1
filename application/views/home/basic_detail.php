
         <!-- Breadcrumb -->
         <div class="breadcrumb-bar">
            <div class="container-fluid">
               <div class="row align-items-center">
                  <div class="col-md-12 col-12">
                     <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                           <li class="breadcrumb-item active" aria-current="page">Basic Detail</li>
                        </ol>
                     </nav>
                     <h2 class="breadcrumb-title">Basic Detail</h2>
                  </div>
               </div>
            </div>
         </div>
         <!-- /Breadcrumb -->
        <!-- Page Content -->
         <div class="content">
            <div class="container-fluid">

               <div class="row">
                  
               
                  
                  <div class="col-md-12 col-lg-12 col-xl-12">

                           <?php 
                           $datass = json_decode($basic_detail);      
                           // print_r($datass); die;                            
                           ?>


<div class="card card-table mb-10">
                                    <div class="card-body">
                                       <div class="table-responsive">
                                          <table class="table table-hover table-striped  table-center table-strip mb-0">
                                          

                                          

                                             <tbody>
                                                <tr>
                                                  
                                                   <td><strong>Uname</strong></td>
                                                   <td><?php echo $datass->uname;?></td>
                                                  
                                                </tr>
                                     
                                                <tr>
                                                  
                                                   <td><strong>Name</strong></td>
                                                   <td><?php echo $datass->name;?></td>
                                                  
                                                </tr>
<tr>
                                                  
                                                   <td><strong>Ayanamsha</strong></td>
                                                  <td><?php echo $datass->ayanamsha;?></td>
                                                  
                                                </tr>
                                                <tr>
                                                  
                                                   <td><strong>Sunrise</strong></td>
                                                    <td><?php echo $datass->sunrise;?></td>
                                                  
                                                </tr>
                                             

                                                 

                                               
                                               
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

    