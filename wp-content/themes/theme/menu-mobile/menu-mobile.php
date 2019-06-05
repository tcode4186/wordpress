<?php
$menuLocations = get_nav_menu_locations();
$menuID = $menuLocations['Menu_Main'];
$primaryNav = wp_get_nav_menu_items($menuID);
$id_parent = 0;
if ($primaryNav) :
    ?>
    <style>
        @media (min-width: 768px) {
            #menu-mobile {
                display: none;
            }
        }

        @media (max-width: 767px) {
            #menu-mobile {
                display: block;
            }
        }

        #mobile-menu-icon {
            color: #999;
        }

        .nav-icon, .nav-icon:before, .nav-icon:after {
            background: #999;
        }

        #mobile-menu-icon:hover {
            color: #08f;
        }

        #mobile-menu-icon:hover .nav-icon,
        #mobile-menu-icon:hover .nav-icon:before,
        #mobile-menu-icon:hover .nav-icon:after {
            background: #08f;
        }
    </style>
    <section id="menu-mobile">
        <div class="icon-click-menu">
            <a href="javascript:" id="mobile-menu-icon">
                <span class="nav-icon"></span>
                <span class="menu-text">Menu</span>
            </a>
            <?php
            $logo_main = get_field('logo_main', 'option');
            if ($logo_main) : ?>
                <a href="<?php echo home_url() ?>" class="logo-main-mobile">
                    <img src="<?php echo $logo_main['url'] ?>" alt="<?php echo $logo_main['alt'] ?>">
                </a>
            <?php endif; ?>
            <a class="cart-contents text-white float-right" href="<?php echo WC()->cart->get_cart_url(); ?>"
               title="<?php _e('Giỏ hàng '); ?>">
                <img src="<?php echo get_template_directory_uri() . '/images/shopping.png' ?>" alt="">
                <span class="number-cart">
                    <?php echo sprintf(_n('%d', '%d', WC()->cart->cart_contents_count), WC()->cart->cart_contents_count); ?>
                </span>
            </a>
        </div>
        <div class="show-menu-mobile">
            <div class="close-menu">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>
            <ul id="nav-menu">
                <?php
                foreach ($primaryNav as $navItem) {
                    if ($navItem->menu_item_parent == $id_parent) {
                        echo '<li class="menu-item' . $navItem->ID . '"> <a href="' . $navItem->url . '" title="' . $navItem->title . '">' . $navItem->title . '</a>';
                        $sub = "";
                        foreach ($primaryNav as $navItem2) {
                            if ($navItem2->menu_item_parent == $navItem->ID) {
                                $sub .= '<li class="menu-item' . $navItem2->ID . '"> <a href="' . $navItem2->url . '" title="' . $navItem2->title . '">' . $navItem2->title . '</a>';
                                $sub2 = "";
                                foreach ($primaryNav as $navItem3) {
                                    if ($navItem3->menu_item_parent == $navItem2->ID) {
                                        $sub2 .= '<li class="menu-item' . $navItem3->ID . '"> <a href="' . $navItem3->url . '" title="' . $navItem3->title . '">' . $navItem3->title . '</a></li>';
                                    }
                                }
                                $sub .= '<ul>' . $sub2 . '</ul>';
                                $sub .= $sub2 != null ? '</li>' : '</li>';
                            }
                        }
                        echo '<ul class="12312">' . $sub . '</ul>';
                        echo $sub != null ? '<span><i class="fa fa-chevron-down"></i></span></li>' : '</li>';
                    }
                }
                ?>
            </ul>
        </div>
    </section>
<?php endif; ?>