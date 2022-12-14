<div id="page-title" class="page-title pt-5 text-center">
    <div class="container">

        <h1 class="mb-2 letter-spacing-50 fadeInDown animated" data-animate="fadeInDown">
            Sign Up
        </h1>


    </div>
</div>

<div id="wrapper-content" class="wrapper-content pt-8 pl-14 px-14 pl-sm-2 px-sm-2">
    <div class="container">
        <div id="submit-listing" class="section-submit-listing pb-2">
            <form method="POST" action="<?=base_url('customer_register_req')?>" >
                <div class="submit-listing-blocks mb-9 pb-6">
                    <div class="row lh-18">
                        <div class="col-md-6 ">
                            <div class="card border-0 p-0">

                                <div class="card-body px-0 pt-6">
                                <?php $this->load->view('Templates/flash'); ?>


                                    <div class="form-group mb-4">
                                        <label for="phone" class="font-weight-semibold font-size-md mb-2 lh-15">Mobile Number</label>
                                        <input type="text" id="phone" name="phone" class="form-control" placeholder="9889898987"  />
                                    </div>

                                    <div class="form-group mb-4">
                                        <!-- <a class="btn btn-block btn-outline-primary" title="Accent Button" href="otp.html">Continue</a> -->
                                        <input type="submit" class="btn btn-block btn-outline-primary" value="Continue" /><a href="<?=base_url()?>login">Login</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 p-0 background-transparent">

                                <div class="card-body px-0 pt-6">


                                    <p>Or&nbsp;<img src="<?=base_url()?>assets/images/line.png"></p>

                                    <div class="form-group mb-4">
                                        <div class="mb-1 mt-3">

                                            <a class="btn btn-block btn-outline-google" title="Secondary Button" href="#">
                                                <span class="float-left"><i class="fab fa-google"></i></span>Connect Google</a>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <div class="mb-1 mt-3">

                                            <a class="btn btn-block btn-outline-facebook" title="Secondary Button" href="#">
                                                <span class="float-left"><i class="fab fa-facebook"></i></span>Connect Facebook</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>