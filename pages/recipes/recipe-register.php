<?php 
include_once __DIR__ . './../../src/components/header.php';
?>

<div class="pcoded-content">
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h5>Registo de Receita Médica</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Receitas</a></li>
                        <li class="breadcrumb-item"><a href="#!">Registo</a></li>
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
                                    <h5>Preencha o formulário</h5>
                                    <span>Os campos abaixo são obrigatórios para registo da receita médica.</span>
                                </div>

                                <div class="card-block">
                                    <form id="prescriptionForm" onsubmit="submitPrescription(event)">

                                        <!-- Data e Consulta -->
                                        <div class="form-group row">
                                            <label for="date" class="col-sm-2 col-form-label">Data</label>
                                            <div class="col-sm-4">
                                                <input type="date" class="form-control" id="date" required>
                                            </div>

                                            <label for="consult_id" class="col-sm-2 col-form-label">Consulta</label>
                                            <div class="col-sm-4">
                                                <select id="consult_id" class="form-control" required>
                                                    <option value="">Selecione a consulta</option>
                                                </select>
                                            </div>
                                        </div>

                                        <hr>

                                        <!-- Seção de Medicações -->
                                        <div class="form-group">
                                            <label class="form-label"><strong>Adicionar Medicações à
                                                    Receita</strong></label>

                                            <div class="row align-items-center mb-2">
                                                <div class="col-md-4">
                                                    <label>Medicação</label>
                                                    <select class="form-control" id="medicationSelect">
                                                        <option value="">Selecione uma medicação</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <label>Quantidade</label>
                                                    <input type="number" id="qty" class="form-control" placeholder="Qtd"
                                                        min="1" value="1">
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Dosagem</label>
                                                    <input type="text" id="dosage" class="form-control"
                                                        placeholder="Ex: 1 comp. a cada 8h">
                                                </div>

                                                <div class="col-md-2 text-center mt-3">
                                                    <button type="button" class="btn btn-success w-100"
                                                        onclick="addMedication()">
                                                        <i class="feather icon-plus"></i> Adicionar
                                                    </button>
                                                </div>
                                            </div>

                                            <ul id="medicationsList" class="list-group mt-3"></ul>
                                        </div>

                                        <hr>

                                        <!-- Botão -->
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-info">
                                                    <i class="feather icon-save"></i> Registar Receita
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
</div>

<script>
let medications = [];

document.addEventListener("DOMContentLoaded", async () => {
    await loadConsults();
    await loadMedications();
});

async function loadConsults() {
    try {
        const res = await fetch("routes/consultRoutes.php?action=list");
        const data = await res.json();
        const select = document.getElementById("consult_id");
        select.innerHTML = '<option value="">Selecione a consulta</option>';
        data.data.forEach(c => {
            select.innerHTML += `<option value="${c.id}">Consulta #${c.id} - ${c.date}</option>`;
        });
    } catch (error) {
        console.error("Erro ao carregar consultas:", error);
    }
}

async function loadMedications() {
    try {
        const res = await fetch("routes/medicationRoutes.php?action=list");
        const data = await res.json();
        const select = document.getElementById("medicationSelect");
        select.innerHTML = '<option value="">Selecione uma medicação</option>';
        data.data.forEach(m => {
            select.innerHTML += `<option value="${m.id}">${m.name}</option>`;
        });
    } catch (error) {
        console.error("Erro ao carregar medicações:", error);
    }
}

function addMedication() {
    const select = document.getElementById("medicationSelect");
    const medId = select.value;
    const medName = select.options[select.selectedIndex]?.text;
    const qty = document.getElementById("qty").value;
    const dosage = document.getElementById("dosage").value.trim();

    if (!medId || !qty || !dosage) {
        alert("Preencha todos os campos da medicação.");
        return;
    }

    medications.push({
        medication_id: parseInt(medId),
        qty: parseInt(qty),
        dosage
    });

    renderMedicationsList();
    clearMedicationInputs();
}

function renderMedicationsList() {
    const list = document.getElementById("medicationsList");
    list.innerHTML = "";

    medications.forEach((m, index) => {
        const medName = document.querySelector(`#medicationSelect option[value='${m.medication_id}']`)?.text ||
            'Desconhecido';
        const li = document.createElement("li");
        li.className = "list-group-item d-flex justify-content-between align-items-center";
        li.innerHTML = `
            <div>
                <strong>${medName}</strong> — 
                <span class="text-primary">${m.qty} unidade(s)</span> — 
                <em>${m.dosage}</em>
            </div>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeMedication(${index})">Remover</button>
        `;
        list.appendChild(li);
    });
}

function removeMedication(index) {
    medications.splice(index, 1);
    renderMedicationsList();
}

function clearMedicationInputs() {
    document.getElementById("medicationSelect").value = "";
    document.getElementById("qty").value = 1;
    document.getElementById("dosage").value = "";
}

function submitPrescription(event) {
    event.preventDefault();

    const formData = {
        action: "add",
        date: document.getElementById("date").value,
        consult_id: parseInt(document.getElementById("consult_id").value),
        medications
    };

    if (!formData.date || !formData.consult_id || medications.length === 0) {
        alert("Preencha todos os campos e adicione pelo menos uma medicação.");
        return;
    }

    fetch("routes/recipeRoutes.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(formData)
        })
        .then(async res => {
            const text = await res.text();
            try {
                return JSON.parse(text);
            } catch {
                console.error("Resposta inválida do servidor:", text);
                throw new Error("Resposta não é JSON. Verifique o PHP.");
            }
        })
        .then(data => {
            if (data.status === "success" || data.success) {
                alert("Receita registada com sucesso!");
                medications = [];
                renderMedicationsList();
                document.getElementById("prescriptionForm").reset();
            } else {
                alert("Erro ao registar: " + (data.message || "Erro desconhecido."));
            }
        })
        .catch(error => {
            console.error("Erro ao enviar receita:", error);
            alert("Ocorreu um erro ao enviar os dados.");
        });
}
</script>