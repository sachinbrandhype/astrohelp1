<!-- right popup -->
<!-- Modal -->
<?php  

$totalreview = $pujadata->totalreview;
$reviews = $pujadata->reviews;
$pujalocation = $pujadata->pujalocation;
$pujadetails=$pujadata->pujadetails;

?>
<div class="modal fade" id="select-date-time" style="z-index: 9999;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header primary-text-bgcolor">
                <h5 class="modal-title text-white" id="exampleModalLabel">Booking Puja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="row">
                    <div class="col-md-5">
                        <h5 class="mb-0 primary-text-color font-size-lg pt-3">Choose Date</h5>
                    </div>
                    <div class="col-md-7">
                        <div class="mt-3 card rounded-0 border-0 bg-transparent">
                            <div class="datepicker-style-03" data-datepicker="true" data-picker-option='{"inline":true,"language":"my-lang"}'></div>
                        </div>
                    </div>
                </div>
                <hr class="mt-3">
                <div class="row">
                    <div class="col-md-5">
                        <h5 class="mb-0 primary-text-color font-size-lg pt-3">Choose Time</h5>
                    </div>
                    <div class="col-md-7">
                        <p class="pt-3 font-weight-semibold">Morning</p>
                        <div class="d-flex flex-wrap">
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                        </div>
                        <p class="pt-3 font-weight-semibold">Evening</p>
                        <div class="d-flex flex-wrap">
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                            <button type="button" class="btn btn-sm mb-1 btn-outline-secondary mr-2">
                                6.00 AM</button>
                        </div>

                    </div>
                </div>


            </div>

            <div class="modal-footer d-flex">
                <p class="primary-text-color font-size-lg font-weight-semibold">₹ 1000</p>
                <button type="button" data-dismiss="modal" data-toggle="modal" data-target="#confirm-pay" class="btn btn-primary text-uppercase ml-auto">Book Now</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->
<!-- Modal -->
<div class="modal fade" id="confirm-pay" style="z-index: 9999;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header primary-text-bgcolor">
                <h5 class="modal-title text-white" id="exampleModalLabel">Confirm & Pay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="primary-text-color pb-3">Your Puja</h4>

                <div class="d-flex">
                    <h5>Date & Time</h5>

                    <a class="ml-auto text-decoration-underline">Edit</a>
                </div>
                <p>18-Dec-2020, 11.00 AM</p>

                <div class="d-flex">
                    <h5>Host</h5>

                    <a class="ml-auto text-decoration-underline">Edit</a>
                </div>

                <p class="heading-width-1 mb-0">I am the host for this Puja.</p>
                <p class="heading-width-1 font-size-sm">Your personal details will be shared with organisers.</p>

                <div class="d-flex">
                    <h5>Guests</h5>
                    <a class="ml-auto text-decoration-underline">Edit</a>
                </div>
                <p class="heading-width-1 mb-0 font-size-sm text-decoration-underline">Add Names</p>
                <hr>
                <h4 class="primary-text-color pb-3">Notes</h4>
                <h5>For the priest</h5>
                <div class="form-group mb-0">
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <p class="text-decoration-underline font-size-sm">Add Documents</p>
                <hr>
                <h4 class="primary-text-color pb-3">Show Support</h4>
                <div class="d-flex">
                    <h5>Add a donation</h5>
                    <a class="ml-auto text-decoration-underline">Edit</a>
                </div>
                <p class="mb-0 font-size-sm">This money goes towards helping our temples serve food to the less fortunate. </p>
                <hr>
                <h4 class="primary-text-color">Price details</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-transparent d-flex text-dark px-0 pb-0 border-0">
                        <label class="mb-0">1x Kanya Bhojan Online</label>
                        <span class="ml-auto">₹1000.00</span>
                    </li>
                    <li class="list-group-item bg-transparent d-flex text-dark px-0 pb-0 border-0">
                        <label class="mb-0">Discount 10%</label>
                        <span class="ml-auto green">– ₹100.00</span>
                    </li>
                    <li class="list-group-item bg-transparent d-flex text-dark px-0 pb-0 border-0">
                        <label class="mb-0">GST 18%</label>
                        <span class="ml-auto">₹180.00</span>
                    </li>
                    <li class="list-group-item bg-transparent d-flex text-dark px-0 pb-0 border-0">
                        <label class="mb-0">Donation</label>
                        <span class="ml-auto">₹20.00</span>
                    </li>
                    <li class="list-group-item bg-transparent d-flex text-dark px-0 pb-0 border-0">
                        <label class="mb-0 font-weight-semibold ">Total</label>
                        <span class="ml-auto font-weight-semibold ">₹1100.00</span>
                    </li>


                </ul>

                <hr>
                <h4 class="primary-text-color pb-3">Payment</h4>
                <div class="d-flex">
                    <p class="text-secondary"><img src="images/master.png" class=" mr-3">⋅ ⋅ ⋅ ⋅ 2774</p>

                    <a class="ml-auto text-decoration-underline">Edit</a>
                </div>

                <p class="heading-width-1 mb-0 font-size-sm text-decoration-underline">Add a coupon</p>

            </div>
            <div class="modal-footer d-flex">
                <button type="button" data-dismiss="modal" data-toggle="modal" data-target="#confirm-pay" class="btn btn-outline-primary text-uppercase">Add to cart</button>
                <a href="pooja-success.html" class="btn btn-primary text-uppercase ml-auto">confirm & pay</a>
            </div>

        </div>
    </div>
</div>
<!-- end modal -->
<!-- right popup end-->


<div class="content-wrap">


    <section id="section-05" class="pt-5 pb-11">
        <div class="container">
            <h2 class="mb-5">
                <?=ucwords($pujadetails->name)?>
            </h2>
            <div class="row">
                <div class="col-md-12 mb-4" data-animate="zoomIn">
                    <div class="card border-0">
                        <a href="blog-single-gallery.html" class="hover-scale">
                            <img src="<?=$pujadetails->imageUrl ? $pujadetails->imageUrl : base_url().'assets/images/pooja-detail.png'?>" alt="product 1" class="card-img-top image">
                        </a>
                        <div class="image-content position-absolute m-2 d-flex align-items-center">
                            <div class="content-left">
                                <div class="badge badge-primary p-2 font-size-md">Available online</div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="row pt-5">
                <div class=" col-12 col-lg-8">
                    <?=$pujadetails->description?>


                    <hr>







                    <h4 class="mb-7">
                        <i class="fas fa-star star-color"></i> <?=floatval($totalreview->average)?> (<?=$totalreview->total_reviews?> Reviews)
                    </h4>
                    <div class="row">
                        <div class="col col-md-12">
                            <div class="slick-slider arrow-top equal-height testimonials-slider" data-slick-options='{"slidesToShow": 3, "autoplay":false,"dots":false,"responsive":[{"breakpoint": 1200,"settings": {"slidesToShow": 2}},{"breakpoint": 768,"settings": {"slidesToShow": 1,"arrows":false}}]}'>
                                
                                <?php if(!empty($reviews)) :  ?>
                                    <?php foreach($reviews as $rv) :  ?>
                                        <div class="box">
                                            <div class="card card testimonial border-0 border-0">

                                                <div class="card-body-1 h6 font-weight-normal px-0 pb-5 mb-0 lh-15 letter-spacing-35">

                                                    <?=$rv->message?>
                                                </div>
                                                <div class="card-footer bg-transparent px-0 pt-3 pb-0">
                                                    <div class="media align-items-center">
                                                        <a href="#" class="image mr-3">
                                                            <img class="rounded-circle" src="<?=$rv->user->imageUrl?>" alt="Testimonial 1">
                                                        </a>
                                                        <div class="media-body lh-14">
                                                            <p class="font-size-md mb-0"><?=ucwords($rv->user->name)?></p>
                                                            <p><?=date('d M y',strtotime($rv->created_at))?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                               
                            </div>
                        </div>

                    </div>




                    <hr>

                    <div class="listing-image-card">
                        <div class="mb-7">
                            <h4 class="mb-0">Gallery</h4>
                        </div>
                        <div class="slick-slider arrow-top" data-slick-options='{"slidesToShow": 4, "autoplay":false,"dots":false,"responsive":[{"breakpoint": 992,"settings": {"slidesToShow": 3}},{"breakpoint": 768,"settings": {"slidesToShow": 2}},{"breakpoint": 400,"settings": {"slidesToShow": 1,"arrows":false}}]}'>
                            <?php if(!empty($pujalocation)) : ?>
                                <?php foreach($pujalocation as $lc) :   ?>
                                    <?php if(!empty($lc->galleryImgs)) : ?>
                                        <?php foreach($lc->galleryImgs as $img) : ?>
                                        <div class="box">
                                            <div class="card border-0 image-box-style-card box-shadow-hover">
                                                <a href="#">
                                                    <img src="<?=$img->img?>" alt="Furniture assembly">
                                                </a>

                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>


                </div>
                <div class="sidebar col-12 col-lg-4 order-1 order-lg-0">



                    <div class="card widget-filter bg-white mb-6 border-0 rounded-10 shadow">
                        <div class="card-header primary-text-bgcolor border-0 pt-4 pb-4">
                            <h5 class="card-title mb-0 text-white">Book Now<span class="link-hover-dark-primary float-right text-white text-capitalize">
                                    ₹ <?=$pujadetails->price?></span></h5>


                        </div>
                        <div class="card-body px-5">
                            <h5>Locations</h5>
                            <p>Select a location for your puja<br>.</p>

                            <div class="form-filter">
                                <form>
                                    <div class="form-group category">
                                        <div class="select-custom">
                                            <select class="form-control" id="select_location">
                                                <option value="0">Select Location</option>
                                                <?php if(!empty($pujalocation)) : ?>
                                                <?php foreach($pujalocation as $lc) :   ?>
                                                    <option value="<?=$lc->location_id?>" <?=(isset($_GET['la']) && $_GET['la'] == $lc->location_id) ? 'selected' : ''?>><?=$lc->name?></option>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group category">
                                        <div class="select-custom">
                                            <select class="form-control">
                                                <option value="0">Select Venue</option>
                                                <?php if(!empty($venues)) : ?>
                                                <?php foreach($venues as $lc) :   ?>
                                                    <option value="<?=$lc->id?>"><?=$lc->name?></option>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1 mt-3">
                                        <button type="button" class="btn btn-block btn-outline-secondary" data-toggle="modal" data-target="#select-date-time">
                                            Check Availability</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>





                </div>
            </div>

        </div>
    </section>


</div>

<footer class="main-footer main-footer-style-01 bg-pattern-01 pt-10 pb-10">
    <div class="footer-second">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3 mb-6 mb-lg-0">
                    <div class="mb-8"><img src="images/footer-logo.png" alt="Shaktipeeth"></div>
                    <div class="mb-7">

                        <p class="mb-0 footer-text">
                            <u><a href="privacy-policy.html" class="footer-text">Privacy Policy.</a></u><br>
                            <u><a href="terms-condition.html" class="footer-text">Terms & Conditions.</a></u><br>
                            Copyright 2020 Shaktipeeth
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg mb-6 mb-lg-0">
                    <div class="font-size-md font-weight-semibold footer-heading mb-4">
                        Explore
                    </div>
                    <ul class="list-group list-group-flush list-group-borderless">

                        <li class="list-group-item px-0 lh-1625 bg-transparent py-1">
                            <a href="pooja.html" class="link-hover-secondary-primary">Pooja</a>
                        </li>
                        <li class="list-group-item px-0 lh-1625 bg-transparent py-1">
                            <a href="astrology.html" class="link-hover-secondary-primary">Astrology</a>
                        </li>
                        <li class="list-group-item px-0 lh-1625 bg-transparent py-1">
                            <a href="ropeway.html" class="link-hover-secondary-primary">Ropeways</a>
                        </li>
                        <li class="list-group-item px-0 lh-1625 bg-transparent py-1">
                            <a href="#" class="link-hover-secondary-primary">About</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg mb-6 mb-lg-0">
                    <div class="font-size-md font-weight-semibold footer-heading mb-4">
                        Partners
                    </div>
                    <ul class="list-group list-group-flush list-group-borderless">
                        <li class="list-group-item px-0 lh-1625 bg-transparent py-1">
                            <a href="page-faqs.html" class="link-hover-secondary-primary">Become a partner</a>
                        </li>
                        <li class="list-group-item px-0 lh-1625 bg-transparent py-1">
                            <a href="#" class="link-hover-secondary-primary">Partner Login</a>
                        </li>
                        <li class="list-group-item px-0 lh-1625 bg-transparent py-1">
                            <a href="#" class="link-hover-secondary-primary">Covid-19 Protocol</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg mb-6 mb-lg-0">
                    <div class="font-size-md font-weight-semibold footer-heading mb-4">
                        Contact
                    </div>
                    <ul class="list-group list-group-flush list-group-borderless">
                        <li class="list-group-item px-0 lh-1625 bg-transparent py-1">
                            <a href="page-faqs.html" class="link-hover-secondary-primary">Email</a>
                        </li>
                        <li class="list-group-item px-0 lh-1625 bg-transparent py-1">
                            <a href="#" class="link-hover-secondary-primary">Help & FAQ</a>
                        </li>
                        <li class="list-group-item px-0 lh-1625 bg-transparent py-1">
                            <a href="#" class="link-hover-secondary-primary">Site Map</a>
                        </li>
                        <li class="list-group-item px-0 lh-1625 bg-transparent py-1">
                            <a href="#" class="link-hover-secondary-primary whatsapp-color"><i class="fab fa-whatsapp whatsapp-color"></i> WhatsApp</a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-3 mb-6 mb-lg-0">
                    <div class="pl-0 pl-lg-9">
                        <div class="font-size-lg font-weight-semibold text-white heading-width mb-4">through the journey of life, and after</div>
                        <div class="mb-4">
                            <img src="images/googleplay.png">
                        </div>
                        <div class="form-newsletter1">
                            <div class="social-icon text-white">
                                <ul class="list-inline">

                                    <li class="list-inline-item mr-5">
                                        <a target="_blank" title="Instagram" href="#">
                                            <svg class="icon icon-instagram">
                                                <use xlink:href="#icon-instagram"></use>
                                            </svg>
                                            <span>Instagram</span>
                                        </a>
                                    </li>
                                    <li class="list-inline-item mr-5">
                                        <a target="_blank" title="Facebook" href="#">
                                            <i class="fab fa-facebook-f">
                                            </i>
                                            <span>Facebook</span>
                                        </a>
                                    </li>
                                    <li class="list-inline-item mr-5">
                                        <a target="_blank" title="Twitter" href="#">
                                            <i class="fab fa-twitter">
                                            </i>
                                            <span>Twitter</span>
                                        </a>
                                    </li>
                                    <li class="list-inline-item mr-5">
                                        <a target="_blank" title="Twitter" href="#">
                                            <i class="fab fa-linkedin-in"></i>
                                            <span>Linkedin</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

</div>