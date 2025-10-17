<!-- Modal View Weight -->
<div class="modal fade" id="modalViewWeight" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="icofont icofont-eye"></i> Detalhes do Registro de Peso</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Cliente:</strong> <span id="view-client"></span></p>
                        <p><strong>Altura:</strong> <span id="view-height"></span></p>
                        <p><strong>Peso:</strong> <span id="view-weight"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>IMC:</strong> <span id="view-bmi"></span></p>
                        <p><strong>Classificação:</strong> <span id="view-classification"></span></p>
                        <p><strong>Data de Registro:</strong> <span id="view-date"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="icofont icofont-close"></i> Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Adicionar Peso -->
<div class="modal fade" id="modalAddWeight" tabindex="-1" role="dialog" aria-labelledby="addWeightModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addWeightModalLabel">
                    <i class="icofont icofont-plus"></i> Adicionar Registro de Peso
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="formAddWeight">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="add-client_id">Cliente <span class="text-danger">*</span></label>
                                <select class="form-control" id="add-client_id" name="client_id" required>
                                    <option value="">Selecione um cliente</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add-height">Altura (m) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="1" max="5.5" class="form-control" id="add-height" name="height" required>
                                <small class="form-text text-muted">Ex: 1.75</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add-weight">Peso (kg) <span class="text-danger">*</span></label>
                                <input type="number" step="0.1" min="20" max="300" class="form-control" id="add-weight" name="weight" required>
                                <small class="form-text text-muted">Ex: 70.2</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add-bmi">IMC</label>
                                <input type="number" step="0.1" class="form-control" id="add-bmi" name="bmi" readonly>
                                <small class="form-text text-muted">Calculado automaticamente</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add-classification">Classificação</label>
                                <input type="text" class="form-control" id="add-classification" name="classification" readonly>
                                <small class="form-text text-muted">Determinada automaticamente</small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="icofont icofont-close"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="icofont icofont-save"></i> Salvar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Peso -->
<div class="modal fade" id="modalEditWeight" tabindex="-1" role="dialog" aria-labelledby="editWeightModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editWeightModalLabel">
                    <i class="icofont icofont-edit"></i> Editar Registro de Peso
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="formEditWeight">
                    <input type="hidden" id="edit-weightid" name="id">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit-client_id">Cliente <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit-client_id" name="client_id" required>
                                    <option value="">Selecione um cliente</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit-height">Altura (m) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="1" max="2.5" class="form-control" id="edit-height" name="height" required>
                                <small class="form-text text-muted">Ex: 1.75</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit-weight">Peso (kg) <span class="text-danger">*</span></label>
                                <input type="number" step="0.1" min="20" max="300" class="form-control" id="edit-weight" name="weight" required>
                                <small class="form-text text-muted">Ex: 70.2</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit-bmi">IMC</label>
                                <input type="number" step="0.1" class="form-control" id="edit-bmi" name="bmi" readonly>
                                <small class="form-text text-muted">Calculado automaticamente</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit-classification">Classificação</label>
                                <input type="text" class="form-control" id="edit-classification" name="classification" readonly>
                                <small class="form-text text-muted">Determinada automaticamente</small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="icofont icofont-close"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="icofont icofont-save"></i> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete Weight -->
<div class="modal fade" id="modalDeleteWeight" tabindex="-1" role="dialog" aria-labelledby="deleteWeightModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteWeightModalLabel">
                    <i class="icofont icofont-trash"></i> Confirmar Exclusão
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <input type="hidden" id="delete-weightid">
                <i class="icofont icofont-warning text-warning" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Tem certeza que deseja excluir este registro?</h5>
                <p class="text-muted">
                    Registro do cliente: <strong id="delete-client"></strong><br>
                    Esta ação não pode ser desfeita.
                </p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="icofont icofont-close"></i> Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteWeight">
                    <i class="icofont icofont-trash"></i> Sim, Excluir
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Função para calcular IMC e classificação automaticamente
function calculateBMI(height, weight) {
    if (height && weight && height > 0 && weight > 0) {
        // Altura já está em metros
        const bmi = weight / (height * height);
        return bmi;
    }
    return null;
}

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

// Calcular BMI automaticamente no modal de adicionar
$('#add-height, #add-weight').on('input', function() {
    const height = parseFloat($('#add-height').val());
    const weight = parseFloat($('#add-weight').val());
    
    if (height && weight) {
        const bmi = calculateBMI(height, weight);
        if (bmi) {
            $('#add-bmi').val(bmi.toFixed(1));
            $('#add-classification').val(getBMIClassification(bmi));
        }
    } else {
        $('#add-bmi').val('');
        $('#add-classification').val('');
    }
});

// Calcular BMI automaticamente no modal de editar
$('#edit-height, #edit-weight').on('input', function() {
    const height = parseFloat($('#edit-height').val());
    const weight = parseFloat($('#edit-weight').val());
    
    if (height && weight) {
        const bmi = calculateBMI(height, weight);
        if (bmi) {
            $('#edit-bmi').val(bmi.toFixed(1));
            $('#edit-classification').val(getBMIClassification(bmi));
        }
    } else {
        $('#edit-bmi').val('');
        $('#edit-classification').val('');
    }
});
</script>
