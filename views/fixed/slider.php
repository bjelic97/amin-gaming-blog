<!-- Hero Section Begin -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="hs-text">
                    <div class="label"><span>Gaming</span></div>
                    <h3>For gamers, by gamers</h3>
                    <div class="ht-meta">
                        <img src="assets/img/hero/meta-pic.jpg" alt="">
                        <ul>
                            <li>by Aleksa Bjeličić</li>
                            <li>June 07, 2020</li>
                        </ul>
                    </div>
                </div>
            </div>

            <?php if (isset($_SESSION['user'])) : ?>
                <?php if ($_SESSION['user']->id_role == 1) : ?>
                    <div class="col-xl-4 col-lg-5 col-md-6 offset-lg-1 offset-xl-2">
                        <div class="trending-post">

                            <div class="section-title">
                                <h5>Аctivities</h5>
                            </div>
                            <div class="trending-slider owl-carousel">
                                <div class="single-trending-item">

                                    <div class="section-title">
                                        <h5>Most visited</h5>
                                    </div>

                                    <div class="sidebar-option">

                                        <div class="best-of-post">
                                            <?php
                                            $stats = get_attendance_stat();
                                            foreach ($stats as $stat) :
                                            ?>
                                                <div class="bp-item">
                                                    <div class="bp-loader">
                                                        <div class="loader-circle-wrap">
                                                            <div class="loader-circle">
                                                                <span class="circle-progress-1" data-cpid="id-1" data-cpvalue="95" data-cpcolor="#c20000"></span>
                                                                <div class="review-point skill-rate" data="1"><?= $stat->perc ?>%</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bp-text">
                                                        <h6 class="mt-4 ml-3 skill-name"><a data-id="1"><?= $stat->page ?></a></h6>
                                                    </div>
                                                </div>

                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-trending-item">
                                    <div class="section-title">
                                        <?php
                                        $open = fopen(LOGGED_USERS, "r");
                                        $data = file(LOGGED_USERS);
                                        $logged_users = [];
                                        foreach ($data as $row) {
                                            $logged_user_info = explode("\t", $row);
                                            array_push($logged_users, $logged_user_info);
                                        }
                                        ?>
                                        <h5>Online (<?= count($logged_users); ?>) <i style="color:green;" class="fa fa-circle" aria-hidden="true"></i></h5>
                                    </div>
                                    <?php
                                    foreach ($logged_users as $user) :
                                    ?>
                                        <div class="trending-item">
                                            <div class="ti-pic">
                                                <img src="assets/img/trending/editor-2.jpg" alt="">
                                            </div>
                                            <div class="ti-text">
                                                <h6><a><?= $user[1] ?></a>
                                                </h6>
                                                <ul>
                                                    <li><i class="fa fa-clock-o"></i><?= $user[2] = date("F j, Y. H:i", strtotime($user[2])); ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>

    </div>
    <div class="hero-slider owl-carousel">
        <div class="hs-item set-bg" data-setbg="assets/img/hero/hero-1.jpg"></div>
        <div class="hs-item set-bg" data-setbg="assets/img/hero/hero-2.jpg"></div>
        <div class="hs-item set-bg" data-setbg="assets/img/hero/hero-3.jpg"></div>
    </div>

</section>

<!-- Hero Section End -->