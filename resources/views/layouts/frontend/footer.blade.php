
<script src="{{ asset('js/userapp.js') }}"></script>
<!-- Infographics Image Popup Script -->
<script>
    $(document).ready(function () {

$("section img").click(function() {
  $(".lightbox").fadeIn(300);
  $(".lightbox").append("<img src='" + $(this).attr("src") + "' alt='" + $(this).attr("alt") + "' />");
  $(".filter").css("background-image", "url(" + $(this).attr("src") + ")");
  
  $("html").css("overflow", "hidden");
  // if ($(this).is(":last-child")) {
  //   $(".arrowr").css("display", "none");
  //   $(".arrowl").css("display", "block");
  // } else if ($(this).is(":first-child")) {
  //   $(".arrowr").css("display", "block");
  //   $(".arrowl").css("display", "none");
  // } else {
  //   $(".arrowr").css("display", "block");
  //   $(".arrowl").css("display", "block");
  // }
});

$(".closeimg").click(function() {
  $(".lightbox").fadeOut(300);
  $(".lightbox img").remove();
  $("html").css("overflow", "auto");
});

$(document).keyup(function(e) {
  if (e.keyCode == 27) {
    $(".lightbox").fadeOut(300);
    $(".lightbox img").remove();
    $("html").css("overflow", "auto");
  }
});

$(".arrowr").click(function() {
  var imgSrc = $(".lightbox img").attr("src");
  var search = $("section").find("img[src$='" + imgSrc + "']");
  var newImage = search.next().attr("src");
  /*$(".lightbox img").attr("src", search.next());*/
  $(".lightbox img").attr("src", newImage);
  $(".filter").css("background-image", "url(" + newImage + ")");

  if (!search.next().is(":last-child")) {
    $(".arrowl").css("display", "block");
  } else {
    $(".arrowr").css("display", "none");
  }
});

$(".arrowl").click(function() {
  var imgSrc = $(".lightbox img").attr("src");
  var search = $("section").find("img[src$='" + imgSrc + "']");
  var newImage = search.prev().attr("src");
  /*$(".lightbox img").attr("src", search.next());*/
  $(".lightbox img").attr("src", newImage);
  $(".filter").css("background-image", "url(" + newImage + ")");

  if (!search.prev().is(":first-child")) {
    $(".arrowr").css("display", "block");
  } else {
    $(".arrowl").css("display", "none");
  }
});

});
  </script>

<script>

    $(document).ready(function() {
        var s = $("#wrapper");
        var pos = s.position();
        $(window).scroll(function() {
            var windowpos = $(window).scrollTop();
            if (windowpos >= pos.top) {
                $(".feed-shared").remove();
            } else {
            }
        });
    });
    $(document).ready(function () {
    $(".promo-code a").click(function () {
        $(this).next("form").slideToggle();
    });

    $('#dotsdesk').click(function(){
      
      $('.menulink').slideToggle();
  });
  $('#dotsmob').click(function(){
      
      $('.menulinkmob').slideToggle();
  });
    });



    function openNav() {
        document.getElementById("mySidenav").style.left = "0";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.left = "-300px";
    }

</script>
