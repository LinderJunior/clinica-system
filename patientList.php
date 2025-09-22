<?php 
include_once __DIR__ . '/src/services/AuthService.php';
AuthService::includeHeader();
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Administrador - Gerenciar Pacientes</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Início</a></li>
            <li class="active">Pacientes</li>
        </ol>
    </section>

    <section class="content container-fluid">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Lista de Pacientes</h3>
                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" id="searchInput" class="form-control pull-right" placeholder="Pesquisar por nome">
                        <div class="input-group-btn">
                            <button type="button" id="searchButton" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="pull-right" style="margin-right: 10px;">
                    <a href="patientCreate.php" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Novo Paciente
                    </a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Data de Nascimento</th>
                            <th>BI</th>
                            <th>Província</th>
                            <th>Telefone</th>
                            <th>WhatsApp</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="patientTableBody">
                        <!-- Os dados dos pacientes serão inseridos aqui -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<script>
// Função para carregar os pacientes na tabela
function loadPatients() {
    fetch("routes/index.php?route=patients")
        .then(response => response.json())
        .then(data => {
            if (data.status === "success" && Array.isArray(data.data)) {
                populatePatientTable(data.data);
            } else {
                console.error("Formato inesperado da resposta:", data);
                alert("Erro ao carregar pacientes: " + data.message);
            }
        })
        .catch(error => console.error("Erro ao buscar pacientes:", error));
}

// Função para preencher a tabela com os dados dos pacientes
function populatePatientTable(patients) {
    const tableBody = document.getElementById("patientTableBody");
    tableBody.innerHTML = "";

    patients.forEach(patient => {
        const row = document.createElement("tr");
        
        // Formatar a data de nascimento
        const dateBirth = new Date(patient.dateBirth);
        const formattedDate = dateBirth.toLocaleDateString('pt-BR');
        
        // Verificar se o paciente tem WhatsApp
        const hasWhatsApp = patient.iswhatsapp == 1 ? "Sim" : "Não";
        
        row.innerHTML = `
            <td>${patient.id}</td>
            <td>${patient.name}</td>
            <td>${formattedDate}</td>
            <td>${patient.bi}</td>
            <td>${patient.province}</td>
            <td>${patient.phoneNumber}</td>
            <td>${hasWhatsApp}</td>
            <td>
                <a href="patientUpdate.php?id=${patient.id}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i>
                </a>
                <button class="btn btn-danger btn-sm" onclick="deletePatient(${patient.id}, this)">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        `;
        
        tableBody.appendChild(row);
    });
}

// Função para excluir um paciente
function deletePatient(patientId, button) {
    swal({
        title: "Tem certeza?",
        text: "Esta ação não pode ser revertida!",
        icon: "warning",
        buttons: ["Cancelar", "Sim, excluir"],
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            fetch("routes/index.php?route=patients", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "delete", id: patientId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    swal("Paciente excluído com sucesso!", { icon: "success" });
                    button.closest("tr").remove();
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(error => {
                console.error("Erro ao excluir paciente:", error);
                swal("Erro!", "Ocorreu um erro ao excluir o paciente.", "error");
            });
        }
    });
}

// Função para pesquisar pacientes por nome
function searchPatients() {
    const searchTerm = document.getElementById("searchInput").value.trim();
    
    if (searchTerm === "") {
        loadPatients(); // Se a pesquisa estiver vazia, carrega todos os pacientes
        return;
    }
    
    fetch(`routes/index.php?route=patients&search=${encodeURIComponent(searchTerm)}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                populatePatientTable(data.data);
            } else {
                console.error("Erro na pesquisa:", data);
                alert("Erro ao pesquisar pacientes: " + data.message);
            }
        })
        .catch(error => console.error("Erro na requisição de pesquisa:", error));
}

// Adicionar evento de clique ao botão de pesquisa
document.getElementById("searchButton").addEventListener("click", searchPatients);

// Adicionar evento de tecla Enter ao campo de pesquisa
document.getElementById("searchInput").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        searchPatients();
    }
});

// Carregar os pacientes quando a página for carregada
document.addEventListener("DOMContentLoaded", loadPatients);
</script>
