    <footer>
        <div class="pata">
            <div class="container">
                <div class="pataBox">
                    <h2>Sledujte nás na Instragramu</h2>
                    <div class="ig">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/ig-photo1.jpg" alt="Instagramová fotka">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/ig-photo2.jpg" alt="Instagramová fotka">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/ig-photo3.jpg" alt="Instagramová fotka1">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/ig-photo4.jpg" alt="Instagramová fotka1">
                    </div>
                </div>

                <div class="pataBox">
                    <h2>Informace o kurzu na váš mail</h2>
                    <?php echo do_shortcode( '[contact-form-7 id="ac0e48d" title="newsletter"]') ?>
                    <p>Odesláním formuláře souhlasíte s podmínkami <a href="<?php echo get_home_url("home"); ?>/ochrana-osobnich-udaju/">ochrany osobních údajů</a>.</p>
                </div>
            </div>
        </div>

        <div class="copy">
            <div class="container">
                <div class="copyL">

                    <p>&copy;2020 - <?php echo date('Y');?><b> PrimaFuture.cz s.r.o.</b>, design by <a href="#" target="_blank">Lukáš Krása</a>, code by <a href="#" target="_blank">Jakub Novotný</a></p>

                    <p><a href="#">Zásady cookies</a> <span>|</span> <a href="<?php echo get_home_url("home"); ?>/ochrana-osobnich-udaju/">Ochrana osobních údajů</a></p>

                </div>
                <div class="copyR">

                    <p>Tento web je ukázka z <a href="https://www.primakurzy.cz/kurz-tvorba-webovych-stranek/" target="_blank">kurzu Tvorba webových stránek</a> od <a href="https://www.primakurzy.cz/" target="_blank">PrimaKurzy.cz</a></p>

                    <p>
                        <a href="#" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                    </p>

                </div>

            </div>
        </div>
    </footer>

    <script>
        //zaměří input s name="datum"
        let input = document.querySelector("[name=datum]");
        //změna atributu type na type="text"
        input.setAttribute("type", "text");
        //v momentě kliknutí se to změní na date
        input.addEventListener("focus", () => {input.setAttribute("type", "date")});
        // v momentě kdy odkliknu pryč tak je to text
        input.addEventListener("blur", () => {input.setAttribute("type", "text")});
    </script>

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/cs_CZ/sdk.js#xfbml=1&version=v20.0" nonce="OuTvyOKm"></script>
    
    <?php wp_footer(); ?>
</body>
</html>