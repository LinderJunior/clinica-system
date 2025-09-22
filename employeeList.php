<?php 
include_once __DIR__ . '/src/services/AuthService.php';
AuthService::includeHeader();
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Administrador - Gerenciar Funcionários</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Início</a></li>
            <li class="active">Funcionários</li>
        </ol>
    </section>

    <section class="content container-fluid">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Lista de Funcionários</h3>
                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" id="searchInput" class="form-control pull-right" placeholder="Pesquisar por nome">
                        <div class="input-group-btn">
                            <button type="button" id="searchButton" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="pull-right" style="margin-right: 10px;">
                    <a href="employeeCreate.php" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Novo Funcionário
                    </a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>BI</th>
                            <th>Telefone</th>
                            <th>Posições/Cargos</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="employeeTableBody">
                        <!-- Os dados dos funcionários serão inseridos aqui -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<script>
// Função para carregar os funcionários na tabela
function loadEmployees() {
    fetch("routes/index.php?route=employees")
        .then(response => response.json())
        .then(data => {
            if (data.status === "success" && Array.isArray(data.data)) {
                populateEmployeeTable(data.data);
            } else {
                console.error("Formato inesperado da resposta:", data);
                alert("Erro ao carregar funcionários: " + data.message);
            }
        })
        .catch(error => console.error("Erro ao buscar funcionários:", error));
}

// Função para preencher a tabela com os dados dos funcionários
function populateEmployeeTable(employees) {
    const tableBody = document.getElementById("employeeTableBody");
    tableBody.innerHTML = "";

    employees.forEach(employee => {
        const row = document.createElement("tr");
        
        // Formatar as posições/cargos
        const positions = employee.positions.map(pos => pos.type).join(", ");
        
        row.innerHTML = `
            <td>${employee.id}</td>
            <td>${employee.name}</td>
            <td>${employee.bi}</td>
            <td>${employee.phoneNumber}</td>
            <td>${positions}</td>
            <td>
                <a href="employeeUpdate.php?id=${employee.id}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i>
                </a>
                <button class="btn btn-danger btn-sm" onclick="deleteEmployee(${employee.id}, this)">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        `;
        
        tableBody.appendChild(row);
    });
}

// Função para excluir um funcionário
function deleteEmployee(employeeId, button) {
    swal({
        title: "Tem certeza?",
        text: "Esta ação não pode ser revertida!",
        icon: "warning",
        buttons: ["Cancelar", "Sim, excluir"],
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            fetch("routes/index.php?route=employees", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "delete", id: employeeId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    swal("Funcionário excluído com sucesso!", { icon: "success" });
                    button.closest("tr").remove();
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(error => {
                console.error("Erro ao excluir funcionário:", error);
                swal("Erro!", "Ocorreu um erro ao excluir o funcionário.", "error");
            });
        }
    });
}

// Função para pesquisar funcionários por nome
function searchEmployees() {
    const searchTerm = document.getElementById("searchInput").value.trim();
    
    if (searchTerm === "") {
        loadEmployees(); // Se a pesquisa estiver vazia, carrega todos os funcionários
        return;
    }
    
    fetch(`routes/index.php?route=employees&search=${encodeURIComponent(searchTerm)}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                populateEmployeeTable(data.data);
            } else {
                console.error("Erro na pesquisa:", data);
                alert("Erro ao pesquisar funcionários: " + data.message);
            }
        })
        .catch(error => console.error("Erro na requisição de pesquisa:", error));
}

// Adicionar evento de clique ao botão de pesquisa
document.getElementById("searchButton").addEventListener("click", searchEmployees);

// Adicionar evento de tecla Enter ao campo de pesquisa
document.getElementById("searchInput").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        searchEmployees();
    }
});

// Carregar os funcionários quando a página for carregada
document.addEventListener("DOMContentLoaded", loadEmployees);
</script>
