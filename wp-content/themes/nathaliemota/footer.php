    <footer class="main-footer">
        <div class="footer-container">
            <?php
            // Afficher le menu du footer
            wp_nav_menu(array(
                'theme_location' => 'footer-menu', // Emplacement du menu
                'container'      => 'nav',         // Conteneur du menu
                'menu_class'     => 'footer-menu', // Classe CSS à appliquer au <ul>
                'menu_id'        => 'footer-menu', // ID pour le <ul>
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>', // Formattage des éléments
            ));
            ?>
        </div>
    </footer>

</body>
</html>