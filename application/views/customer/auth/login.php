<div id="page-title" class="page-title pt-5 text-center">
    <div class="container">

        <h1 class="mb-2 letter-spacing-50 fadeInDown animated" data-animate="fadeInDown">
            Login
        </h1>


    </div>
</div>


<div id="wrapper-content" class="wrapper-content pt-8 pl-14 px-14 pl-sm-2 px-sm-2">
    <div class="container">

        <div id="submit-listing" class="section-submit-listing pb-2">
            <form method="POST" action="<?=base_url('login_req')?>">
                <div class="submit-listing-blocks mb-9 pb-6">
                    <div class="row lh-18">
                        <div class="col-md-6 ">
                            <div class="card border-0 p-0">

                                <div class="card-body px-0 pt-6">

                                <?php $this->load->view('Templates/flash'); ?>
                                    <div class="form-group mb-4">
                                        <label for="phone" class="font-weight-semibold font-size-md mb-2 lh-15">Mobile Number</label>
                                        <input type="text" id="phone" name="phone"  value="<?=set_value('phone')?>" class="form-control" placeholder="9889898987" required>

                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="phone" class="font-weight-semibold font-size-md mb-2 lh-15">Password</label>
                                        <input type="text" id="phone" name="password"  value="<?=set_value('password')?>" class="form-control" placeholder="******">
                                        <!-- <p class="font-size-sm pt-2">We will send you a verification code to confirm<br> this number. </p> -->
                                    </div>

                                    <div class="form-group mb-4">
                                        <input type="submit" class="btn btn-block btn-outline-primary" ><a href="<?=base_url()?>register">Signup</a>
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