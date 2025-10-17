<?php include_once __DIR__ . './../../src/components/header.php'; ?>

<div class="pcoded-content">
    <div class="page-header card py-2 px-3">
        <div class="row align-items-center">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary" style="font-size: 1.25rem; font-weight: 500;">
                    Registro de Peso do Cliente
                </h5>
                <a href="link.php?route=23" class="btn btn-secondary btn-sm d-flex align-items-center shadow-sm" style="font-size: 0.9rem; padding: 0.35rem 0.7rem;">
                    <i class="icofont icofont-arrow-left mr-1" style="font-size: 1rem;"></i>
                    Voltar à Lista
                </a>
            </div>
        </div>
    </div>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light">
                                    <h6 class="text-secondary mb-0 text-uppercase">
                                        <i class="icofont icofont-plus-circle mr-2"></i>
                                        Novo Registro de Peso
                                    </h6>
                                    <small class="text-muted">Preencha os dados do registro de peso do cliente</small>
                                </div>
                                <div class="card-body">
                                    <form id="formRegisterWeight">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="client_id">Cliente <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="client_id" name="client_id" required>
                                                        <option value="">Selecione um cliente</option>
                                                    </select>
                                                    <small class="form-text text-muted">Selecione o cliente para o registro de peso</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                               <div class="form-group">
                                                    <label for="height">Altura (m) <span class="text-danger">*</span></label>
                                                    <input type="number" step="0.01" min="1" max="5.5" class="form-control" id="height" name="height" required>
                                                    <small class="form-text text-muted">Ex: 1.75</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="weight">Peso (kg) <span class="text-danger">*</span></label>
                                                    <input type="number" step="0.1" min="20" max="300" class="form-control" id="weight" name="weight" required>
                                                    <small class="form-text text-muted">Ex: 70.2</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="bmi">IMC</label>
                                                    <input type="number" step="0.1" class="form-control" id="bmi" name="bmi" readonly>
                                                    <small class="form-text text-muted">Calculado automaticamente</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="classification">Classificação</label>
                                                    <input type="text" class="form-control" id="classification" name="classification" readonly>
                                                    <small class="form-text text-muted">Determinada automaticamente</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <h6 class="card-title text-info">
                                                            <i class="icofont icofont-info-circle mr-2"></i>
                                                            Classificação do IMC
                                                        </h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <ul class="list-unstyled mb-0">
                                                                    <li><span class="badge badge-secondary mr-2">Abaixo do peso:</span> IMC < 18.5</li>
                                                                    <li><span class="badge badge-success mr-2">Peso normal:</span> 18.5 ≤ IMC < 25</li>
                                                                    <li><span class="badge badge-warning mr-2">Sobrepeso:</span> 25 ≤ IMC < 30</li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <ul class="list-unstyled mb-0">
                                                                    <li><span class="badge badge-orange mr-2">Obesidade I:</span> 30 ≤ IMC < 35</li>
                                                                    <li><span class="badge badge-danger mr-2">Obesidade II:</span> 35 ≤ IMC < 40</li>
                                                                    <li><span class="badge badge-purple mr-2">Obesidade III:</span> IMC ≥ 40</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mt-4">
                                            <div class="d-flex justify-content-between">
                                                <a href="link.php?route=23" class="btn btn-secondary">
                                                    <i class="icofont icofont-arrow-left mr-1"></i>
                                                    Cancelar
                                                </a>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="icofont icofont-save mr-1"></i>
                                                    Salvar Registro
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

<style>
.card {
    border-radius: 10px;
}

.form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.badge-orange {
    background-color: #fd7e14;
}

.badge-purple {
    background-color: #6f42c1;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

.text-info {
    color: #17a2b8 !important;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.list-unstyled li {
    margin-bottom: 0.5rem;
}
</style>

<script>
$(document).ready(function() {
    // Carregar clientes no select
    function loadClients() {
        fetch("routes/index.php?route=patients")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    const select = $('#client_id');
                    select.empty().append('<option value="">Selecione um cliente</option>');
                    data.data.forEach(patient => {
                        select.append(`<option value="${patient.id}">${patient.name}</option>`);
                    });
                }
            }).catch(err => console.error('Erro ao carregar clientes:', err));
    }

    // Função para calcular IMC
    function calculateBMI(height, weight) {
        if (height && weight && height > 0 && weight > 0) {
            // Altura já está em metros, não precisa dividir por 100
            const bmi = weight / (height * height);
            return bmi;
        }
        return null;
    }

    // Função para obter classificação do IMC
    function getBMIClassification(bmi) {
        if (bmi < 18.5) {
            return 'Abaixo do peso';
        } else if (bmi < 25) {
            return 'Peso normal';
        } else if (bmi < 30) {
            return 'Sobrepeso';
        } else if (bmi < 35) {
            return 'Obesidade grau I';
        } else if (bmi < 40) {
            return 'Obesidade grau II';
        } else {
            return 'Obesidade grau III';
        }
    }

    // Calcular IMC automaticamente quando altura ou peso mudarem
    $('#height, #weight').on('input', function() {
        const height = parseFloat($('#height').val());
        const weight = parseFloat($('#weight').val());
        
        if (height && weight) {
            const bmi = calculateBMI(height, weight);
            if (bmi) {
                $('#bmi').val(bmi.toFixed(1));
                $('#classification').val(getBMIClassification(bmi));
            }
        } else {
            $('#bmi').val('');
            $('#classification').val('');
        }
    });

    // Submissão do formulário
    $('#formRegisterWeight').on('submit', function(e) {
        e.preventDefault();

        const payload = {
            action: "add",
            client_id: Number($('#client_id').val()),
            height: parseFloat($('#height').val()),
            weight: parseFloat($('#weight').val()),
            bmi: $('#bmi').val() ? parseFloat($('#bmi').val()) : null,
            classification: $('#classification').val() || null
        };

        // Validação básica
        if (!payload.client_id) {
            swal("Erro!", "Por favor, selecione um cliente.", "error");
            return;
        }

        if (!payload.height || !payload.weight) {
            swal("Erro!", "Por favor, preencha altura e peso.", "error");
            return;
        }

        // Desabilitar botão durante o envio
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="icofont icofont-spinner-alt-3 icofont-spin mr-1"></i> Salvando...');

        fetch("routes/index.php?route=client-weights", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    swal({
                        title: "Sucesso!",
                        text: "Registro de peso salvo com sucesso.",
                        icon: "success",
                        buttons: {
                            list: {
                                text: "Ver Lista",
                                value: "list",
                                className: "btn-info"
                            },
                            new: {
                                text: "Novo Registro",
                                value: "new",
                                className: "btn-success"
                            }
                        }
                    }).then((value) => {
                        if (value === "list") {
                            window.location.href = "link.php?route=23";
                        } else if (value === "new") {
                            $('#formRegisterWeight')[0].reset();
                            $('#bmi').val('');
                            $('#classification').val('');
                        }
                    });
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => {
                console.error("Erro ao salvar registro:", err);
                swal("Erro!", "Erro ao salvar registro. Tente novamente.", "error");
            })
            .finally(() => {
                // Reabilitar botão
                submitBtn.prop('disabled', false).html(originalText);
            });
    });

    // Carregar clientes ao inicializar
    loadClients();
});
</script>

<?php include_once __DIR__ . './../../src/components/footer.php'; ?>
