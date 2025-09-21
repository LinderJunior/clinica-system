<?php 
include_once __DIR__ . '/src/services/AuthService.php';
// Chama a função para incluir o cabeçalho
AuthService::includeHeader();
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Lista de Usuários</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Nível</a></li>
      <li class="active">Usuários</li>
    </ol>
  </section>

  <section class="content container-fluid">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Usuários</h3>
      </div>
      <div class="box-body">
        <table id="usertable" class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome de Usuário</th>
              <th>Email</th>
              <th>Função</th>
              <th>Filial</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <!-- Dados serão carregados via JavaScript -->
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<script>
// Função para carregar os usuários na tabela
function loadUsers() {
    fetch("userRoutes.php")
        .then(response => response.json())
        .then(data => {
            if (data.status === "success" && Array.isArray(data.data)) {
                populateUserTable(data.data);
            } else {
                console.error("Formato inesperado da resposta:", data);
                alert("Erro ao carregar usuários: " + data.message);
            }
        })
        .catch(error => console.error("Erro ao buscar usuários:", error));
}

// Popula a tabela com dados
function populateUserTable(users) {
    let table = $('#usertable').DataTable();
    table.clear().draw();

    users.forEach(user => {
        table.row.add([
            user.userid,
            user.username,
            user.useremail,
            user.role,
            user.nome_filial || '—',
            getUserActionButtons(user.userid)
        ]).draw(false);
    });
}

// Botões de ação (editar e apagar)
function getUserActionButtons(userid) {
    return `
        <a href="userUpdate.php?userid=${userid}" class="btn btn-info">
            <span class="glyphicon glyphicon-edit"></span>
        </a>
        <button userid="${userid}" class="btn btn-danger btndelete">
            <span class="glyphicon glyphicon-trash"></span>
        </button>
        <a href="userPasswordUpdate.php?userid=${userid}" class="btn btn-info">
            <span class="glyphicon glyphicon-edit"></span>
        </a>
    `;
}

// Função para excluir um usuário
function deleteUser(userid, button) {
    fetch("userRoutes.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "delete", userid: userid })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            swal("Usuário excluído com sucesso!", { icon: "success" });
            button.closest("tr").remove();
        } else {
            swal("Erro!", data.message, "error");
        }
    })
    .catch(error => {
        console.error("Erro ao excluir usuário:", error);
        swal("Erro!", "Ocorreu um erro inesperado.", "error");
    });
}

// Inicializa DataTable
function initDataTable() {
    $('#usertable').DataTable({
        paging: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        ordering: true,
        info: true,
        searching: true,
        order: [[0, "desc"]],
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "Nenhum usuário encontrado",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Nenhum dado disponível",
            infoFiltered: "(filtrado de _MAX_ registros no total)",
            search: "Pesquisar:",
            paginate: {
                first: "Primeiro",
                last: "Último",
                next: "Próximo",
                previous: "Anterior"
            }
        }
    });
}

// Executa ao carregar a página
document.addEventListener("DOMContentLoaded", function () {
    loadUsers();
    initDataTable();

    // Evento excluir
    document.addEventListener("click", function (event) {
        let button = event.target.closest(".btndelete");
        if (button) {
            let userid = button.getAttribute("userid");
            swal({
                title: "Deseja apagar o usuário?",
                text: "Essa ação não pode ser desfeita!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    deleteUser(userid, button);
                } else {
                    swal("O usuário está seguro!");
                }
            });
        }
    });
});
</script>
