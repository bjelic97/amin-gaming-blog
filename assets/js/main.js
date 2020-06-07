/*  ---------------------------------------------------
    Template Name: Amin
    Description:  Amin magazine HTML Template
    Author: Colorlib
    Author URI: https://colorlib.com
    Version: 1.0
    Created: Colorlib
---------------------------------------------------------  */

"use strict";

(function ($) {
  /*------------------
        Preloader
    --------------------*/
  $(window).on("load", function () {
    $(".loader").fadeOut();
    $("#preloder").delay(200).fadeOut("slow");
  });

  /*------------------
        Background Set
    --------------------*/
  $(".set-bg").each(function () {
    var bg = $(this).data("setbg");
    $(this).css("background-image", "url(" + bg + ")");
  });

  // Humberger Menu
  $(".humberger-open").on("click", function () {
    $(".humberger-menu-wrapper").addClass("show-humberger-menu");
    $(".humberger-menu-overlay").addClass("active");
    $(".nav-options").addClass("humberger-change");
  });

  $(".humberger-menu-overlay").on("click", function () {
    $(".humberger-menu-wrapper").removeClass("show-humberger-menu");
    $(".humberger-menu-overlay").removeClass("active");
    $(".nav-options").removeClass("humberger-change");
  });

  // Search model
  $(".search-switch").on("click", function () {
    $(".search-model").fadeIn(400);
  });

  $(".search-close-switch").on("click", function () {
    $(".search-model").fadeOut(400, function () {
      $("#search-input").val("");
    });
  });

  // Sign Up Form
  $(".signup-switch").on("click", function () {
    $(".signup-section").fadeIn(400);
  });

  $(".signup-close").on("click", function () {
    $(".signup-section").fadeOut(400);
    $(".signup-form")[0].reset();
    $("#errors").fadeOut(400);
    $("#success").fadeOut(400);
  });

  // Generic Form
  $("body").on("click", ".generic-switch", function (e) {
    e.preventDefault();
    let action = $(this).data("action");
    switch (action) {
      case "login":
        $(".login-section").fadeIn(400);
        break;
      case "register":
        $(".signup-section").fadeIn(400);
        break;
      case "logout":
        $(".logout-section").fadeIn(400);
        break;
      case "delete-post":
        let id = $(this).data("id");

        // get one and fill delete form :
        $.ajax({
          method: "POST",
          url: "models/posts/get-one.php",
          data: {
            id: id,
          },
          dataType: "json",
          success: function (data, status, request) {
            switch (request.status) {
              case 201:
                console.info(`${request.status}: ${request.statusText}`);
                break;
              case 200:
                console.info(`${request.status}: ${request.statusText}`);
                break;
              case 204:
                console.info(`${request.status}: ${request.statusText}`);
                break;
            }
            console.info(data);
            console.info(status);
            console.info(request);
            console.info(request.responseJSON);

            printPostDeleteModal(request.responseJSON);

            $("#btn-delete-post").data("id", id);
            $(".delete-post-section").fadeIn(400);
          },
          error: showErrors,
        });

        break;

      case "delete-comment":
        let commentId = $(this).data("id");
        // get one and fill delete form :
        $.ajax({
          method: "POST",
          url: "models/comments/get-one.php",
          data: {
            id: commentId,
          },
          dataType: "json",
          success: function (data, status, request) {
            switch (request.status) {
              case 201:
                console.info(`${request.status}: ${request.statusText}`);
                break;
              case 200:
                console.info(`${request.status}: ${request.statusText}`);
                break;
              case 204:
                console.info(`${request.status}: ${request.statusText}`);
                break;
            }
            console.info(data);
            console.info(status);
            console.info(request);
            console.info(request.responseJSON);

            printComment(request.responseJSON);

            $("#btn-delete-comment").data("id", commentId);
            $("#btn-delete-comment").data("post", data.post_id);
            $(".delete-comment-section").fadeIn(400);
          },
          error: showErrors,
        });

        break;
      case "edit-post-image":
        let postId = $(this).data("post");
        let src = $(this).data("image");
        $(".blah").attr("src", src);
        $("#btn-save-edit-post-image").data("post", postId);
        $(".post-image-section").fadeIn(400);
        break;
    }
  });

  $(".login-close").on("click", function () {
    $(".login-section").fadeOut(400);
    $(".login-form")[0].reset();
    $("#errors").fadeOut(400);
    $("#success").fadeOut(400);
  });

  $(".logout-close").on("click", function () {
    $(".logout-section").fadeOut(400);
  });

  $(".delete-post-close").on("click", function () {
    $(".delete-post-section").fadeOut(400);
  });

  $(".delete-comment-close").on("click", function () {
    $(".delete-comment-section").fadeOut(400);
  });

  $(".post-image-close").on("click", function () {
    $(".post-image-section").fadeOut(400);
    // $("#blah").attr("src", "assets/img/default-image.jpg");
  });

  /*------------------
		Navigation
	--------------------*/
  $(".mobile-menu").slicknav({
    prependTo: "#mobile-menu-wrap",
    allowParentLinks: true,
  });

  /*------------------
        Hero Slider
    --------------------*/
  var hero_s = $(".hero-slider");
  hero_s.owlCarousel({
    loop: true,
    margin: 0,
    items: 1,
    dots: true,
    animateOut: "fadeOut",
    animateIn: "fadeIn",
    smartSpeed: 1200,
    autoHeight: false,
    autoplay: false,
  });

  /*------------------
        Trending Slider
    --------------------*/
  $(".trending-slider").owlCarousel({
    loop: true,
    margin: 0,
    items: 1,
    dots: false,
    nav: true,
    navText: [
      '<span class="arrow_carrot-left"></span>',
      '<span class="arrow_carrot-right"></span>',
    ],
    dotsEach: 2,
    smartSpeed: 1200,
    autoHeight: false,
    autoplay: true,
  });

  /*------------------------
        Latest Review Slider
    --------------------------*/
  $(".lp-slider").owlCarousel({
    loop: true,
    margin: 0,
    items: 4,
    dots: true,
    nav: true,
    navText: [
      '<span class="arrow_carrot-left"></span>',
      '<span class="arrow_carrot-right"></span>',
    ],
    smartSpeed: 1200,
    autoHeight: false,
    dotsEach: 2,
    autoplay: true,
    responsive: {
      320: {
        items: 1,
      },
      480: {
        items: 2,
      },
      768: {
        items: 3,
      },
      992: {
        items: 4,
      },
    },
  });

  /*------------------------
        Update News Slider
    --------------------------*/
  $(".un-slider").owlCarousel({
    loop: true,
    margin: 0,
    items: 1,
    dots: false,
    nav: true,
    navText: [
      '<span class="arrow_carrot-left"></span>',
      '<span class="arrow_carrot-right"></span>',
    ],
    smartSpeed: 1200,
    autoHeight: false,
    dotsEach: 2,
    autoplay: true,
  });

  /*------------------------
        Video Guide Slider
    --------------------------*/
  $(".vg-slider").owlCarousel({
    loop: true,
    margin: 0,
    items: 1,
    dots: false,
    nav: true,
    navText: [
      '<span class="arrow_carrot-left"></span>',
      '<span class="arrow_carrot-right"></span>',
    ],
    smartSpeed: 1200,
    autoHeight: false,
    autoplay: true,
  });

  /*------------------------
        Gallery Slider
    --------------------------*/
  $(".dg-slider").owlCarousel({
    loop: true,
    margin: 0,
    items: 1,
    dots: false,
    nav: true,
    navText: [
      '<span class="arrow_carrot-left"></span>',
      '<span class="arrow_carrot-right"></span>',
    ],
    smartSpeed: 1200,
    autoHeight: false,
    autoplay: true,
  });

  /*------------------
        Video Popup
    --------------------*/
  $(".video-popup").magnificPopup({
    type: "iframe",
  });

  /*------------------
        Barfiller
    --------------------*/
  $("#bar-1").barfiller({
    barColor: "#ffffff",
    duration: 2000,
  });
  $("#bar-2").barfiller({
    barColor: "#ffffff",
    duration: 2000,
  });
  $("#bar-3").barfiller({
    barColor: "#ffffff",
    duration: 2000,
  });
  $("#bar-4").barfiller({
    barColor: "#ffffff",
    duration: 2000,
  });
  $("#bar-5").barfiller({
    barColor: "#ffffff",
    duration: 2000,
  });
  $("#bar-6").barfiller({
    barColor: "#ffffff",
    duration: 2000,
  });

  /*------------------
        Circle Progress
    --------------------*/
  $(".circle-progress").each(function () {
    var cpvalue = $(this).data("cpvalue");
    var cpcolor = $(this).data("cpcolor");
    var cpid = $(this).data("cpid");

    $(this).append(
      '<div class="' + cpid + '"></div><div class="progress-value"></div>'
    );

    if (cpvalue < 100) {
      $("." + cpid).circleProgress({
        value: "0." + cpvalue,
        size: 40,
        thickness: 2,
        startAngle: -190,
        fill: cpcolor,
        emptyFill: "rgba(0, 0, 0, 0)",
      });
    } else {
      $("." + cpid).circleProgress({
        value: 1,
        size: 40,
        thickness: 5,
        fill: cpcolor,
        emptyFill: "rgba(0, 0, 0, 0)",
      });
    }
  });

  $(".circle-progress-1").each(function () {
    var cpvalue = $(this).data("cpvalue");
    var cpcolor = $(this).data("cpcolor");
    var cpid = $(this).data("cpid");

    $(this).append(
      '<div class="' + cpid + '"></div><div class="progress-value"></div>'
    );

    if (cpvalue < 100) {
      $("." + cpid).circleProgress({
        value: "0." + cpvalue,
        size: 93,
        thickness: 2,
        startAngle: -190,
        fill: cpcolor,
        emptyFill: "rgba(0, 0, 0, 0)",
      });
    } else {
      $("." + cpid).circleProgress({
        value: 1,
        size: 93,
        thickness: 5,
        fill: cpcolor,
        emptyFill: "rgba(0, 0, 0, 0)",
      });
    }
  });

  $(".circle-progress-2").each(function () {
    var cpvalue = $(this).data("cpvalue");
    var cpcolor = $(this).data("cpcolor");
    var cpid = $(this).data("cpid");

    $(this).append(
      '<div class="' + cpid + '"></div><div class="progress-value"></div>'
    );

    if (cpvalue < 100) {
      $("." + cpid).circleProgress({
        value: "0." + cpvalue,
        size: 200,
        thickness: 5,
        startAngle: -190,
        fill: cpcolor,
        emptyFill: "rgba(0, 0, 0, 0)",
      });
    } else {
      $("." + cpid).circleProgress({
        value: 1,
        size: 200,
        thickness: 5,
        fill: cpcolor,
        emptyFill: "rgba(0, 0, 0, 0)",
      });
    }
  });
})(jQuery);
