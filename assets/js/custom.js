$(document).ready(function () {
  // REGISTER JS

  $("body").on("click", "#register", function (e) {
    e.preventDefault();

    var firstname = document.querySelector("#firstname").value;
    var lastname = document.querySelector("#lastname").value;
    var email = document.querySelector("#email").value;

    let username = document.querySelector("#username").value;
    let password = document.querySelector("#password").value;

    let errors = [];

    let regFirstName = /^[A-ZŽŠĐĆČ][a-zžšđčć]{3,12}$/;
    let regLastName = /^([A-ZŽŠĐĆČ][a-zžšđčć]{3,12})+$/;
    let regEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    let regPassword = /^[\w\d]{5,15}$/;

    if (!regFirstName.test(firstname)) {
      errors.push(
        "<strong>Firstname :</strong> Letters only, min-3 max-12 characters, first letter capitalised."
      );
    }

    if (!regLastName.test(lastname)) {
      errors.push(
        "<strong>Lastname :</strong>  Letters only, min-3 max-12 characters, first letter capitalised."
      );
    }

    if (!regEmail.test(email)) {
      errors.push("<strong>Invalid email format.</strong>");
    }

    if (!regPassword.test(username)) {
      errors.push(
        "<strong>Username :</strong> Letters and numbers allowed, min-5 max-15 characters."
      );
    }

    if (!regPassword.test(password)) {
      errors.push(
        "<strong>Password :</strong> Letters and numbers allowed, min-5 max-15 characters."
      );
    }

    // // AJAX CALL

    if (errors.length != 0) {
      let errorElement = $("#errors");
      $("#register").before(errorElement);
      printErrors(errors);
    } else {
      $("#errors").fadeOut(400);

      $.ajax({
        method: "POST",
        url: "models/auth/register.php",
        data: {
          regUser: "nestopametnije",
          firstname: firstname,
          lastname: lastname,
          email: email,
          password: password,
          username: username,
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
          let successElement = $("#success");
          $(".signup-title").before(successElement);
          printSuccess("Success!", "You have successfully registered.");
        },
        error: showErrors,
      });
    }
  });

  // END OF REGISTER JS

  // LOGIN JS

  $("body").on("click", "#login", function (e) {
    e.preventDefault();
    let username = document.querySelector("#log-username").value;
    let password = document.querySelector("#log-password").value;

    let errors = [];

    let regPassword = /^[\w\d]{5,15}$/;

    if (!regPassword.test(username)) {
      errors.push(
        "<strong>Username :</strong> Letters and numbers allowed, length 15."
      );
    }

    if (!regPassword.test(password)) {
      errors.push(
        "<strong>Password :</strong> Letters and numbers allowed, length 15."
      );
    }

    // // AJAX CALL

    if (errors.length != 0) {
      let errorElement = $("#errors");
      $("#login").before(errorElement);
      printErrors(errors);
    } else {
      $("#errors").addClass("elementDissapear");

      $.ajax({
        method: "POST",
        url: "models/auth/login.php",
        data: {
          logUser: "log",
          username: username,
          password: password,
        },
        dataType: "json",
        success: function (data, status, request) {
          console.info(data);
          console.info(status);
          console.info(request);
          console.info(request.responseJSON);
          let successElement = $("#success");
          $(".login-title").before(successElement);
          printSuccess("Success!", "You have successfully logged in.");
          setTimeout(window.location.replace("index.php"), 5000);
        },
        error: showErrors,
      });
    }
  });

  // END LOGIN JS

  // POST SECTION

  // CREATE POST
  $("body").on("click", "#create-post", function (e) {
    e.preventDefault();

    let title = document.querySelector("#title").value.trim();
    let content = document.querySelector("#content").value.trim();
    let category = document.querySelector("#categories").value;
    let image = document.getElementById("uploaded-img").files[0]; // vrati sve info o slici

    let errors = [];

    if (title == "" || title.length < 3) {
      errors.push(
        "<strong>Title :</strong> Required and must have more then 3 characters."
      );
    }
    if (category == 0) {
      errors.push("<strong>Category :</strong> Required.");
    }
    if (content == "" || content.length < 3) {
      errors.push(
        "<strong>Content :</strong> Required and must have more then 3 characters."
      );
    }
    if (image == undefined) {
      errors.push("<strong>Image :</strong> Required.");
    }
    // // AJAX CALL

    if (errors.length != 0) {
      let errorElement = $("#errors");
      $("#create-post").after(errorElement);
      printErrors(errors);
    } else {
      $("#errors").fadeOut(400);

      let transmitted_data = new FormData();
      transmitted_data.append("title", title);
      transmitted_data.append("category", category);
      transmitted_data.append("content", content);
      transmitted_data.append("image", image);
      transmitted_data.append("btnCreatePost", "true");

      $.ajax({
        method: "POST",
        url: "models/posts/create.php",
        data: transmitted_data,
        dataType: "json",
        contentType: false,
        processData: false,
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
          setTimeout(
            window.location.replace(
              `index.php?page=posts&id=${request.responseJSON}`
            ),
            5000
          );
          let successElement = $("#success");
          // $(".signup-title").before(successElement);
          // printSuccess("Success!", "You have successfully registered.");
        },
        error: showErrors,
      });
    }
  });

  // END CREATE POST

  // DELETE POST
  $("body").on("click", "#btn-delete-post", function (e) {
    e.preventDefault();
    let id = $(this).data("id");

    // AJAX CALL

    $.ajax({
      method: "POST",
      url: "models/posts/delete.php",
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
        setTimeout(window.location.replace(`index.php`), 5000);
        // let successElement = $("#success");
        // $(".signup-title").before(successElement);
        // printSuccess("Success!", "You have successfully registered.");
      },
      error: showErrors,
    });
  });

  // END DELETE POST

  // PATCH POST TITLE

  $("body").on("click", ".edit-post-title", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let title = $(".post-title").html();
    $(".post-title").fadeOut(400);
    $(".edit-post-title").fadeOut(400);
    $(".static-post-title").html("Update title");
    $("#post-title").val(title);
    $(".edit-post-title-form").fadeIn(400);
  });

  $("body").on("click", "#btn-cancel-edit-post-title", function (e) {
    e.preventDefault();
    $("#errors").fadeOut(400);
    $(".post-title").fadeIn(400);
    $(".edit-post-title").fadeIn(400);
    $(".static-post-title").html("Title");
    $(".edit-post-title-form").fadeOut(400);
  });

  $("body").on("click", "#btn-save-edit-post-title", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let title = document.querySelector("#post-title").value.trim();
    let errors = [];

    if (title == "" || title.length < 3 || title.length >= 75) {
      errors.push("<strong>Title : </strong>Min: 3 / Max: 75 characters.");
    }

    if (errors.length != 0) {
      let errorElement = $("#errors");
      $("#btn-cancel-edit-post-title").after(errorElement);
      printErrors(errors);
    } else {
      $("#errors").fadeOut(400);

      // AJAX CALL

      $.ajax({
        method: "POST",
        url: "models/posts/patch-title.php",
        data: {
          id: id,
          title: title,
          btnPatchTitle: "patch",
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
          printSuccessToast("Successfully updated post title.");
          $("#errors").fadeOut(400);
          $(".post-title").html(title);
          $("#post-preview-title").html(title);
          $(".post-title").fadeIn(400);
          $(".edit-post-title").fadeIn(400);
          $(".static-post-title").html("Title");
          $(".edit-post-title-form").fadeOut(400);
          $("#modified-at").html(`Modified : ${generateFormatedCurrentDate()}`);

          // setTimeout(
          //   window.location.replace(`index.php?page=posts&id=${id}`),
          //   5000
          // );
        },
        error: showErrors,
      });
    }
  });

  // END PATCH POST TITLE

  // PATCH POST CONTENT

  $("body").on("click", ".edit-post-content", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let content = $(".post-content").html();
    $(".post-content").fadeOut(400);
    $(".edit-post-content").fadeOut(400);
    $(".static-post-content").html("Update content");
    $("#post-content").val(content);
    $(".edit-post-content-form").fadeIn(400);
  });

  $("body").on("click", "#btn-cancel-edit-post-content", function (e) {
    e.preventDefault();
    $("#errors").fadeOut(400);
    $(".post-content").fadeIn(400);
    $(".edit-post-content").fadeIn(400);
    $(".static-post-content").html("Content");
    $(".edit-post-content-form").fadeOut(400);
  });

  $("body").on("click", "#btn-save-edit-post-content", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let content = document.querySelector("#post-content").value.trim();
    let errors = [];

    if (content == "" || content.length < 3) {
      errors.push("<strong>Content : </strong>Min: 3 characters.");
    }

    if (errors.length != 0) {
      let errorElement = $("#errors");
      $(".dt-leave-comment").after(errorElement);
      printErrors(errors);
    } else {
      $("#errors").fadeOut(400);

      // AJAX CALL

      $.ajax({
        method: "POST",
        url: "models/posts/patch-content.php",
        data: {
          id: id,
          content: content,
          btnPatchContent: "patch",
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
          printSuccessToast("Successfully updated post content.");
          $(".post-content").html(content);
          $("#errors").fadeOut(400);
          $(".post-content").fadeIn(400);
          $(".edit-post-content").fadeIn(400);
          $(".static-post-content").html("Content");
          $(".edit-post-content-form").fadeOut(400);
          $("#modified-at").html(`Modified : ${generateFormatedCurrentDate()}`);
        },
        error: showErrors,
      });
    }
  });

  // END PATCH POST CONTENT

  // PATCH POST CATEGORY

  $("body").on("click", ".edit-post-category", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let category = $(this).data("category");

    $(".post-category").fadeOut(400);
    $(".edit-post-category").fadeOut(400);
    $(".tag-post-cat").fadeOut(400);
    $(".static-post-category").html("Update category");
    $("#post-category").val(category);
    $(".edit-post-category-form").fadeIn(400);
  });

  $("body").on("click", "#btn-cancel-edit-post-category", function (e) {
    e.preventDefault();
    $("#errors").fadeOut(400);
    $(".post-category").fadeIn(400);
    $(".edit-post-category").fadeIn(400);
    $(".static-post-category").html("Category");
    $(".tag-post-cat").fadeIn(400);
    $(".edit-post-category-form").fadeOut(400);
  });

  $("body").on("click", "#btn-save-edit-post-category", function (e) {
    e.preventDefault();

    let id = $(this).data("id");
    let category = document.querySelector("#post-category").value;
    let categoryName = $("#post-category option:selected").text();

    // AJAX CALL

    $.ajax({
      method: "POST",
      url: "models/posts/patch-category.php",
      data: {
        id: id,
        category: category,
        btnPatchCategory: "patch",
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
        printSuccessToast("Successfully updated post category.");
        $("#errors").fadeOut(400);
        $(".post-category").fadeIn(400);
        $(".edit-post-category").fadeIn(400);
        $(".static-post-category").html("Category");
        $(".tag-post-cat").fadeIn(400);
        $(".edit-post-category-form").fadeOut(400);
        $(".category").html(categoryName.toUpperCase());
        $(".edit-post-category").data("category", category);
        $("#modified-at").html(`Modified : ${generateFormatedCurrentDate()}`);
        // setTimeout(
        //   window.location.replace(`index.php?page=posts&id=${id}`),
        //   5000
        // );
      },
      error: showErrors,
    });
  });

  // END PATCH POST CATEGORY

  // PATCH POST IMAGE

  $("body").on("click", "#btn-save-edit-post-image", function (e) {
    e.preventDefault();
    let postId = $(this).data("post");
    let image = document.getElementById("uploaded-img-edit").files[0];

    let errors = [];

    if (image == undefined) {
      errors.push("<strong>Image :</strong> Required.");
    }

    if (errors.length != 0) {
      let errorElement = $("#errors");
      $("#btn-save-edit-post-image").after(errorElement);
      printErrors(errors);
    } else {
      $("#errors").fadeOut(400);

      // AJAX CALL
      let transmitted_data = new FormData();
      transmitted_data.append("id", postId);
      transmitted_data.append("image", image);
      transmitted_data.append("btnEditPostImage", "true");

      $.ajax({
        method: "POST",
        url: "models/posts/patch-image.php",
        data: transmitted_data,
        dataType: "json",
        contentType: false,
        processData: false,
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

          let image_src_preview = `assets/img/posts/${postId}/preview_${image.name}`;
          let image_src_original = `assets/img/posts/${postId}/${image.name}`;
          $("#post-image-preview").data("setbg", image_src_preview);
          $("#post-image-preview").attr(
            "style",
            `background-image:url("${image_src_preview}")`
          );
          $(".post-image-section").fadeOut(400);
          $("#ed-post-img").data("image", image_src_original);
          $(`#posts-nav-img-${postId}`).attr("src", image_src_original);
          printSuccessToast("Successfully updated post image.");

          // easier with page-reload but wanted visual upgrade without reloading whole page and so user can see message that he
          // has successfully updated an image *

          // setTimeout(
          //   window.location.replace(`index.php?page=posts&id=${postId}`),
          //   5000
          // );
        },
        error: showErrors,
      });
    }
  });

  // END PATCH POST IMAGE

  // POST LIKE

  $("body").on("click", ".toggle-like-post", function (e) {
    e.preventDefault();
    let id = $(this).data("id");

    // AJAX CALL

    $.ajax({
      method: "POST",
      url: "models/posts/like.php",
      data: {
        id: id,
        btnLikePost: "like",
      },
      dataType: "json",
      success: function (data, status, request) {
        switch (request.status) {
          case 201:
            console.info(`${request.status}: ${request.statusText}`);
            printSuccessToast("Successfully liked a post.");
            $("#success-toast").fadeOut(4000);
            break;
          case 200:
            console.info(`${request.status}: ${request.statusText}`);
            break;
          case 204:
            console.info(`${request.status}: ${request.statusText}`);
            printSuccessToast("Successfully unliked a post.");
            $("#success-toast").fadeOut(4000);
            break;
        }
        console.info(data);
        console.info(status);
        console.info(request);
        console.info(request.responseJSON);
        // neki get post
        getPost(id);
      },
      error: showErrors,
    });
  });

  // END POST LIKE

  // ORDER POSTS
  $("body").on("change", "#order-posts", function () {
    let selected = $(this).val();
    if (selected != 0) {
      $("#clear-sort").fadeIn(400);
      getPostsResponse();
    } else {
      $("#clear-sort").fadeOut(400);
    }
  });

  // END ORDER POSTS

  // FILTER POSTS BY TITLE

  $("body").on("keyup", "#search-title", function () {
    let title = $(this).val();
    !isNullOrWhitespace(title)
      ? $("#clear-title").fadeIn(400)
      : $("#clear-title").fadeOut(400);
    getPostsResponse();
  });

  // END FILTER POSTS BY TITLE

  // PAGINATE POSTS

  $("body").on("click", ".posts-pagination", function (е) {
    е.preventDefault();
    let limit = $(this).data("limit");
    let el = $(this)[0].outerHTML;
    $("#selected-started-at").val(limit);
    $("#selected-page").html(el);
    $("#show-selected-page").fadeIn(400);
    getPostsResponse();
  });

  // END PAGINATE POSTS

  // FILTER POSTS BY CATEGORY INDEX
  $("body").on("click", ".post-category", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let seletedEl = $(this)[0].outerHTML;
    $("#category-toggle").html("Selected category");
    $("#selected-category").html(seletedEl);
    $("#selected-category-value").val(id);
    $("#selected-category").fadeIn(400);
    $("#clear-category").fadeIn(400);
    getPostsResponse();
  });

  // END FILTER POSTS BY CATEGORY INDEX

  // PER PAGE POSTS NAV
  $("body").on("change", "#offset-posts", function () {
    let selected = $(this).val();
    $("#selected-offset").val(selected);
    getPostsResponseNav();
  });

  // END PER PAGE POSTS NAV

  // PER PAGE POSTS INDEX
  $("body").on("change", "#offset-posts-main", function () {
    let selected = $(this).val();
    $("#selected-offset-main").val(selected);
    getPostsResponse();
  });

  // END PER PAGE POSTS INDEX

  // PER PAGE COMMENTS POST DETAIL
  $("body").on("change", "#offset-comments-main", function () {
    let selected = $(this).val();
    let postId = $("#selected-offset-comments-main").data("post");
    $("#selected-offset-comments-main").val(selected);
    getComments(postId);
  });

  // END PER PAGE COMMENTS POST DETAIL

  // FILTER POSTS BY CATEGORY NAV-HOVER
  $("body").on("click", ".post-category-nav", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let categoryName = $(this)[0].childNodes[0].innerHTML;
    $("#clear-nav-posts-form-button").fadeIn(400);
    $("#selected-category-nav").val(id);
    $("#latest-posts-nav-title").html(`LATEST IN: ${categoryName}`);
    getPostsResponseNav();
  });

  // END FILTER POSTS BY CATEGORY NAV-HOVER

  $("body").on("click", "#clear-nav-posts-form", function (e) {
    e.preventDefault();
    clearForm("nav");
  });

  $("body").on("click", "#clear-category", function (e) {
    e.preventDefault();
    clearForm("category");
  });

  $("body").on("click", "#clear-page", function (e) {
    e.preventDefault();
    clearForm("page");
  });

  $("body").on("click", "#clear-title", function (e) {
    e.preventDefault();
    clearForm("title");
  });

  $("body").on("click", "#clear-sort", function (e) {
    e.preventDefault();
    clearForm("sort");
  });

  $("body").on("click", ".close-toast", function () {
    $("#error-toast").fadeOut(400);
    $("#success-toast").fadeOut(400);
  });

  // END POST SECTION

  // EXPORT AUTHOR SECTION

  $("body").on("click", "#export-word", function (e) {
    e.preventDefault();
    let aboutAuthor = $("#about-author").html();
    let aboutProject = $("#about-project").html();
    let skillNameEl = document.getElementsByClassName("skill-name");
    let skillRatesEl = document.getElementsByClassName("skill-rate");

    let skillNames = [];
    let skillRates = [];
    let skills = [];

    for (let skillName of skillNameEl) {
      skillNames.push({
        id: skillName.childNodes[0].getAttribute("data-id"),
        name: skillName.childNodes[0].innerHTML,
      });
    }

    for (let skillRate of skillRatesEl) {
      skillRates.push({
        id: skillRate.getAttribute("data"),
        rate: skillRate.innerHTML,
      });
    }

    skillNames.forEach((x) => {
      skillRates.forEach((y) => {
        if (parseInt(x.id) === parseInt(y.id)) {
          skills.push({ id: parseInt(x.id), name: x.name, rate: y.rate });
        }
      });
    });

    Export2Doc("about", "author");
    // console.log(skills, aboutAuthor, aboutProject);
    // $.ajax({
    //   url: `views/pages/author.php`,
    //   method: "POST",
    //   data: {
    //     exportAuthor: "hello",
    //     skills: skills,
    //     aboutme: aboutAuthor,
    //     aboutproj: aboutProject,
    //   },
    //   success: function (data) {
    //     console.log(data);
    //   },
    //   error: function (greska, status, statusText) {
    //     console.log(greska.parseJSON);
    //   },
    // });
  });
  // END EXPORT AUTHOR SECTION

  // COMMENTS SECTION

  // PAGINATE COMMENTS

  $("body").on("click", ".comments-pagination", function (е) {
    е.preventDefault();
    let limit = $(this).data("limit");
    let postId = $(this).data("post");

    $("#selected-page-comments").val(limit);
    $("#current-comm-page").html(`Page : ${limit + 1}`);
    getComments(postId);
  });

  // END PAGINATE COMMENTS

  // COMMENT TOGGLE EDIT SECTION

  var hiddenComments = [];

  $("body").on("click", ".toggle-edit-comment", function (e) {
    e.preventDefault();
    if (hiddenComments.length > 0) {
      hiddenComments.forEach((x) => {
        $(`#comment-${x}`).fadeIn(400);
      });
      hiddenComments = [];
    }
    let id = $(this).data("id");
    let postId = $(this).data("post");
    let content = $(`#comment-content-${id}`).html();
    hiddenComments.push(id);
    let editEl = $("#edit-comment");
    $("#edit-comment-content").val(content);
    $("#btn-save-edit-comment-content").data("post", postId);
    $("#btn-save-edit-comment-content").data("id", id);
    $("#btn-cancel-edit-comment-content").data("id", id);
    let commentEl = $(`#comment-${id}`);
    commentEl.after(editEl);
    commentEl.fadeOut(400);
    editEl.fadeIn(400);
  });

  // COMMENT TOGGLE EDIT SECTION

  // COMMENT LIKE

  $("body").on("click", ".toggle-like-comment", function (e) {
    e.preventDefault();

    let id = $(this).data("id");
    let postId = $(this).data("post");

    // AJAX CALL

    $.ajax({
      method: "POST",
      url: "models/comments/like.php",
      data: {
        id: id,
        btnLikeComment: "like",
      },
      dataType: "json",
      success: function (data, status, request) {
        switch (request.status) {
          case 201:
            console.info(`${request.status}: ${request.statusText}`);
            printSuccessToast("Successfully liked a comment.");
            $("#success-toast").fadeOut(4000);
            break;
          case 200:
            console.info(`${request.status}: ${request.statusText}`);
            break;
          case 204:
            console.info(`${request.status}: ${request.statusText}`);
            printSuccessToast("Successfully unliked a comment.");
            $("#success-toast").fadeOut(4000);
            break;
        }
        console.info(data);
        console.info(status);
        console.info(request);
        console.info(request.responseJSON);
        getComments(postId);
      },
      error: showErrors,
    });
  });

  // END COMMENT LIKE

  // PATCH COMMENT CONTENT

  $("body").on("click", "#btn-save-edit-comment-content", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let postId = $(this).data("post");

    let content = document.querySelector("#edit-comment-content").value.trim();
    let errors = [];
    if (isNullOrWhitespace(content) || content.length < 3) {
      errors.push("<strong>Content : </strong>Min: 3 characters.");
    }

    if (errors.length != 0) {
      let errorElement = $("#errors");
      $("#edit-comment").after(errorElement);
      printErrors(errors);
    } else {
      $("#errors").fadeOut(400);

      // AJAX CALL

      $.ajax({
        method: "POST",
        url: "models/comments/patch-content.php",
        data: {
          id: id,
          content: content,
          btnPatchCommentContent: "patch",
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
          printSuccessToast("Successfully updated a comment."); // SUCCESS TOAST !!!!!!!
          getComments(postId);
        },
        error: showErrors,
      });
    }
  });

  // END PATCH POST CONTENT

  // PATCH COMMENT CONTENT

  // ADD COMMENT

  $("body").on("click", "#comment-add", function () {
    let content = $("#comment-content").val();
    let postId = $(this).data("post");
    let errors = [];

    if (!isNullOrWhitespace(content)) {
      $("#errors").fadeOut(400);
      $.ajax({
        url: `models/comments/create.php`,
        method: "POST",
        dataType: "json",
        data: {
          btnCreateComment: "hello",
          content: content,
          postId: postId,
        },
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
          clearForm("comment");
          printSuccessToast("Successfully added a comment."); // SUCCESS TOAST !!!!!!!
          // setTimeout(
          //   window.location.replace(`index.php?page=posts&id=${data}`),
          //   5000
          // );

          getComments(postId);
        },
        error: showErrors,
      });
    } else {
      errors.push("<strong>Cannot be empty or contain only space.</strong>");
      let errorElement = $("#errors");
      $("#comment-content").after(errorElement);
      printErrors(errors);
    }
  });
  // END ADD COMMENT

  // EDIT COMMENT
  $("body").on("click", "#btn-cancel-edit-comment-content", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    $("#errors").fadeOut(400);
    $("#edit-comment").fadeOut(400);
    $(`#comment-${id}`).fadeIn(400);
  });

  // END EDIT COMMENT

  // DELETE COMMENT

  $("body").on("click", "#btn-delete-comment", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let postId = $(this).data("post");
    // AJAX CALL

    $.ajax({
      method: "POST",
      url: "models/comments/delete.php",
      data: {
        id: id,
        btnDeleteComment: "hello",
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
        $(".delete-comment-section").fadeOut(400);
        // setTimeout(
        //   window.location.replace(`index.php?page=posts&id=${postId}`),
        //   5000
        // );
        printSuccessToast("Successfully deleted a comment.");
        getComments(postId);
      },
      error: showErrors,
    });
  });

  // END DELETE COMMENT

  // END COMMENTS SECTION

  // image preview
  $("#uploaded-img").change(function () {
    readURL(this);
  });

  $("#uploaded-img-edit").change(function () {
    readURL(this);
  });

  // end image preview
});

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $(".blah").attr("src", e.target.result);
    };

    reader.readAsDataURL(input.files[0]);
  }
}

function printSuccess(heading, description) {
  $(".alert-success").removeClass("elementDissapear");
  let html = `<h4 class="alert-heading text-center">${heading} <i class="fa fa-check" aria-hidden="true"></i></h4>
  <p></p>
  <hr>
  <p class="mb-0 text-center">${description}</p>`;

  $(".alert-success").html(html);
}

function printErrors(errors) {
  let errorElement = $("#errors");
  errorElement.fadeIn(400);
  let html = `<div class="text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>`;
  for (let error of errors) {
    html += `
        <div class="text-center">
        ${error}
        </div>
      `;
  }
  $("#errors").html(html);
}

function printErrorsToast(errors) {
  let errorElement = $("#error-toast");
  errorElement.fadeIn(400);
  let html = "";
  for (let error of errors) {
    html += `
        <div class="mt-3">
        ${error}
        </div>
      `;
  }
  $("#print-errors").html(html);
}

function printSuccessToast(message) {
  let successElement = $("#success-toast");
  successElement.fadeIn(400);
  let html = `
        <div class="mt-3">
        ${message}
        </div>
      `;

  $("#print-success").html(html);
}

function showErrors(error, status, statusText) {
  console.error(status);
  console.error(error.responseText);
  console.error(error.responseJSON);

  printErrorsToast(error.responseJSON);

  switch (error.status) {
    case 400:
      console.error(`${error.status}: ${statusText}`);
      break;
    case 403:
      console.error(`${error.status}: ${statusText}`);
      break;
    case 404:
      console.error(`${error.status}: ${statusText}`);
      break;
    case 405:
      console.error(`${error.status}: ${statusText}`);
      break;
    case 409:
      console.error(`${error.status}: ${statusText}`);
      break;
    case 415:
      console.error(`${error.status}: ${statusText}`);
      break;
    case 422:
      console.error(`${error.status}: ${statusText}`);
      break;
    case 500:
      console.error(`${error.status}: ${statusText}`);
      break;
  }
}

function printPosts(posts) {
  let html = "";
  let crudBtns = "";
  let loggedUserRole = $("#loggedUserRole").val();

  for (let post of posts) {
    if (loggedUserRole !== undefined && loggedUserRole == 1) {
      crudBtns = `<div>
      <a style="background: #0d0d0d; border: 1px solid #222222;" href="index.php?page=posts&id=${post.id}">Edit</a>
      <a class="generic-switch generic-open" data-id="${post.id}" data-action="delete-post" style="background: rgba(194, 0, 0, 0.5)" href="#">Remove</a>
  </div>`;
    }
    html += `
    <div class="col-lg-6">
    <div class="cg-item">
        <div style='background-image: url("${
          post.src
        }")' class="cg-pic set-bg" data-setbg="${post.src}">
            <div class="label"><span>${post.category.toUpperCase()}</span></div>
        </div>
        <div class="cg-text">
            <h5><a href="index.php?page=posts&id=${post.id}">${post.title}</a></h5>
            <ul>
                <li>by <span>${post.username}</span></li>
                <li><i class="fa fa-clock-o"></i>${post.created_at}</li>
                <li><i class="fa fa-comment-o"></i> ${post.commNum}</li>
            </ul>
            <p class="word-wrap">${
              post.content.length > 300
                ? post.content.substr(0, 300) + " ..."
                : post.content
            }</p>
        </div>
        <div class="pagination-item mt-5">
        <div class="row justify-content-between">
            <div class="col-3">
                <a href="index.php?page=posts&id=${post.id}">Details</a>
            </div>
            ${crudBtns}
        </div>
    </div>
    </div>
</div>
    `;
  }

  $("#posts").html(html);
}

function printPostsNav(posts) {
  let html = "";
  for (let post of posts) {
    html += `<div class="mw-post-item">
    <div class="mw-pic">
        <img id="posts-nav-img-${post.id}" src="${post.src}" alt="${post.alt}">
    </div>
    <div class="mw-text">
        <h6><a href="index.php?page=posts&id=${post.id}">${post.title}</a></h6>
        <ul>
            <li><i class="fa fa-clock-o"></i>${formatDate(post.created_at)}</li>
            <li><i class="fa fa-comment-o"></i>${post.commNum}</li>
        </ul>
    </div>
</div>`;
  }
  $("#posts-nav").html(html);
}

function printPost(post, arrayOfLikers) {
  let loggedUserRole = $("#loggedUserRole").val();
  let crudBtn = "";
  if (loggedUserRole !== undefined && loggedUserRole == 1) {
    crudBtn += `
        <div class="mt-5 label"><a id="ed-post-img" class="text-white generic-switch generic-open" data-post="${post.id}" data-image="${post.src}" data-action="edit-post-image" href=""><i class="fa fa-wrench pr-2"></i> Change image</a></div>`;
  }
  let preview = `
  <section id="post-image-preview" class="details-hero-section set-bg" style='background-image: url("${
    post.src_small
  }")' data-setbg="${post.src_small}">
      <div class="container">
          <div class="row pr-5">
              <div class="col-lg-5">
                  <div class="details-hero-text">
                      <div class="label"><span class="category">${
                        post.category
                      }</span></div>
                      <h3>${post.title}</h3>
                      <ul>
                          <li>by <span>${post.username}</span></li>
                          <li><i class="fa fa-clock-o"></i>${formatDate(
                            post.created_at
                          )}</li>
                          <li id="post-preview-comments"><i class="fa fa-comment-o"></i>${
                            post.commNum
                          }</li>
                          <li><i class="fa fa-heart-o"></i>${
                            arrayOfLikers.length > 0 ? arrayOfLikers.length : ""
                          }</li>
                      </ul>
                    ${crudBtn}
                  </div>
              </div>
          </div>
      </div>
  </section>`;

  let postStatsLikes = `<div class="sm-icon"><i class="fa fa-heart-o"></i></div>
  <span>${arrayOfLikers.length} likes</span>`;
  $("#post-preview").html(preview);
  $("#post-likes").html(postStatsLikes);
  $("#post-liked-by-logged-user").html(
    checkIfLoggedUserLiked("post", post.id, arrayOfLikers)
      ? "UNLIKE POST"
      : "LIKE POST"
  );
}

function printPostDeleteModal(post) {
  // generic one for post,comment
  let html = "";
  html += `
    <div class="col-lg-6 offset-3">
    <div class="cg-item">
        <div style='background-image: url("${
          post.src
        }")' class="cg-pic set-bg" data-setbg="${post.src}">
            <div class="label"><span>${post.category.toUpperCase()}</span></div>
        </div>
        <div class="cg-text">
            <h5><a href="#">${post.title}</a></h5>
            <ul>
                <li>by <span>${post.username}</span></li>
                <li><i class="fa fa-clock-o"></i>${post.created_at}</li>
                <li><i class="fa fa-comment-o"></i> ${post.commNum}</li>
            </ul>
            <p>${
              post.content.length > 300
                ? post.content.substr(0, 300) + " ..."
                : post.content
            }</p>
        </div>
    </div>
</div>
    `;
  $("#delete_post").html(html);
}

function printComment(comment) {
  let html = "";
  html += `
    <div class="col-lg-6 offset-3">
    <div class="dc-item">
                <div class="dc-pic">
                    <img class="rounded-circle" src="assets/img/details/comment/comment-1.jpg" alt="">
                </div>
                <div class="dc-text">
                    <h5 class="pt-3 text-white">${comment.username}</h5>
                    <span class="c-date text-white"><i class="fa fa-clock-o"></i> ${formatDate(
                      comment.created_at
                    )}</span>
                    <p class="word-wrap">${
                      comment.content
                    }</p>                  
                </div>
            </div>
</div>
    `;
  $("#delete_comment").html(html);
}

function isNullOrWhitespace(input) {
  if (typeof input === "undefined" || input == null) return true;
  return input.replace(/\s/g, "").length < 1;
}

function clearForm(formName) {
  switch (formName) {
    case "nav":
      $("#clear-nav-posts-form-button").fadeOut(400);
      $("#selected-category-nav").val("");
      // $("#selected-offset").val(5);
      // $("#offset-posts").val(5);
      $("#latest-posts-nav-title").html("LATEST");
      getPostsResponseNav();
      break;
    case "comment":
      $("#comment-content").val("");
      break;
    case "category":
      $("#category-toggle").html("Categories");
      $("#selected-category-value").val("");
      $("#selected-category").fadeOut(400);
      $("#clear-category").fadeOut(400);
      getPostsResponse();
      break;
    case "page":
      $("#selected-started-at").val(0);
      $("#selected-page").html("");
      $("#show-selected-page").fadeOut(400);
      getPostsResponse();
      break;
    case "title":
      $("#search-title").val("");
      $("#clear-title").fadeOut(400);
      getPostsResponse();
      break;
    case "sort":
      $("#order-posts").val(0);
      $("#clear-sort").fadeOut(400);
      getPostsResponse();
      break;
  }
}

function printPagination(pages, name, perPage, postId = 0) {
  let arrayOfPagingValues = [
    {
      value: 4,
      selected: "",
    },
    {
      value: 10,
      selected: "",
    },
    {
      value: 20,
      selected: "",
    },
  ];

  arrayOfPagingValues.forEach((x) => {
    if (x.value === perPage) {
      x.selected = "selected";
    }
  });
  let html = `<div class="row">
     <div class="col">`;
  let cl = "posts-pagination";
  let renderArea = $("#pag");
  let post = "";

  if (name !== "posts") {
    cl = "comments-pagination";
    renderArea = $("#pag-comments");
    post = `data-post="${postId}"`;
  }

  for (let i = 0; i < pages; i++) {
    html += `<a href="#" class="${cl}" ${post} data-limit="${i}"><span>${
      i + 1
    }</span></a>`;
  }
  html += `</div><div class="col">
  <select id="offset-${name}-main" class="ddl">
   `;
  for (let option of arrayOfPagingValues) {
    html += `<option value="${option.value}" ${option.selected}>${option.value}</option>`;
  }
  html += `</select>
   </div>
   </div>`;
  renderArea.html(html);
}

function getPostsResponseNav() {
  let category_id = $("#selected-category-nav").val();
  let perPage = $("#selected-offset").val();
  perPage = !isNullOrWhitespace(perPage) ? perPage : 5;
  category_id = !isNullOrWhitespace(category_id) ? category_id : "";
  $.ajax({
    url: `models/posts/get-all-response.php`,
    method: "POST",
    dataType: "json",
    data: {
      btnGetPosts: "hello",
      id_category: category_id,
      offset: perPage,
    },
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
      printPostsNav(data.content);
    },
    error: showErrors,
  });
}

function getPostsResponse() {
  let category = $("#selected-category-value").val();
  let title = $("#search-title").val();
  let sort = $("#order-posts").val();
  let page = $("#selected-started-at").val();
  let perPage = $("#selected-offset-main").val();

  if (isNullOrWhitespace(category)) {
    category = "";
  }
  if (isNullOrWhitespace(title)) {
    title = "";
  }
  if (isNullOrWhitespace(sort)) {
    sort = 3;
  }
  if (isNullOrWhitespace(page)) {
    page = 0;
  }
  if (isNullOrWhitespace(perPage)) {
    perPage = 4;
  }

  $.ajax({
    url: `models/posts/get-all-response.php`,
    method: "POST",
    dataType: "json",
    data: {
      btnGetPosts: "hello",
      sort: sort,
      title: title,
      id_category: category,
      page: page,
      offset: perPage,
    },
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
      printPosts(data.content);
      printPagination(data.totalPages, "posts", data.perPage);
      refreshExportExcelData(data.content);
    },
    error: showErrors,
  });
}

function getComments(postId) {
  let page = $("#selected-page-comments").val();
  let perPage = $("#selected-offset-comments-main").val();
  perPage = !isNullOrWhitespace(perPage) ? perPage : 4;
  $.ajax({
    url: `models/comments/get-all-by-post.php`,
    method: "POST",
    dataType: "json",
    data: {
      btnGetComments: "hello",
      id_post: postId,
      page: page,
      offset: perPage,
    },
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

      let postStatsComments = `<div class="sm-icon"><i class="fa fa-comment-o"></i></div>
      <span>${data.totalElements} comments</span>`;
      let postPreviewComments = `<i class="fa fa-comment-o"></i>${data.totalElements}`;
      $("#total-comments").html(`Total : ${data.totalElements} comments`);
      $("#post-stats-comments").html(postStatsComments);
      $("#post-preview-comments").html(postPreviewComments);
      printComments(data.content, postId, data.usersWhoLiked);
      printPagination(data.totalPages, "comments", data.perPage, postId);

      // if (data.totalPages - 1 != page) { next btn
      //   $("#pag-comments").append(
      //     `<a href="#" class="comments-pagination" data-post="${postId}" data-limit="${
      //       parseInt(page) + 1
      //     }"><span>Next</span></a>` not to be concerned right now
      //   );
      // }
    },
    error: showErrors,
  });
}

function getPost(id) {
  $.ajax({
    url: `models/posts/get-one-with-likers.php`,
    method: "POST",
    dataType: "json",
    data: {
      btnGetPost: "hello",
      id: id,
    },
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
      // neki print celog sadrzaja posta
      printPost(data.content, data.usersWhoLiked);
    },
    error: showErrors,
  });
}

function printComments(comments, postId, arrayOfLikers) {
  let html = "";
  let crudBtns = "";
  let loggedUserRole = $("#loggedUserRole").val();
  let loggedUserId = $("#loggedUserId").val();
  let loggedUserUsername = $("#loggedUserUsername").val();

  for (let comment of comments) {
    if (loggedUserRole !== undefined) {
      crudBtns = `<div class="row">
      <div class="ml-4 dt-tags">
          <a href="#" class="toggle-like-comment" data-id="${
            comment.id
          }" data-post="${postId}"><span><i style="color:${
        checkIfLoggedUserLiked("comment", comment.id, arrayOfLikers)
          ? "red"
          : ""
      }" class="fa fa-heart" aria-hidden="true"></i></span> <strong>${
        parseInt(comment.totalUsersLiked) != 0 ? comment.totalUsersLiked : ""
      }</strong></a>`;
    }
    if (comment.created_by == loggedUserId) {
      crudBtns += `<a href="#" class="toggle-edit-comment" data-id="${comment.id}" data-post="${postId}"><span><i class="fa fa-wrench" aria-hidden="true"></i></span></a>`;
    }
    if (loggedUserRole == 1 || comment.created_by == loggedUserId) {
      crudBtns += `<a href="#" class="generic-switch generic-open" data-id="${comment.id}" data-action="delete-comment"><span><i class="fa fa-times" aria-hidden="true"></i></span></a></div></div>`;
    }
    // if (loggedUserId !== undefined) {
    //   crudBtns += `
    //   <div class="cancel-edit-comment">
    //       <a href="#" data-id="reply-btn-${comment.id}" class="reply-btn"><span>Reply</span></a>
    //   </div>`;
    // }
    html += `
    <div id="comment-${comment.id}" class="dc-item">
    <div class="dc-pic">
        <img src="assets/img/details/comment/comment-1.jpg" alt="">
    </div>
    <div class="dc-text">
        <h5>${comment.username}</h5>
        <span class="c-date">${formatDate(comment.created_at)}</span>
        <p id="comment-content-${comment.id}" class="word-wrap">${
      comment.content
    }</p>
              ${crudBtns}
      </div>
</div>
<div id="edit-comment" class="dc-item elementDissapear">
<div class="dc-pic">
    <img src="assets/img/details/comment/comment-1.jpg" alt="">
</div>
<div class="dc-text">
    <h5>${loggedUserUsername}</h5>
    <div class="mt-3 dt-leave-comment">
        <form action="#">
            <textarea id="edit-comment-content" class="comment-content-edit text-white" placeholder="Message"></textarea>
            <div class="row">
            <div class="col-1"></div>
            <div class="col-4">
                <button type="button" id="btn-save-edit-comment-content" data-id=""><span>Save</span></button>
            </div>
            <div class="col-2"></div>
            <div class="col-4">
                <button type="button" id="btn-cancel-edit-comment-content" data-id=""><span>Cancel</span></button>
            </div>
            <div class="col-1"></div>
        </div>
        </form>
    </div>
</div>
</div>
</div>
      `;
  }
  $("#post-comments").html(html);
}

function formatDate(date) {
  let newDate = new Date(date);
  const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "Dec",
  ];
  var time =
    appendLeadingZeroes(newDate.getHours()) +
    ":" +
    appendLeadingZeroes(newDate.getMinutes());
  let formatted_date = `${
    months[newDate.getMonth()]
  } ${newDate.getDate()}, ${newDate.getFullYear()}. ${time}`;

  return formatted_date;
}

function generateFormatedCurrentDate() {
  let newDate = new Date();
  const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "Jun",
    "July",
    "August",
    "September",
    "October",
    "November",
    "Dec",
  ];
  var time =
    appendLeadingZeroes(newDate.getHours()) +
    ":" +
    appendLeadingZeroes(newDate.getMinutes());
  let formatted_date = `${
    months[newDate.getMonth()]
  } ${newDate.getDate()}, ${newDate.getFullYear()}. ${time}`;

  return formatted_date;
}

function appendLeadingZeroes(n) {
  if (n <= 9) {
    return "0" + n;
  }
  return n;
}

// EXPORTS

// EXPORT WORD AUTHOR

function Export2Doc(element, filename = "") {
  var preHtml =
    "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
  var postHtml = "</body></html>";
  var html = preHtml + document.getElementById(element).innerHTML + postHtml;
  var blob = new Blob(["\ufeff", html], {
    type: "application/msword",
  });

  // Specify link url
  var url =
    "data:application/vnd.ms-word;charset=utf-8," + encodeURIComponent(html);

  // Specify file name
  filename = filename ? filename + ".doc" : "document.doc";

  // Create download link element
  var downloadLink = document.createElement("a");

  document.body.appendChild(downloadLink);

  if (navigator.msSaveOrOpenBlob) {
    navigator.msSaveOrOpenBlob(blob, filename);
  } else {
    // Create a link to the file
    downloadLink.href = url;

    // Setting the file name
    downloadLink.download = filename;

    //triggering the function
    downloadLink.click();
  }

  document.body.removeChild(downloadLink);
}

// EXPOR EXCEL LATEST POSTS

function exportTableToExcel(tableID, filename = "") {
  var downloadLink;
  var dataType = "application/vnd.ms-excel";
  var tableSelect = document.getElementById(tableID);
  var tableHTML = tableSelect.outerHTML.replace(/ /g, "%20");

  // Specify file name
  filename = filename ? filename + ".xls" : "excel_data.xls";

  // Create download link element
  downloadLink = document.createElement("a");

  document.body.appendChild(downloadLink);

  if (navigator.msSaveOrOpenBlob) {
    var blob = new Blob(["\ufeff", tableHTML], {
      type: dataType,
    });
    navigator.msSaveOrOpenBlob(blob, filename);
  } else {
    // Create a link to the file
    downloadLink.href = "data:" + dataType + ", " + tableHTML;

    // Setting the file name
    downloadLink.download = filename;

    //triggering the function
    downloadLink.click();
  }
}

//END OF EXPORTS

// helper functions

function checkIfLoggedUserLiked(type, id, arrayOfLikers) {
  let loggedUserId = $("#loggedUserId").val();
  if (type === "comment") {
    // switch if needed, for now keep it simple
    for (let user of arrayOfLikers) {
      if (user.id_comment == id && user.id_user == loggedUserId) {
        return true;
      }
    }
  } else {
    for (let user of arrayOfLikers) {
      if (user.id_post == id && user.id_user == loggedUserId) {
        return true;
      }
    }
  }
  return false;
}

function refreshExportExcelData(posts) {
  let html = `
  <tr>
      <th>Title</th>
      <th>Category</th>
      <th>Content</th>
      <th>Posting date</th>
      <th>Owner</th>
      <th>Total comments</th>
  </tr>`;

  for (let post of posts) {
    html += `
  <tr>
    <td>${post.title}</td>
    <td>${post.category}</td>
    <td>${post.content}</td>
    <td>${formatDate(post.created_at)}</td>
    <td>${post.username}</td>
    <td>${post.commNum}</td>
  </tr>
    `;
  }
  html += "</table>";

  $("#tblData").html(html);
}
