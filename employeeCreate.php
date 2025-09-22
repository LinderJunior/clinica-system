<?php 
include_once __DIR__ . '/src/services/AuthService.php';
AuthService::includeHeader();
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Administrador - Gerenciar Funcionários</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Início</a></li>
            <li><a href="employeeList.php">Funcionários</a></li>
            <li class="active">Adicionar Funcionário</li>
        </ol>
    </section>

    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Adicionar Novo Funcionário</h3>
            </div>
            
            <form id="employeeForm" onsubmit="submitForm(event)">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nome Completo</label>
                                <input type="text" class="form-control" id="name" placeholder="Nome completo do funcionário" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="bi">BI (Bilhete de Identidade)</label>
                                <input type="text" class="form-control" id="bi" placeholder="Número do BI" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="phoneNumber">Número de Telefone</label>
                                <input type="text" class="form-control" id="phoneNumber" placeholder="Número de telefone" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Posições/Cargos</label>
                                <div id="positionsContainer">
                                    <!-- As posições/cargos serão carregadas aqui -->
                                    <p>Carregando posições/cargos...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="employeeList.php" class="btn btn-default">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
// Variável global para armazenar as posições/cargos
let positions = [];

// Função para carregar as posições/cargos disponíveis
function loadPositions() {
    fetch("routes/index.php?route=employees?positions=true")
        .then(response => response.json())
        .then(data => {
            if (data.status === "success" && Array.isArray(data.data)) {
                positions = data.data;
                displayPositions(positions);
            } else {
                console.error("Erro ao carregar posições/cargos:", data);
                document.getElementById("positionsContainer").innerHTML = 
                    '<div class="alert alert-danger">Erro ao carregar posições/cargos.</div>';
            }
        })
        .catch(error => {
            console.error("Erro na requisição:", error);
            document.getElementById("positionsContainer").innerHTML = 
                '<div class="alert alert-danger">Erro ao carregar posições/cargos.</div>';
        });
}

// Função para exibir as posições/cargos como checkboxes
function displayPositions(positions) {
    const container = document.getElementById("positionsContainer");
    
    if (positions.length === 0) {
        container.innerHTML = '<div class="alert alert-warning">Nenhuma posição/cargo disponível.</div>';
        return;
    }
    
    let html = '<div class="checkbox-list">';
    
    positions.forEach(position => {
        html += `
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="positions[]" value="${position.id}">
                    ${position.type}
                </label>
            </div>
        `;
    });
    
    html += '</div>';
    container.innerHTML = html;
}

function submitForm(event) {
    event.preventDefault();
    
    // Obter os IDs das posições/cargos selecionados
    const selectedPositions = [];
    document.querySelectorAll('input[name="positions[]"]:checked').forEach(checkbox => {
        selectedPositions.push(parseInt(checkbox.value));
    });
    
    if (selectedPositions.length === 0) {
        swal("Erro!", "Selecione pelo menos uma posição/cargo.", "error");
        return;
    }
    
    const formData = {
        action: "add",
        name: document.getElementById("name").value,
        bi: document.getElementById("bi").value,
        phoneNumber: document.getElementById("phoneNumber").value,
        positionIds: selectedPositions
    };
    
    sendFormData(formData);
}

function sendFormData(formData) {
    fetch("routes/index.php?route=employees", {
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
            window.location.href = "employeeList.php";
        });
    } else {
        swal("Erro!", data.message, "error");
    }
}

function handleError(error) {
    console.error("Erro ao enviar a requisição:", error);
    swal("Erro!", "Ocorreu um erro ao tentar enviar os dados.", "error");
}

// Carregar as posições/cargos quando a página for carregada
document.addEventListener("DOMContentLoaded", loadPositions);
</script>
