(function ($) {
  "use strict";

  $(document).ready(function () {
    // Mobile Menu
    const sidebarToggle = $(".sidebar-toggler");
    if (sidebarToggle) {
      sidebarToggle.on("click", function () {
        $("body").toggleClass("sidebar-open");
        $(this).toggleClass("active");
      });
    }
    // Mobile Menu End
  });
})(jQuery);
