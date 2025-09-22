<?php 
include_once __DIR__ . '/src/services/AuthService.php';
AuthService::includeHeader();
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Administrador - Gerenciar Posições/Cargos</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Início</a></li>
            <li><a href="positionList.php">Posições/Cargos</a></li>
            <li class="active">Editar Posição/Cargo</li>
        </ol>
    </section>

    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Editar Posição/Cargo</h3>
            </div>
            
            <form id="positionForm" onsubmit="submitForm(event)">
                <input type="hidden" id="positionId">
                <div class="box-body">
                    <div class="form-group">
                        <label for="type">Tipo</label>
                        <input type="text" class="form-control" id="type" placeholder="Tipo da posição/cargo" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Descrição</label>
                        <textarea class="form-control" id="description" rows="3" placeholder="Descrição da posição/cargo"></textarea>
                    </div>
                </div>
                
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <a href="positionList.php" class="btn btn-default">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
// Carregar os dados da posição/cargo quando a página for carregada
document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);
    const positionId = params.get("id");

    if (!positionId) {
        swal("Erro!", "ID da posição/cargo não fornecido!", "error")
            .then(() => {
                window.location.href = "positionList.php";
            });
        return;
    }

    fetch(`routes/index.php?route=positions&id=${positionId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === "success" && data.data) {
                populateForm(data.data);
            } else {
                swal("Erro!", "Posição/cargo não encontrado.", "error")
                    .then(() => {
                        window.location.href = "positionList.php";
                    });
            }
        })
        .catch(error => {
            console.error("Erro ao buscar dados da posição/cargo:", error);
            swal("Erro!", "Ocorreu um erro ao buscar os dados da posição/cargo.", "error");
        });
});

// Preencher o formulário com os dados da posição/cargo
function populateForm(position) {
    document.getElementById("positionId").value = position.id;
    document.getElementById("type").value = position.type;
    document.getElementById("description").value = position.description;
}

// Enviar o formulário de atualização
function submitForm(event) {
    event.preventDefault();
    
    const formData = {
        action: "update",
        id: parseInt(document.getElementById("positionId").value),
        type: document.getElementById("type").value,
        description: document.getElementById("description").value
    };
    
    sendFormData(formData);
}

function sendFormData(formData) {
    fetch("routes/index.php?route=positions", {
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
            window.location.href = "positionList.php";
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
