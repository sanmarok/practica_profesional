function addService() {
    // Obtén los valores del formulario
    var serviceName = document.getElementById("service_name").value;
    var serviceType = document.getElementById("service_type").value;
    var uploadSpeed = document.getElementById("upload_speed").value;
    var downloadSpeed = document.getElementById("download_speed").value;
    var monthlyFee = document.getElementById("monthly_fee").value;
    var installationFee = document.getElementById("installation_fee").value;

    // Crea un objeto con los datos que deseas enviar
    var serviceData = {
        name: serviceName,
        type: serviceType,
        upload_speed: uploadSpeed,
        download_speed: downloadSpeed,
        monthly_fee: monthlyFee,
        installation_fee: installationFee,
    };

    // Realiza una llamada AJAX para enviar los datos al servidor
    fetch("../functions/add_service.php", {
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
                $("#modalAgregarServicio").modal("hide");
                // Recarga la página o realiza otras acciones necesarias
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: "El servicio se agregó correctamente.",
                    showConfirmButton: false,
                    timer: 2000,
                });

                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else {
                // Muestra un mensaje de error en caso de que la operación no sea exitosa
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Ya existe un servicio con ese nombre. Por favor, prueba uno diferente.",
                    showConfirmButton: false,
                    timer: 3000,
                });
            }
        })
        .catch((error) => {
            // Manejo de errores
            console.error("Error en la llamada AJAX: " + error);
        });
}

function addServiceValidationForm() {
    // Resetear clases y mensajes de retroalimentación
    resetValidation();

    // Obtener los valores de los campos
    var serviceName = document.getElementById("service_name").value.trim();
    var serviceType = document.getElementById("service_type").value.trim();
    var uploadSpeed = document.getElementById("upload_speed").value.trim();
    var downloadSpeed = document.getElementById("download_speed").value.trim();
    var monthlyFee = document.getElementById("monthly_fee").value.trim();
    var installationFee = document.getElementById("installation_fee").value.trim();

    // Validar Nombre del Servicio
    if (!isValidServiceName(serviceName)) {
        return;
    }

    // Validar Tipo de Servicio (puedes agregar más validaciones según tus necesidades)

    // Validar Velocidad de Carga
    if (!isValidSpeed(uploadSpeed, "upload_speed")) {
        return;
    }

    // Validar Velocidad de Descarga
    if (!isValidSpeed(downloadSpeed, "download_speed")) {
        return;
    }

    // Validar Tarifa Mensual
    if (!isValidFee(monthlyFee, "monthly_fee")) {
        return;
    }

    // Validar Tarifa de Instalación
    if (!isValidFee(installationFee, "installation_fee")) {
        return;
    }

    addService();
}

function isValidServiceName(value) {
    if (value.length < 2) {
        handleValidation(
            "service_name",
            "Por favor, ingrese un nombre de servicio con al menos dos caracteres."
        );
        return false;
    } else {
        showValidationIcon("service_name");
        return true;
    }
}

function isValidSpeed(value, fieldId) {
    // Validar que la velocidad sea un número positivo
    if (!/^\d+(\.\d+)?$/.test(value) || parseFloat(value) < 0) {
        handleValidation(
            fieldId,
            "Por favor, ingrese velocidades válidas (números positivos)."
        );
        return false;
    } else {
        showValidationIcon(fieldId);
        return true;
    }
}

function isValidFee(value, fieldId) {
    // Validar que la tarifa sea un número positivo
    if (!/^\d+(\.\d+)?$/.test(value) || parseFloat(value) < 0) {
        handleValidation(
            fieldId,
            "Por favor, ingrese datos válidos (números positivos)."
        );
        return false;
    } else {
        showValidationIcon(fieldId);
        return true;
    }
}

function resetValidation() {
    // Resetear clases y mensajes de retroalimentación para todos los campos
    var inputs = document
        .getElementById("formAgregarServicio")
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