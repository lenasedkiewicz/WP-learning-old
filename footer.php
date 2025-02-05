<footer class="">
    <div class="">
        <div class="">
            <div class="">
                <h1 class="">
                    <a href="<?php echo site_url() ?>"><strong>URL strony</a>
                </h1>
                <p>Stworzone przez:<a class="" href=""> &copy; </a></p>
            </div>

            <div class="">
                <div class="">
                    <h3 class="">Lorem ipsum</h3>
                    <nav class="">
                        <?php wp_nav_menu(array(
                            'theme_location' => 'footerMenuOne',
                        )); ?>
                    </nav>
                </div>

                <div class="">
                    <h3 class="">Lorem ipsum</h3>
                    <nav class="">
                        <?php wp_nav_menu(array(
                            'theme_location' => 'footerMenuTwo',
                        )); ?>
                    </nav>
                </div>
            </div>

            <div class="">
                <h3 class="">Social media</h3>
                <nav>
                    <ul class="">
                        <li>
                            <a href="#" class=""><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a href="#" class=""><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a href="#" class=""><i class="fa fa-youtube" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a href="#" class=""><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a href="#" class=""><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>