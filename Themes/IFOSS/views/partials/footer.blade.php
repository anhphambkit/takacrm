<section class="news-letter">
        <div class="container">
            <div class="news-letter--wrapper row">
                <div class="col-md-6">
                    <div class="news-letter--wrapper--title">Be the first to know about our daily sales!</div>
                </div>
                <div class="col-md-6">
                    <form>
                        <div class="row">
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Email address" />
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-custom">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer-wrapper">
    <div class="container">
        <div class="row footer-wrapper--top">
            <div class="col-md-3 col-sm-6">
                <div class="footer-wrapper--title">About Us</div>
                <ul class="footer-wrapper--link">
                    <?php $footerLink = array('About Takabook','Careers','Investor Relations','Locations');
                    foreach ($footerLink as $key => $value) {
                    ?>
                    <li><a href="#"><?php echo $value; ?></a></li>
                    <?php } ?>
                </ul>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="footer-wrapper--title">Customer Service</div>
                <ul class="footer-wrapper--link">
                    <?php $footerLink = array('My Orders','Return Policy','Help Center');
                    foreach ($footerLink as $key => $value) {
                    ?>
                    <li><a href="#"><?php echo $value; ?></a></li>
                    <?php } ?>
                </ul>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="footer-wrapper--title">Contact Us</div>
                <ul class="footer-wrapper--link">
                    <li>
                        <button class="btn btn-outline-custom"><i class="fas fa-phone-volume text-danger"></i> Call us</button>
                    </li>
                    <li>
                        <button class="btn btn-custom"><i class="fas fa-clock"></i> Quick Service </button>
                    </li>
                </ul>
            </div>

            <div class="col-md-3 col-sm-6">
                <ul class="footer-wrapper--link work-time" style="margin-top: 55px;">
                    <li> Mon - Fri: 8AM - midnight</li>
                    <li>Sat: 8AM - 8PM      I      Sun: 9AM - 6PM</li>
                    <li>All times Eastern</li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="row footer-wrapper--bottom">
            <div class="col-md-6">
                <ul class="footer-wrapper--link--inline">
                    <?php $footerLink = array('Privacy Policy','Terms of Use','Interest-Based Ads');
                    foreach ($footerLink as $key => $value) {
                    ?>
                    <li><a href="#"><?php echo $value; ?></a></li>
                    <?php } ?>
                </ul>
                <div class="footer-wrapper--bottom--copyright">© Copyright 2019 Takabook inc | Design by Tinyprovider.com</div>
            </div>
            <div class="col-md-6">
                <ul class="footer-wrapper--link--social justify-content-md-end">
                    <?php $footerLink = array('fab fa-facebook-f','fab fa-instagram','fab fa-youtube', 'fab fa-twitter', 'fab fa-google-plus-g');
                    foreach ($footerLink as $key => $value) {
                    ?>
                    <li><a href="#" class="<?php echo $value; ?>"></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</footer>