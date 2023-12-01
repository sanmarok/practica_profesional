document.addEventListener("DOMContentLoaded", function () {
  $(function () {
    $("#tableinvoices")
      .DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
      })
      .buttons()
      .container()
      .appendTo("#tableinvoices_wrapper .col-md-6:eq(0)");
  });
});
