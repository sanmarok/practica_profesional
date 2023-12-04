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

function addClientService() {
  // Obtener los datos del formulario
  var service_id = document.getElementById("exampleSelectBorder").value;
  var direccion =
    document.getElementById("city").value +
    ", " +
    document.getElementById("street").value +
    " " +
    document.getElementById("number").value;
  var client_id = document.getElementById("id_client").value;

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

function validationAddClientServiceForm() {
  // Obtener los valores de los campos
  var selectedService = document
    .getElementById("exampleSelectBorder")
    .value.trim();
  var city = document.getElementById("city").value.trim();
  var street = document.getElementById("street").value.trim();
  var number = document.getElementById("number").value.trim();

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

  // Validar el departamento (city)
  if (city === "") {
    handleValidation("city", "Por favor, selecciona un departamento.");
    return;
  } else {
    showValidationIcon("city");
  }

  // Validar la calle
  if (street.length < 2) {
    handleValidation(
      "street",
      "Por favor, ingresa una calle válida (mínimo 2 caracteres)."
    );
    return;
  } else {
    showValidationIcon("street");
  }

  // Validar el número
  if (!/^\d+$/.test(number)) {
    handleValidation("number", "Por favor, ingresa un número válido.");
    return;
  } else {
    showValidationIcon("number");
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

function guardarSolicitud(clientServiceId) {
  var formId = "formSolicitudTecnica" + clientServiceId;
  var form = document.getElementById(formId);

  // Verifica si los campos están vacíos
  if (form.checkValidity() === false) {
    event.preventDefault();
    event.stopPropagation();
  } else {
    addRequest(clientServiceId);
  }

  form.classList.add("was-validated");
}

function addRequest(clientServiceId) {
  // Obtén los datos del formulario específico
  var formData = {
    clientServiceId: clientServiceId,
    descripcion: $("#descripcion" + clientServiceId).val(),
    problem: $("#problem" + clientServiceId).val(),
    status: 3,
    type: 1,
  };

  // Realiza la llamada AJAX utilizando fetch
  fetch("../functions/add_request.php", {
    method: "POST",
    body: JSON.stringify(formData),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      // Manejar la respuesta del servidor
      if (data.success) {
        // Acciones cuando la solicitud es exitosa
        Swal.fire({
          icon: "success",
          title: "Solicitud exitosa",
          text: data.message,
        }).then(() => {
          // Recargar la página
          location.reload();
        });
      } else {
        // Acciones cuando hay un error en la solicitud
        Swal.fire({
          icon: "error",
          title: "Error en la solicitud",
          text: data.error,
        });
      }
    })
    .catch((error) => {
      // Manejar errores de la llamada fetch
      Swal.fire({
        icon: "error",
        title: "Error en la solicitud",
        text: "Hubo un error al procesar la solicitud.",
      });
    });
}
