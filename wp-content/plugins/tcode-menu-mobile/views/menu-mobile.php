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

        .icon-click-menu {
            background: #000;
        }

        #mobile-menu-icon {
            color: #fff;
        }

        .nav-icon, .nav-icon:before, .nav-icon:after {
            background: #fff;
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
            <a class="logo-main-mobile float-right" href="<?php echo home_url() ?>">
                <img src="<?php echo plugin_dir_url(__DIR__) . 'images/logo-epal-shop.svg' ?>" alt="">
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
                                $sub .= $sub2 != null ? '<span><i class="fa fa-chevron-down"></i></span></li>' : '</li>';
                            }
                        }
                        echo '<ul>' . $sub . '</ul>';
                        echo $sub != null ? '<span><i class="fa fa-chevron-down"></i></span></li>' : '</li>';
                    }
                }
                ?>
            </ul>
        </div>
    </section>
<?php endif; ?>