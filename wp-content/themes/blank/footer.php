<footer class="footer" role="contentinfo">
    <div class="container">
        <div class="meta" itemscope itemtype="http://schema.org/Organization">
            <div class="logo">
                <img width="46" height="57" src="<?php echo get_template_directory_uri(); ?>/images/logo-circle.png" alt="TF Buidling" />
            </div>
            <div class="info">
                <address class="address">
                    <div vocab="http://schema.org/" typeof="LocalBusiness">
                        <h3><span property="name">TF Building & Renovations</span></h3>
                        <span property="description">Property Renovation, Handmade Kitchens &amp; Bespoke Joinery</span>

                        <div property="address" typeof="PostalAddress">
                            <span property="streetAddress">14 Hurrs Road</span>,
                            <span property="addressLocality">Skipton</span>,
                            <span property="addressRegion">Bd23 2JX</span>
                        </div>


                    </div>
                </address>
                <span class="email"><a href="/contact/">tom@tfbuilding.co.uk</a></span>
                <span class="telephone"><a itemprop="telephone" href="tel:+08449670565">+44 (0)1756 798751</a></span>
		<span class"vat"> | Vat Number: 230 8804 22</span>
            </div>
        </div>

        <nav><?php wp_nav_menu(array('theme_location' => 'footer_nav', 'menu_class' => 'footer-menu')); ?></nav>
    </div>
</footer><!-- /#Footer -->

</div><!-- /.wrapper -->

<?php wp_footer(); ?>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-10811266-14', 'auto');
    ga('send', 'pageview');

	document.addEventListener( 'wpcf7mailsent', function( event ) {
    ga('send', 'event', 'Contact Form', 'submit');
}, false );Object

</script>

</body>
</html>
