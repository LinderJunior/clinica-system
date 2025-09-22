<?php 
include_once __DIR__ . '/src/services/AuthService.php';
AuthService::includeHeader();
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Administrador - Gerenciar Posições/Cargos</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Início</a></li>
            <li class="active">Posições/Cargos</li>
        </ol>
    </section>

    <section class="content container-fluid">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Lista de Posições/Cargos</h3>
                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" id="searchInput" class="form-control pull-right" placeholder="Pesquisar por tipo">
                        <div class="input-group-btn">
                            <button type="button" id="searchButton" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="pull-right" style="margin-right: 10px;">
                    <a href="positionCreate.php" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Nova Posição/Cargo
                    </a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Descrição</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="positionTableBody">
                        <!-- Os dados das posições/cargos serão inseridos aqui -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<script>
// Função para carregar as posições/cargos na tabela
function loadPositions() {
    fetch("routes/index.php?route=positions")
        .then(response => response.json())
        .then(data => {
            if (data.status === "success" && Array.isArray(data.data)) {
                populatePositionTable(data.data);
            } else {
                console.error("Formato inesperado da resposta:", data);
                alert("Erro ao carregar posições/cargos: " + data.message);
            }
        })
        .catch(error => console.error("Erro ao buscar posições/cargos:", error));
}

// Função para preencher a tabela com os dados das posições/cargos
function populatePositionTable(positions) {
    const tableBody = document.getElementById("positionTableBody");
    tableBody.innerHTML = "";

    positions.forEach(position => {
        const row = document.createElement("tr");
        
        row.innerHTML = `
            <td>${position.id}</td>
            <td>${position.type}</td>
            <td>${position.description}</td>
            <td>
                <a href="positionUpdate.php?id=${position.id}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i>
                </a>
                <button class="btn btn-danger btn-sm" onclick="deletePosition(${position.id}, this)">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        `;
        
        tableBody.appendChild(row);
    });
}

// Função para excluir uma posição/cargo
function deletePosition(positionId, button) {
    swal({
        title: "Tem certeza?",
        text: "Esta ação não pode ser revertida!",
        icon: "warning",
        buttons: ["Cancelar", "Sim, excluir"],
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            fetch("routes/index.php?route=positions", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "delete", id: positionId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    swal("Posição/cargo excluído com sucesso!", { icon: "success" });
                    button.closest("tr").remove();
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(error => {
                console.error("Erro ao excluir posição/cargo:", error);
                swal("Erro!", "Ocorreu um erro ao excluir a posição/cargo.", "error");
            });
        }
    });
}

// Função para pesquisar posições/cargos por tipo
function searchPositions() {
    const searchTerm = document.getElementById("searchInput").value.trim();
    
    if (searchTerm === "") {
        loadPositions(); // Se a pesquisa estiver vazia, carrega todas as posições/cargos
        return;
    }
    
    fetch(`routes/index.php?route=positions&search=${encodeURIComponent(searchTerm)}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                populatePositionTable(data.data);
            } else {
                console.error("Erro na pesquisa:", data);
                alert("Erro ao pesquisar posições/cargos: " + data.message);
            }
        })
        .catch(error => console.error("Erro na requisição de pesquisa:", error));
}

// Adicionar evento de clique ao botão de pesquisa
document.getElementById("searchButton").addEventListener("click", searchPositions);

// Adicionar evento de tecla Enter ao campo de pesquisa
document.getElementById("searchInput").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        searchPositions();
    }
});

// Carregar as posições/cargos quando a página for carregada
document.addEventListener("DOMContentLoaded", loadPositions);
</script>
