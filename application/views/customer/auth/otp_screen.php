<div id="page-title" class="page-title pt-5 text-center">
    <div class="container">

        <h1 class="mb-2 letter-spacing-50 fadeInDown animated" data-animate="fadeInDown">
            OTP
        </h1>
        <p class="pt-6 fadeInDown animated" data-animate="fadeInDown">Please enter the PIN you received</p>

    </div>
</div>

<div id="wrapper-content" class="wrapper-content pt-8 pl-14 px-14 pl-sm-2 px-sm-2">
    <div class="container">

        <div id="submit-listing" class="section-submit-listing pb-2">
            <form action="<?=base_url('verify_otp_req')?>" method="POST">
                <div class="submit-listing-blocks mb-9 pb-6">
                    <div class="row lh-18">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="card border-0 p-0">

                                <div class="card-body px-0 pt-6">
                                <?php $this->load->view('Templates/flash'); ?>

                                    <div class="row">
                                        <div class="form-group mb-4 col-md-3">

                                            <input type="text" name="one" id="phone" class="form-control text-center" maxlength="1" required>

                                        </div>
                                        <div class="form-group mb-4 col-md-3">

                                            <input type="text" name="two" id="phone" class="form-control text-center" maxlength="1" required>

                                        </div>
                                        <div class="form-group mb-4 col-md-3">

                                            <input type="text" name="three" id="phone" class="form-control text-center" maxlength="1" required>

                                        </div>
                                        <div class="form-group mb-4 col-md-3">

                                            <input type="text" name="four" id="phone" class="form-control text-center" maxlength="1" required>

                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <!-- <a class="btn btn-block btn-outline-primary" title="Accent Button" href="signup.html">Continue</a> -->
                                        <input type="submit" value="Continue" class="btn btn-block btn-outline-primary" >
                                        <a href="<?=base_url().'register'?>"><span class="font-size-sm pt-1"><i class="fal fa-chevron-left"></i> RETURN</span></a>
                                        <a href="<?=base_url().'register_resend/'.$phone?>"><span class="font-size-sm pt-1 float-right text-decoration-underline">RESEND PIN</span><a>
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