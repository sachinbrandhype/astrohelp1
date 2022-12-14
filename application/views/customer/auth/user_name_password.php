<div id="page-title" class="page-title pt-5 text-center">
    <div class="container">

        <h1 class="mb-2 letter-spacing-50 fadeInDown animated" data-animate="fadeInDown">
            Your Password
        </h1>
        <p class="pt-6 fadeInDown animated" data-animate="fadeInDown">Please enter your password</p>

    </div>
</div>

<div id="wrapper-content" class="wrapper-content pt-8 pl-14 px-14 pl-sm-2 px-sm-2">
    <div class="container">

        <div id="submit-listing" class="section-submit-listing pb-2">
            <form method="POST">
                <div class="submit-listing-blocks mb-9 pb-6">
                    <div class="row lh-18">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="card border-0 p-0">

                                <div class="card-body px-0 pt-6">
                                <?php $this->load->view('Templates/flash'); ?>

                                    <!-- <div class="row"> -->
                                        
                                        <div class="form-group mb-4">
                                            <label for="phone" class="font-weight-semibold font-size-md mb-2 lh-15">Name</label>
                                            <input type="text" id="name" name="name" class="form-control" placeholder="Your Name"  />
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="phone" class="font-weight-semibold font-size-md mb-2 lh-15">Password</label>
                                            <input type="password"  name="password" class="form-control" placeholder="Password"  />
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="phone" class="font-weight-semibold font-size-md mb-2 lh-15">Confirm Password</label>
                                            <input type="password"  name="confirm_password" class="form-control" placeholder="Confirm Password"  />
                                        </div>
                                    <!-- </div> -->

                                    <div class="form-group mb-4">
                                        <!-- <a class="btn btn-block btn-outline-primary" title="Accent Button" href="signup.html">Continue</a> -->
                                        <input type="submit" value="Save" class="btn btn-block btn-outline-primary" >
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