<?php 
include_once __DIR__ . '/src/services/AuthService.php';
AuthService::includeHeader();
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Administrador - Gerenciar Pacientes</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Início</a></li>
            <li><a href="patientList.php">Pacientes</a></li>
            <li class="active">Adicionar Paciente</li>
        </ol>
    </section>

    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Adicionar Novo Paciente</h3>
            </div>
            
            <form id="patientForm" onsubmit="submitForm(event)">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nome Completo</label>
                                <input type="text" class="form-control" id="name" placeholder="Nome completo do paciente" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="dateBirth">Data de Nascimento</label>
                                <input type="date" class="form-control" id="dateBirth" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="bi">BI (Bilhete de Identidade)</label>
                                <input type="text" class="form-control" id="bi" placeholder="Número do BI">
                            </div>
                            
                            <div class="form-group">
                                <label for="province">Província</label>
                                <input type="text" class="form-control" id="province" placeholder="Província">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">Cidade</label>
                                <input type="text" class="form-control" id="city" placeholder="Cidade">
                            </div>
                            
                            <div class="form-group">
                                <label for="neighborhood">Bairro</label>
                                <input type="text" class="form-control" id="neighborhood" placeholder="Bairro">
                            </div>
                            
                            <div class="form-group">
                                <label for="phoneNumber">Número de Telefone</label>
                                <input type="text" class="form-control" id="phoneNumber" placeholder="Número de telefone" maxlength="9" required>
                            </div>
                            
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" id="iswhatsapp"> Este número tem WhatsApp
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="patientList.php" class="btn btn-default">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
function submitForm(event) {
    event.preventDefault();
    
    // Validar o número de telefone (deve ter 9 dígitos)
    const phoneNumber = document.getElementById("phoneNumber").value;
    if (phoneNumber.length !== 9 || !/^\d+$/.test(phoneNumber)) {
        swal("Erro!", "O número de telefone deve conter 9 dígitos numéricos.", "error");
        return;
    }
    
    const formData = {
        action: "add",
        name: document.getElementById("name").value,
        dateBirth: document.getElementById("dateBirth").value,
        bi: document.getElementById("bi").value,
        province: document.getElementById("province").value,
        city: document.getElementById("city").value,
        neighborhood: document.getElementById("neighborhood").value,
        phoneNumber: phoneNumber,
        iswhatsapp: document.getElementById("iswhatsapp").checked ? 1 : 0
    };
    
    sendFormData(formData);
}

function sendFormData(formData) {
    fetch("routes/index.php?route=patients", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => handleResponse(data))
    .catch(error => handleError(error));
}

function handleResponse(data) {
    if (data.status === "success") {
        swal({
            title: "Sucesso!",
            text: data.message,
            icon: "success",
            button: "OK"
        }).then(() => {
            window.location.href = "patientList.php";
        });
    } else {
        swal("Erro!", data.message, "error");
    }
}

function handleError(error) {
    console.error("Erro ao enviar a requisição:", error);
    swal("Erro!", "Ocorreu um erro ao tentar enviar os dados.", "error");
}
</script>
