function suggetion() {
  $("#sug_input").keyup(function (e) {
    var formData = {
      product_name: $("input[name=title]").val(),
    };

    if (formData["product_name"].length >= 1) {
      // process the form
      $.ajax({
        type: "POST",
        url: "ajax.php",
        data: formData,
        dataType: "json",
        encode: true,
      }).done(function (data) {
        //console.log(data);
        $("#result").html(data).fadeIn();
        $("#result li").click(function () {
          $("#sug_input").val($(this).text());
          $("#result").fadeOut(500);
        });

        $("#sug_input").blur(function () {
          $("#result").fadeOut(500);
        });
      });
    } else {
      $("#result").hide();
    }

    e.preventDefault();
  });
}
$("#sug-form").submit(function (e) {
  var formData = {
    p_name: $("input[name=title]").val(),
  };
  // process the form
  $.ajax({
    type: "POST",
    url: "ajax.php",
    data: formData,
    dataType: "json",
    encode: true,
  })
    .done(function (data) {
      //console.log(data);
      $("#product_info").html(data).show();
      total();
      $(".datePicker").datepicker("update", new Date());
    })
    .fail(function () {
      $("#product_info").html(data).show();
    });
  e.preventDefault();
});
function total() {
  $("#product_info input").change(function (e) {
    var price = +$("input[name=price]").val() || 0;
    var qty = +$("input[name=quantity]").val() || 0;
    var total = qty * price;
    $("input[name=total]").val(total.toFixed(2));
  });
}

// ========================================
// MOBILE MENU FUNCTIONALITY
// ========================================
function initMobileMenu() {
  // Create mobile menu toggle button if it doesn't exist
  if ($('.mobile-menu-toggle').length === 0) {
    var mobileMenuBtn = `
      <button class="mobile-menu-toggle" aria-label="Toggle Menu">
        <span></span>
        <span></span>
        <span></span>
      </button>
    `;
    $('body').prepend(mobileMenuBtn);
  }

  // Create sidebar overlay if it doesn't exist
  if ($('.sidebar-overlay').length === 0) {
    $('body').append('<div class="sidebar-overlay"></div>');
  }

  // Toggle mobile menu
  $('.mobile-menu-toggle').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    toggleMobileMenu();
  });

  // Close menu when clicking overlay
  $('.sidebar-overlay').on('click', function() {
    closeMobileMenu();
  });

  // Close menu when clicking a sidebar link
  $('.sidebar ul li a').on('click', function() {
    if ($(window).width() <= 768) {
      closeMobileMenu();
    }
  });

  // Close menu on window resize if desktop size
  $(window).on('resize', function() {
    if ($(window).width() > 768) {
      closeMobileMenu();
    }
  });

  // Prevent body scroll when menu is open
  function preventBodyScroll(prevent) {
    if (prevent) {
      $('body').css('overflow', 'hidden');
    } else {
      $('body').css('overflow', '');
    }
  }

  // Toggle menu function
  function toggleMobileMenu() {
    $('.mobile-menu-toggle').toggleClass('active');
    $('.sidebar').toggleClass('active');
    $('.sidebar-overlay').toggleClass('active');
    
    var isActive = $('.sidebar').hasClass('active');
    preventBodyScroll(isActive);
  }

  // Close menu function
  function closeMobileMenu() {
    $('.mobile-menu-toggle').removeClass('active');
    $('.sidebar').removeClass('active');
    $('.sidebar-overlay').removeClass('active');
    preventBodyScroll(false);
  }

  // Handle touch events for better mobile experience
  var touchStartX = 0;
  var touchEndX = 0;

  $(document).on('touchstart', function(e) {
    touchStartX = e.changedTouches[0].screenX;
  });

  $(document).on('touchend', function(e) {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
  });

  function handleSwipe() {
    // Swipe from left to right (open menu)
    if (touchEndX > touchStartX + 50 && touchStartX < 50) {
      if (!$('.sidebar').hasClass('active')) {
        toggleMobileMenu();
      }
    }
    // Swipe from right to left (close menu)
    if (touchStartX > touchEndX + 50 && $('.sidebar').hasClass('active')) {
      closeMobileMenu();
    }
  }
}

$(document).ready(function () {
  // CSRF Token Setup for AJAX
  $.ajaxSetup({
    data: {
      csrf_token: $('meta[name="csrf-token"]').attr("content"),
    },
  });

  //tooltip
  $('[data-toggle="tooltip"]').tooltip();

  $(".submenu-toggle").click(function () {
    $(this).parent().children("ul.submenu").toggle(200);
  });
  //suggetion for finding product names
  suggetion();
  // Callculate total ammont
  total();

  $(".datepicker").datepicker({
    format: "yyyy-mm-dd",
    todayHighlight: true,
    autoclose: true,
  });

  // Initialize mobile menu
  initMobileMenu();
});

