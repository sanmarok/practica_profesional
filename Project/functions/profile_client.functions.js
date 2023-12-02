document.addEventListener("DOMContentLoaded", function () {
  $(function () {
    $("#example1")
      .DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
      })
      .buttons()
      .container()
      .appendTo("#example1_wrapper .col-md-6:eq(0)");
    $("#example3")
      .DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
      })
      .buttons()
      .container()
      .appendTo("#example3_wrapper .col-md-6:eq(0)");
  });
});

function isValidDireccion(value) {
  // Validar que la dirección tenga al menos 5 caracteres, incluyendo al menos un espacio
  return /^(?=.*\s)[a-zA-Z0-9\s.,#-]{5,}$/.test(value);
}

function validationAddClientServiceForm() {
  // Obtener los valores de los campos
  var selectedService = document
    .getElementById("exampleSelectBorder")
    .value.trim();
  var direccion = document.getElementById("direccion").value.trim();

  // Validar que se haya seleccionado un servicio
  if (selectedService === "") {
    handleValidation(
      "exampleSelectBorder",
      "Por favor, selecciona un servicio."
    );
    return;
  } else {
    showValidationIcon("exampleSelectBorder");
  }

  // Validar que la dirección contenga letras, números y espacios
  if (!isValidDireccion(direccion)) {
    handleValidation(
      "direccion",
      "Por favor, ingresa una dirección válida (letras, números y espacios)."
    );
    return;
  } else {
    showValidationIcon("direccion");
  }

  addClientService();
}

// Función para manejar la validación
function handleValidation(inputId, errorMessage) {
  // Marcar el campo como inválido y ocultar el icono de validación
  var input = document.getElementById(inputId);
  input.classList.add("is-invalid");
  input.classList.remove("is-valid");
  input.nextElementSibling.innerHTML = errorMessage;
}

// Función para mostrar el icono de validación
function showValidationIcon(inputId) {
  // Mostrar el icono de validación (check) y marcar el campo como válido
  var input = document.getElementById(inputId);
  input.classList.remove("is-invalid");
  input.classList.add("is-valid");
}

function addClientService() {
  // Obtener los datos del formulario
  var service_id = document.getElementById("exampleSelectBorder").value;
  var direccion = document.getElementById("direccion").value;
  var client_id = document.getElementById("id_client").value;

  // Crear un objeto con los datos que deseas enviar
  var serviceData = {
    client_id: client_id,
    service_id: service_id,
    direccion: direccion,
  };

  // Realizar una llamada AJAX para enviar los datos al servidor
  fetch("../functions/add_services_client.php", {
    method: "POST",
    body: JSON.stringify(serviceData),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      // Aquí puedes manejar la respuesta del servidor
      if (data.success) {
        // La operación se completó exitosamente, puedes cerrar el modal o hacer otras acciones
        $("#modalContratarServicio").modal("hide");
        Swal.fire({
          icon: "success",
          title: "Contratación exitosa.",
          showConfirmButton: false,
          timer: 500,
        }).then(() => {
          window.location.reload();
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Error al contratar el servicio. Detalles: " + data.error,
          showConfirmButton: true,
        });
      }
    })
    .catch((error) => {
      Swal.fire({
        icon: "error",
        title: "Error",
        text:
          "Error de red o al procesar la solicitud. Detalles: " + error.message,
        showConfirmButton: true,
      });
    });
}
