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
            <li class="active">Adicionar Posição/Cargo</li>
        </ol>
    </section>

    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Adicionar Nova Posição/Cargo</h3>
            </div>
            
            <form id="positionForm" onsubmit="submitForm(event)">
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
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="positionList.php" class="btn btn-default">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
function submitForm(event) {
    event.preventDefault();
    
    const formData = {
        action: "add",
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
