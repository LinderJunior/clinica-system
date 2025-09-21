<?php 
include_once __DIR__ . '/src/services/AuthService.php';
AuthService::includeHeader();



function fill_customer($pdo) {
    $output = '<option value="">Select Customer</option>';
    $select = $pdo->prepare("SELECT * FROM tbl_filial ORDER BY nome_filial ASC");
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {
        $output .= '<option value="' . $row["filial_id"] . '">' . $row["nome_filial"] . '</option>';
    }
    return $output;
  }






?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Administrador - Gerenciar Usuários</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Início</a></li>
            <li class="active">Usuários</li>
        </ol>
    </section>

    <section class="content container-fluid">
        <div class="container">
            <h2>Adicionar Novo Usuário</h2>
            
            <form id="userForm" onsubmit="submitForm(event)">
                <div class="form-group">
                    <label for="txtusername">Nome de Usuário</label>
                    <input type="text" class="form-control" id="txtusername" placeholder="Nome de Usuário" required>
                </div>
                <div class="form-group">
                    <label for="txtuseremail">Email</label>
                    <input type="email" class="form-control" id="txtuseremail" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="txtpassword">Senha</label>
                    <input type="password" class="form-control" id="txtpassword" placeholder="Senha" required>
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
                  <label>Nome Filial</label>
                  <div class="input-group">
                      <div class="input-group-addon">
                          <i class="fa fa-user"></i>
                      </div>
                      <select class="form-control" id="filial_id" name="filial_id" required>
                          <?php echo fill_customer($pdo); ?>
                      </select>
                  </div>
              </div>
                <button type="submit" class="btn btn-info">Adicionar Usuário</button>
            </form>
        </div>
    </section>
</div>

<script>
function submitForm(event) {
    event.preventDefault();

    const formData = {
        action: "add",
        username: document.getElementById("txtusername").value,
        useremail: document.getElementById("txtuseremail").value,
        password: document.getElementById("txtpassword").value,
        role: document.getElementById("txtrole").value,
        filial_id: parseInt(document.getElementById("filial_id").value)
    };

    sendFormData(formData);
}

function sendFormData(formData) {
    fetch("userRoutes.php", {
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
        alert(data.message);
        window.location.href = "userList.php"; // você pode ajustar esse destino
    } else {
        alert("Erro: " + data.message);
    }
}

function handleError(error) {
    console.error("Erro ao enviar a requisição:", error);
    alert("Ocorreu um erro ao tentar enviar os dados.");
}
</script>
