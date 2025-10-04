<?php 
include_once __DIR__ . './../../src/components/header.php';
?>

<div class="pcoded-content">
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h5>Registo de Medicamentos</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Gestão de Farmácia</a></li>
                        <li class="breadcrumb-item"><a href="#!">Registo de Medicamentos</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Prencha o formulário de registo de medicamento</h5>
                                    <span>Use os campos abaixo para inserir as informações do medicamento.</span>
                                </div>
                                <div class="card-block">

                                    <form id="medicationForm" onsubmit="submitMedicationForm(event)">
                                        <!-- Nome -->
                                        <div class="form-group row">
                                            <label for="txtname" class="col-sm-2 col-form-label">Nome do
                                                Medicamento</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txtname"
                                                    placeholder="Ex: Amoxicilina" required>
                                            </div>
                                        </div>

                                        <!-- Tipo -->
                                        <div class="form-group row">
                                            <label for="txttype" class="col-sm-2 col-form-label">Tipo</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txttype"
                                                    placeholder="Ex: Antibiótico" required>
                                            </div>
                                        </div>

                                        <!-- Data de Produção -->
                                        <div class="form-group row">
                                            <label for="txtdateProduction" class="col-sm-2 col-form-label">Data de
                                                Produção</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="txtdateProduction" required>
                                            </div>
                                        </div>

                                        <!-- Data de Expiração -->
                                        <div class="form-group row">
                                            <label for="txtdateExpiry" class="col-sm-2 col-form-label">Data de
                                                Expiração</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="txtdateExpiry" required>
                                            </div>
                                        </div>

                                        <!-- Quantidade -->
                                        <div class="form-group row">
                                            <label for="txtqty" class="col-sm-2 col-form-label">Quantidade</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" id="txtqty"
                                                    placeholder="Ex: 80" required>
                                            </div>
                                        </div>

                                        <!-- Número do Lote -->
                                        <div class="form-group row">
                                            <label for="txtloteNumber" class="col-sm-2 col-form-label">Número do
                                                Lote</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" id="txtloteNumber"
                                                    placeholder="Ex: 78901" required>
                                            </div>
                                        </div>

                                        <!-- Preço de Compra -->
                                        <div class="form-group row">
                                            <label for="txtpurchasePrice" class="col-sm-2 col-form-label">Preço de
                                                Compra (MZN)</label>
                                            <div class="col-sm-10">
                                                <input type="number" step="0.01" class="form-control"
                                                    id="txtpurchasePrice" placeholder="Ex: 15.75" required>
                                            </div>
                                        </div>

                                        <!-- Preço de Venda -->
                                        <div class="form-group row">
                                            <label for="txtsalePrice" class="col-sm-2 col-form-label">Preço de Venda
                                                (MZN)</label>
                                            <div class="col-sm-10">
                                                <input type="number" step="0.01" class="form-control" id="txtsalePrice"
                                                    placeholder="Ex: 25.00" required>
                                            </div>
                                        </div>

                                        <!-- Data de Registo -->
                                        <div class="form-group row">
                                            <label for="txtregistationDate" class="col-sm-2 col-form-label">Data de
                                                Registo</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="txtregistationDate"
                                                    required>
                                            </div>
                                        </div>

                                        <!-- Descrição -->
                                        <div class="form-group row">
                                            <label for="txtdescription"
                                                class="col-sm-2 col-form-label">Descrição</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="txtdescription" rows="3"
                                                    placeholder="Breve descrição do medicamento"></textarea>
                                            </div>
                                        </div>

                                        <!-- Usuário -->
                                        <div class="form-group row">
                                            <label for="txtuser" class="col-sm-2 col-form-label">Usuário
                                                Responsável</label>
                                            <div class="col-sm-10">
                                                <select id="txtuser" class="form-control" required>
                                                    <option value="">Selecione o usuário</option>
                                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                                    <option value="<?= $i ?>">Usuário <?= $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Botão -->
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-info">
                                                    <i class="feather icon-save"></i> Registrar Medicamento
                                                </button>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="styleSelector"></div>
</div>

<script>
function submitMedicationForm(event) {
    event.preventDefault();

    const formData = {
        action: "add",
        name: document.getElementById("txtname").value,
        type: document.getElementById("txttype").value,
        dateProduction: document.getElementById("txtdateProduction").value,
        dateExpiry: document.getElementById("txtdateExpiry").value,
        qty: Number(document.getElementById("txtqty").value),
        loteNumber: Number(document.getElementById("txtloteNumber").value),
        purchasePrice: parseFloat(document.getElementById("txtpurchasePrice").value),
        salePrice: parseFloat(document.getElementById("txtsalePrice").value),
        registationDate: document.getElementById("txtregistationDate").value,
        description: document.getElementById("txtdescription").value,
        user_id: Number(document.getElementById("txtuser").value)
    };

    fetch("routes/medicationRoutes.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                alert(data.message);
                window.location.href = "link.php?route=16";
            } else {
                alert("Erro: " + data.message);
            }
        })
        .catch(err => {
            console.error("Erro:", err);
            swal("Erro!", "Falha ao enviar dados para o servidor.", "error");
        });
}
</script>