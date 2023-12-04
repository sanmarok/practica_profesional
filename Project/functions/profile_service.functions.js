function updateService() {
    resetValidation();
    // Obtén los valores del formulario de edición
    var serviceContainer = document.getElementById("service-container");
    var serviceId = serviceContainer.dataset.serviceId;
    var serviceName = document.getElementById("inputServiceName").value;
    var serviceType = document.getElementById("inputServiceType").value;
    var uploadSpeed = document.getElementById("inputUploadSpeed").value;
    var downloadSpeed = document.getElementById("inputDownloadSpeed").value;
    var monthlyFee = document.getElementById("inputMonthlyFee").value;
    var installationFee = document.getElementById("inputInstallationFee").value;

    // Crea un objeto con los datos que deseas enviar
    var serviceData = {
        service_id: serviceId,
        name: serviceName,
        type: serviceType,
        upload_speed: uploadSpeed,
        download_speed: downloadSpeed,
        monthly_fee: monthlyFee,
        installation_fee: installationFee,
    };

    // Realiza una llamada AJAX para enviar los datos al servidor
    fetch("../functions/update_service.php", {
        method: "POST",
        body: JSON.stringify(serviceData),
        headers: {
            "Content-Type": "application/json",
        },
    })
    .then((response) => response.json())
    .then((data) => {
        // Manejar la respuesta del servidor
        if (data.success) {
            // Actualización exitosa, mostrar mensaje de éxito
            Swal.fire({
                icon: "success",
                title: "Éxito",
                text: "El servicio se actualizó correctamente.",
                showConfirmButton: false,
                timer: 2000,
            });
        } else {
            // Mostrar mensaje de error en caso de fallo
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error al actualizar el servicio.",
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

function updateServiceValidationForm() {
    // Resetear clases y mensajes de retroalimentación
    resetValidation();
    

    // Obtener los valores de los campos de edición
    var serviceName = document.getElementById("inputServiceName").value.trim();
    var serviceType = document.getElementById("inputServiceType").value.trim();
    var uploadSpeed = document.getElementById("inputUploadSpeed").value.trim();
    var downloadSpeed = document.getElementById("inputDownloadSpeed").value.trim();
    var monthlyFee = document.getElementById("inputMonthlyFee").value.trim();
    var installationFee = document.getElementById("inputInstallationFee").value.trim();

    // Validar Nombre del Servicio
    if (!isValidServiceName(serviceName)) {
        return;
    }

    // Validar Tipo de Servicio (puedes agregar más validaciones según tus necesidades)

    // Validar Velocidad de Carga
    if (!isValidSpeed(uploadSpeed, "inputUploadSpeed")) {
        return;
    }

    // Validar Velocidad de Descarga
    if (!isValidSpeed(downloadSpeed, "inputDownloadSpeed")) {
        return;
    }

    // Validar Tarifa Mensual
    if (!isValidFee(monthlyFee, "inputMonthlyFee")) {
        return;
    }

    // Validar Tarifa de Instalación
    if (!isValidFee(installationFee, "inputInstallationFee")) {
        return;
    }

    // Llamar a la función de actualización
    updateService();
}

function isValidServiceName(value) {
    if (value.length < 2) {
        handleValidation(
            "inputServiceName",
            "Por favor, ingrese un nombre de servicio con al menos dos caracteres."
        );
        return false;
    } else {
        
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
        
        return true;
    }
}

function handleValidation(inputId, errorMessage) {
    // Marcar el campo como inválido y no mostrar el mensaje de error
    var input = document.getElementById(inputId);
    input.classList.add("is-invalid");
}

function resetValidation() {
    // Resetear clases de retroalimentación para todos los campos de edición
    var inputs = document
        .getElementById("formEditarServicio")
        .querySelectorAll("input");
    inputs.forEach(function (input) {
        input.classList.remove("is-invalid", "is-valid");
    });
}

function showValidationIcon(inputId) {
    // Mostrar el icono de validación (check) y marcar el campo como válido
    var input = document.getElementById(inputId);
    input.classList.remove("is-invalid");
    input.classList.add("is-valid");
    // No es necesario eliminar el contenido del siguiente elemento hermano aquí
}