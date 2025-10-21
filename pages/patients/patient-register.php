<?php 
include_once __DIR__ . './../../src/components/header.php';


?>

<div class="pcoded-content">
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h5>Registo de Pacientes</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Form Components</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Registro Pacientes</a>
                        </li>
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
                                    <span>Adicione class <code>.form-control</code> aos campos</span>
                                </div>
                                <div class="card-block">
                                    <form id="userForm" onsubmit="submitForm(event)">
                                        <!-- Nome -->
                                        <div class="form-group row">
                                            <label for="txtnomepaciente" class="col-sm-2 col-form-label">Nome do
                                                Paciente</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txtnomepaciente"
                                                    placeholder="Nome" required>
                                            </div>
                                        </div>

                                        <!-- Data de nascimento -->
                                        <div class="form-group row">
                                            <label for="txtdatanascimento" class="col-sm-2 col-form-label">Data de
                                                Nascimento</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="txtdatanascimento" required>
                                            </div>
                                        </div>

                                        <!-- Numero BI -->
                                        <div class="form-group row">
                                            <label for="txtnumerobi" class="col-sm-2 col-form-label">Numero de
                                                B.I</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txtnumerobi"
                                                    placeholder="Numero de B.I" required>
                                            </div>
                                        </div>

                                        <!-- Província -->
                                        <div class="form-group row">
                                            <label for="province" class="col-sm-2 col-form-label">Província</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="province"
                                                    onchange="updateDistricts(this.value)" required>
                                                    <option value="">Selecione uma província</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Distrito / Cidade -->
                                        <div class="form-group row">
                                            <label for="district" class="col-sm-2 col-form-label">Cidade /
                                                Distrito</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="district"
                                                    onchange="updateNeighborhoods(this.value)" required>
                                                    <option value="">Selecione um distrito</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Bairro -->
                                        <div class="form-group row">
                                            <label for="neighborhood" class="col-sm-2 col-form-label">Bairro</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="neighborhood" required>
                                                    <option value="">Selecione um bairro</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Telefone -->
                                        <div class="form-group row">
                                            <label for="txttelefone" class="col-sm-2 col-form-label">Número de
                                                Telefone</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txttelefone"
                                                    placeholder="Número de Telefone" required>
                                            </div>
                                        </div>

                                        <!-- WhatsApp -->
                                        <div class="form-group row">
                                            <label for="txtiswhatsapp" class="col-sm-2 col-form-label">Tem
                                                WhatsApp</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="txtiswhatsapp">
                                                    <option value="">Selecione uma opção</option>
                                                    <option value="1">Sim</option>
                                                    <option value="2">Nao</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Botão -->
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-info">Adicionar Paciente</button>
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

        <div id="styleSelector"></div>
    </div>
</div>

<script>
// JSON geográfico de Moçambique
let geoData = {};

fetch('/clinica-system/mozambique_geo.json')
    .then(res => res.json())
    .then(data => {
        console.log("JSON carregado:", data); // <-- COLOQUE AQUI
        geoData = data;
        loadProvinces();
    })
    .catch(err => console.error("Erro ao carregar JSON:", err));


function loadProvinces() {
    const provinceSelect = document.getElementById("province");
    Object.keys(geoData).forEach(province => {
        const option = document.createElement("option");
        option.value = province;
        option.textContent = province;
        provinceSelect.appendChild(option);
    });
}

function updateDistricts(province) {
    const districtSelect = document.getElementById("district");
    districtSelect.innerHTML = '<option value="">Selecione um distrito</option>';

    const neighborhoodSelect = document.getElementById("neighborhood");
    neighborhoodSelect.innerHTML = '<option value="">Selecione um bairro</option>';

    if (geoData[province]) {
        Object.keys(geoData[province]).forEach(district => {
            const option = document.createElement("option");
            option.value = district;
            option.textContent = district;
            districtSelect.appendChild(option);
        });
    }
}

function updateNeighborhoods(district) {
    const neighborhoodSelect = document.getElementById("neighborhood");
    neighborhoodSelect.innerHTML = '<option value="">Selecione um bairro</option>';

    const province = document.getElementById("province").value;
    if (geoData[province] && geoData[province][district]) {
        geoData[province][district].forEach(neighborhood => {
            const option = document.createElement("option");
            option.value = neighborhood;
            option.textContent = neighborhood;
            neighborhoodSelect.appendChild(option);
        });
    }
}

// Envio do formulário
function submitForm(event) {
    event.preventDefault();

    const formData = {
        action: "add",
        name: document.getElementById("txtnomepaciente").value,
        dateBirth: document.getElementById("txtdatanascimento").value,
        bi: document.getElementById("txtnumerobi").value,
        province: document.getElementById("province").value,
        city: document.getElementById("district").value,
        neighborhood: document.getElementById("neighborhood").value,
        phoneNumber: document.getElementById("txttelefone").value,
        iswhatsapp: document.getElementById("txtiswhatsapp").value
    };

    sendFormData(formData);
}

function sendFormData(formData) {
    fetch("routes/patientRoutes.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(data => handleResponse(data))
        .catch(err => handleError(err));
}

function handleResponse(data) {
    if (data.status === "success") {
        alert(data.message);
        window.location.href = "link.php?route=3";
    } else {
        alert("Erro: " + data.message);
    }
}

function handleError(error) {
    console.error("Erro:", error);
    alert("Ocorreu um erro ao enviar os dados.");
}
</script>