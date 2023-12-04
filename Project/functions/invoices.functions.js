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

function confirmBilling() {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "Este proceso realizará la facturación total. ¿Comprendes lo que estás por hacer?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, estoy seguro",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      generateInvoices();
    }
  });
}

function generateInvoices() {
  // Realizar la llamada AJAX
  $.ajax({
    url: "../functions/generate_invoices.php",
    type: "POST",
    dataType: "json",
    data: {
      action: "generate_invoices", // Puedes enviar datos adicionales si es necesario
    },
    success: function (response) {
      // Manejar la respuesta del servidor
      switch (response.status) {
        case "success":
          if (response.num_invoices > 0) {
            Swal.fire({
              title: "Facturas generadas",
              text: `Se generaron ${response.num_invoices} facturas.`,
              icon: "success",
            }).then(() => {
              window.location.reload();
            });
          } else {
            Swal.fire({
              title: "Generación exitosa",
              text: "No se generaron facturas en esta ocasión.",
              icon: "warning",
            }).then(() => {
              window.location.reload();
            });
          }
          break;
        case "error":
          Swal.fire({
            title: "Error al generar facturas",
            text: response.message,
            icon: "error",
            confirmButtonText: "Cerrar",
          });
          break;
        default:
          Swal.fire({
            title: "Respuesta desconocida del servidor",
            text: "Se recibió una respuesta desconocida del servidor.",
            icon: "warning",
            confirmButtonText: "Cerrar",
          });
          break;
      }
    },
    error: function (xhr, status, error) {
      // Manejar errores de la llamada AJAX
      Swal.fire({
        title: "Error en la llamada AJAX",
        text: `Hubo un error en la llamada AJAX: ${status} - ${error}`,
        icon: "error",
        confirmButtonText: "Cerrar",
      });
    },
  });
}

function reloadTableContent() {
  // Cargar el contenido de la tabla usando AJAX
  $("#tableinvoices").load(" #tableinvoices");
}
