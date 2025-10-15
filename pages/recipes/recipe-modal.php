<div class="modal fade" id="modalViewRecipe" tabindex="-1" aria-labelledby="viewRecipeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewRecipeLabel">📜 Detalhes da Receita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <div class="row g-3">
                    <div class="col-md-3">
                        <label>ID</label>
                        <input type="text" id="view_recipe_id" class="form-control" readonly>
                    </div>
                    <div class="col-md-3">
                        <label>Data</label>
                        <input type="text" id="view_date" class="form-control" readonly>
                    </div>
                    <div class="col-md-3">
                        <label>Consulta</label>
                        <input type="text" id="view_consult_id" class="form-control" readonly>
                    </div>
                    <div class="col-md-3">
                        <label>Data da Consulta</label>
                        <input type="text" id="view_consult_date" class="form-control" readonly>
                    </div>

                    <div class="col-md-4">
                        <label>Hora</label>
                        <input type="text" id="view_consult_time" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label>Paciente</label>
                        <input type="text" id="view_patient_name" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label>Médico</label>
                        <input type="text" id="view_doctor_name" class="form-control" readonly>
                    </div>

                    <div class="col-md-12 mt-3">
                        <h6 class="text-secondary">💊 Medicamentos</h6>
                        <table class="table table-bordered" id="tableRecipeMeds">
                            <thead class="table-light">
                                <tr>
                                    <th>Medicamento</th>
                                    <th>Tipo</th>
                                    <th>Quantidade</th>
                                    <th>Dosagem</th>
                                    <th>Preço Unit.</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="recipeMedsBody">
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Sem medicamentos</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-4 ms-auto">
                        <label>Total da Receita (MT)</label>
                        <input type="text" id="view_total_price" class="form-control text-end fw-bold" readonly>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Edit -->
<div class="modal fade" id="modalEditRecipe" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">✏️ Editar Receita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-recipeid">
                <div class="mb-3">
                    <label>Data</label>
                    <input type="date" id="edit-date" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Consulta</label>
                    <input type="number" id="edit-consult_id" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Médico</label>
                    <input type="text" id="edit-doctor_name" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Total (MT)</label>
                    <input type="text" id="edit-total_price" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">
                    <i class="icofont icofont-save"></i> Atualizar Diagnóstico
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modalDeleteRecipe" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">🗑️ Excluir Receita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="delete-recipeid">
                <p>Tem certeza que deseja excluir a receita de <strong id="delete-recipename"></strong>?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="feather icon-x"></i> Cancelar
                </button>
                <button type="button" id="confirmDeleteConsult" class="btn btn-danger">
                    <i class="feather icon-trash-2"></i> Excluir
                </button>
            </div>
        </div>
    </div>
</div>