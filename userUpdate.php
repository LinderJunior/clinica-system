<?php 
include_once __DIR__ . '/src/services/AuthService.php';
require_once __DIR__ . '/config/database.php';

AuthService::includeHeader();

function fill_customer($pdo, $selectedId = null) {
    $output = '<option value="">Selecione a filial</option>';
    $select = $pdo->prepare("SELECT * FROM tbl_filial ORDER BY nome_filial ASC");
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {
        $selected = ($selectedId == $row["filial_id"]) ? 'selected' : '';
        $output .= '<option value="' . $row["filial_id"] . '" ' . $selected . '>' . $row["nome_filial"] . '</option>';
    }
    return $output;
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Administrador - Atualizar Usuário</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Início</a></li>
            <li class="active">Usuários</li>
        </ol>
    </section>

    <section class="content container-fluid">
        <div class="container">
            <h2>Editar Usuário</h2>

            <form id="userForm" onsubmit="submitForm(event)">
                <input type="hidden" id="userid">
                <div class="form-group">
                    <label for="txtusername">Nome de Usuário</label>
                    <input type="text" class="form-control" id="txtusername" required>
                </div>
                <div class="form-group">
                    <label for="txtuseremail">Email</label>
                    <input type="email" class="form-control" id="txtuseremail" required>
                </div>
                <div class="form-group">
                    <label for="txtrole">Função</label>
                    <select class="form-control" id="txtrole" required>
                        <option value="">Selecione o papel</option>
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                        <option value="Caixa">Caixa</option>
                        <option value="Cobranca">Cobrança</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Filial</label>
                    <select class="form-control" id="filial_id" required>
                        <?php echo fill_customer($pdo); ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Atualizar Usuário</button>
                <a href="userList.php" class="btn btn-default">Cancelar</a>
            </form>
        </div>
    </section>
</div>

<script>
// Ao carregar a página, buscar os dados
document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);
    const userid = params.get("userid");

    if (!userid) {
        alert("ID de usuário não fornecido!");
        window.location.href = "userList.php";
        return;
    }

    fetch("routes/index.php?route=users&id=" + userid)
        .then(response => response.json())
        .then(data => {
            if (data.status === "success" && data.data) {
                populateForm(data.data);
            } else {
                alert("Usuário não encontrado.");
                window.location.href = "userList.php";
            }
        })
        .catch(error => {
            console.error("Erro ao buscar dados do usuário:", error);
            alert("Erro ao carregar dados.");
        });
});

function populateForm(user) {
    document.getElementById("userid").value = user.userid;
    document.getElementById("txtusername").value = user.username;
    document.getElementById("txtuseremail").value = user.useremail;
    document.getElementById("txtrole").value = user.role;
    document.getElementById("filial_id").value = user.filial_id;
}

// Submissão do formulário
function submitForm(event) {
    event.preventDefault();

    const formData = {
        action: "update",
        userid: parseInt(document.getElementById("userid").value),
        username: document.getElementById("txtusername").value,
        useremail: document.getElementById("txtuseremail").value,
        role: document.getElementById("txtrole").value,
        filial_id: parseInt(document.getElementById("filial_id").value)
    };

    fetch("routes/index.php?route=users", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            swal("Sucesso!", "Usuário atualizado com sucesso!", "success")
                .then(() => window.location.href = "userList.php");
        } else {
            swal("Erro!", data.message, "error");
        }
    })
    .catch(error => {
        console.error("Erro:", error);
        swal("Erro!", "Erro ao atualizar usuário.", "error");
    });
}
</script>
