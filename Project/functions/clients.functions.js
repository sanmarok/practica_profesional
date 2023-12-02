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
      
  });
});

function addClient() {
  // Obtén los valores del formulario
  var first_name = document.getElementById("first_name").value;
  var last_name = document.getElementById("last_name").value;
  var documento = document.getElementById("documento").value;
  var phone = document.getElementById("phone").value;
  var email = document.getElementById("email").value;
  var state = 1;

  // Crea un objeto con los datos que deseas enviar
  var clientData = {
    first_name: first_name,
    last_name: last_name,
    document: documento,
    phone: phone,
    email: email,
    state: state,
  };

  // Realiza una llamada AJAX para enviar los datos al servidor
  fetch("../functions/add_client.php", {
    method: "POST",
    body: JSON.stringify(clientData),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      // Aquí puedes manejar la respuesta del servidor
      if (data.success) {
        // La operación se completó exitosamente, puedes cerrar el modal o hacer otras acciones
        $("#modalAgregarCliente").modal("hide");
        // Recarga la página o realiza otras acciones necesarias
        Swal.fire({
          icon: "success",
          title: "Cliente agregado exitosamente.",
          showConfirmButton: false,
          timer: 500,
        }).then(() => {
          //window.location.reload();
          reloadTableContent();
        });
      } else {
        // Si hay errores, muestra un mensaje de error detallado
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Error al agregar el cliente. Detalles: " + data.error,
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

function addClientValidationForm() {
  // Resetear clases y mensajes de retroalimentación
  resetValidation();

  // Obtener los valores de los campos
  var firstName = document.getElementById("first_name").value.trim();
  var lastName = document.getElementById("last_name").value.trim();
  var documentNumber = document.getElementById("documento").value.trim();
  var phone = document.getElementById("phone").value.trim();
  var email = document.getElementById("email").value.trim();

  // Validar Nombre
  if (!isValidName(firstName)) {
    handleValidation(
      "first_name",
      "Por favor, ingrese un nombre válido (solo letras, al menos dos caracteres)."
    );
    return;
  } else {
    showValidationIcon("first_name");
  }

  // Validar Apellido
  if (!isValidName(lastName)) {
    handleValidation(
      "last_name",
      "Por favor, ingrese un apellido válido (solo letras, al menos dos caracteres)."
    );
    return;
  } else {
    showValidationIcon("last_name");
  }

  // Validar Documento
  if (!isValidDocument(documentNumber)) {
    handleValidation(
      "documento",
      "Por favor, ingrese un documento válido (número entero positivo de 8 dígitos)."
    );
    return;
  } else {
    showValidationIcon("documento");
  }

  // Validar Teléfono (ahora también se verifica que no esté vacío)
  if (!isValidPhone(phone)) {
    handleValidation(
      "phone",
      "Por favor, ingrese un número de teléfono válido."
    );
    return;
  } else {
    showValidationIcon("phone");
  }

  // Validar Correo Electrónico
  if (!isValidEmail(email)) {
    handleValidation(
      "email",
      "Por favor, ingrese una dirección de correo electrónico válida."
    );
    return;
  } else {
    showValidationIcon("email");
  }

  addClient();
}

function resetValidation() {
  // Resetear clases y mensajes de retroalimentación para todos los campos
  var inputs = document
    .getElementById("formAgregarCliente")
    .querySelectorAll("input");
  inputs.forEach(function (input) {
    input.classList.remove("is-invalid");
    input.classList.remove("is-valid");
    input.nextElementSibling.innerHTML = "";
  });
}

function handleValidation(inputId, errorMessage) {
  // Marcar el campo como inválido y ocultar el icono de validación
  var input = document.getElementById(inputId);
  input.classList.add("is-invalid");
  input.classList.remove("is-valid");
  input.nextElementSibling.innerHTML = errorMessage;
}

function showValidationIcon(inputId) {
  // Mostrar el icono de validación (check) y marcar el campo como válido
  var input = document.getElementById(inputId);
  input.classList.remove("is-invalid");
  input.classList.add("is-valid");
}
function isValidName(value) {
  // Validar que el nombre contenga solo letras y espacios, y tenga al menos dos caracteres
  return /^[a-zA-Z\s]{2,}$/.test(value);
}

function isValidDocument(value) {
  // Validar que el documento sea un número entero positivo de 8 dígitos
  return /^\d{8}$/.test(value);
}

function isValidPhone(value) {
  // Validar que el teléfono sea un número válido y no esté vacío
  return value !== "" && /^[\d\s()+-]*$/.test(value);
}

function isValidEmail(value) {
  // Validar que el correo electrónico sea válido
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
}

function reloadTableContent() {
  // Cargar el contenido de la tabla usando AJAX
  $("#table_clients_container").load(" #example1", function () {
    // Vuelve a inicializar DataTables después de cargar el contenido
    $("#example1")
      .DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
      })
      .buttons()
      .container()
      .appendTo("#example1_wrapper .col-md-6:eq(0)");
  });
}
