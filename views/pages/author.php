<?php

// header already modified complications ...

// if (isset($_POST['exportAuthor'])) {

//     $skills = isset($_POST['skills']) ? $_POST['skills'] : [];
//     $about_me = isset($_POST['aboutme']) ? $_POST['aboutme'] : "";
//     $about_proj = isset($_POST['aboutproj']) ? $_POST['aboutproj'] : "";
//     $firstname = "Aleksa";
//     $lastname = "Bjelicic";

//     $word = new COM("word.application");
//     $word->Visible = 0;
//     $word->Documents->Add();
//     $word->Selection->PageSetup->LeftMargin = '2';
//     $word->Selection->PageSetup->RightMargin = '2';
//     $word->Selection->Font->Name = 'Arial';
//     $word->Selection->Font->Size = 10;
//     $word->Selection->TypeText("Firstname : " . "Aleksa" . "\n");
//     $word->Selection->TypeText("Lastname : " . "Bjelicic" . "\n");
//     $word->Selection->TypeText("About me : \n" .  $about_me);
//     $word->Selection->TypeText("About project : \n" .  $about_proj);
//     $filename = tempnam(sys_get_temp_dir(), "word");
//     $word->Documents[1]->SaveAs($filename);
//     $word->quit();
//     unset($word);
//     header("Content-type: application/vnd.ms-word");
//     header("Content-Disposition: attachment;Filename=author.doc");
//     readfile($filename);
//     unlink($filename);
// }


?>

<!-- Details Gallery Section Begin -->
<div class="details-gallery-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="dg-slider owl-carousel">
                    <div class="dg-item set-bg" data-setbg="assets/img/author/author-1.JPG"></div>
                    <div class="dg-item set-bg" data-setbg="assets/img/author/author-2.JPG"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Details Gallery Section End -->


<!-- Details Post Section Begin -->
<section class="details-post-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 p-0">
                <div class="details-text gallery-page">
                    <div class="dt-title-gallery details-hero-text">
                        <div class="label"><span>Gaming</span></div>
                        <div class="label"><span>Blog</span></div>
                        <h3>Gaming blog - php school project</h3>
                    </div>
                    <div id="about" class="dt-item">
                        <h5>About me</h5>
                        <p id="about-author">My name is Aleksa Bjeličić and i am at the final year of studies. I study IT, obviously, and am interested in technology of software development, web programming, design etc.
                            I'm at the age of 22 and i'm attending "ICT College".</p>
                        <h5 class="mt-5">About project</h5>
                        <p id="about-project">The project represents the gaming blog where you can find news about games, their latest features and releases or be a part of our society and leave a comment.
                            Hope you will like it, enjoy !
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-7">
                <div class="sidebar-option">
                    <div class="best-of-post">
                        <div class="section-title">
                            <h5>Skills</h5>
                        </div>
                        <div class="bp-item">
                            <div class="bp-loader">
                                <div class="loader-circle-wrap">
                                    <div class="loader-circle">
                                        <span class="circle-progress-1" data-cpid="id-1" data-cpvalue="95" data-cpcolor="#c20000"></span>
                                        <div class="pl-3 review-point skill-rate" data="1">9.5</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bp-text">
                                <h6 class="mt-3 skill-name"><a data-id="1">Angular</a></h6>
                            </div>
                        </div>
                        <div class="bp-item">
                            <div class="bp-loader">
                                <div class="loader-circle-wrap">
                                    <div class="loader-circle">
                                        <span class="circle-progress-1" data-cpid="id-2" data-cpvalue="85" data-cpcolor="#c20000"></span>
                                        <div class="pl-3 review-point skill-rate" data="2">8.5</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bp-text">
                                <h6 class="mt-3 skill-name"><a data-id="2">ASP .NET Core</a></h6>
                            </div>
                        </div>
                        <div class="bp-item">
                            <div class="bp-loader">
                                <div class="loader-circle-wrap">
                                    <div class="loader-circle">
                                        <span class="circle-progress-1" data-cpid="id-3" data-cpvalue="80" data-cpcolor="#c20000"></span>
                                        <div class="pl-3 review-point skill-rate" data="3">8.0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bp-text">
                                <h6 class="mt-3 skill-name"><a data-id="3">SQL</a></h6>
                            </div>
                        </div>
                        <div class="bp-item">
                            <div class="bp-loader">
                                <div class="loader-circle-wrap">
                                    <div class="loader-circle">
                                        <span class="circle-progress-1" data-cpid="id-4" data-cpvalue="75" data-cpcolor="#c20000"></span>
                                        <div class="pl-3 review-point skill-rate" data="4">7.5</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bp-text">
                                <h6 class="mt-3 skill-name"><a data-id="4">PHP</a></h6>
                            </div>
                        </div>
                    </div>

                    <div class="social-media">
                        <div class="section-title">
                            <h5>Social media</h5>
                        </div>
                        <ul>
                            <a href="https://github.com/bjelic97" target="_blank">
                                <li>
                                    <div class="sm-icon"><i class="fa fa-github"></i></div>
                                    <span>Github</span>
                                </li>
                            </a>
                            <a href="https://www.linkedin.com/in/aleksa-bjelicic-4782211a3/" target="_blank">
                                <li>
                                    <div class="sm-icon"><i class="fa fa-linkedin"></i></div>
                                    <span>Linkedin</span>
                                </li>
                            </a>
                            <a href="https://www.facebook.com/aleksa.bjelicic" target="_blank">
                                <li>
                                    <div class="sm-icon"><i class="fa fa-facebook"></i></div>
                                    <span>Facebook</span>
                                </li>
                            </a>
                        </ul>
                    </div>
                    <div class="social-media">
                        <div class="section-title">
                            <h5>Export</h5>
                        </div>
                        <ul>
                            <a href="#" id="export-word">
                                <li>
                                    <div class="sm-icon"><i class="fa fa-file-word-o"></i></div>
                                    <span>Word</span>
                                </li>
                            </a>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>