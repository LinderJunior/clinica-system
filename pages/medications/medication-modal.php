<!-- Modal Ver Detalhes do Medicamento -->
<div class="modal fade" id="modalViewMedication" tabindex="-1" role="dialog" aria-labelledby="viewMedicationLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewMedicationLabel">
                    <i class="feather icon-eye"></i> Detalhes do Medicamento
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <!-- Nome -->
                    <div class="col-md-6 mb-3">
                        <label><strong>Nome:</strong></label>
                        <p id="view-name" class="text-muted">--</p>
                    </div>

                    <!-- Tipo -->
                    <div class="col-md-6 mb-3">
                        <label><strong>Tipo:</strong></label>
                        <p id="view-type" class="text-muted">--</p>
                    </div>

                    <!-- Data de Produção -->
                    <div class="col-md-6 mb-3">
                        <label><strong>Data de Produção:</strong></label>
                        <p id="view-dateProduction" class="text-muted">--</p>
                    </div>

                    <!-- Data de Expiração -->
                    <div class="col-md-6 mb-3">
                        <label><strong>Data de Expiração:</strong></label>
                        <p id="view-dateExpiry" class="text-muted">--</p>
                    </div>

                    <!-- Quantidade -->
                    <div class="col-md-6 mb-3">
                        <label><strong>Quantidade (QTY):</strong></label>
                        <p id="view-qty" class="text-muted">--</p>
                    </div>

                    <!-- Número de Lote -->
                    <div class="col-md-6 mb-3">
                        <label><strong>Número de Lote:</strong></label>
                        <p id="view-loteNumber" class="text-muted">--</p>
                    </div>

                    <!-- Preço de Compra -->
                    <div class="col-md-6 mb-3">
                        <label><strong>Preço de Compra:</strong></label>
                        <p id="view-purchasePrice" class="text-muted">--</p>
                    </div>

                    <!-- Preço de Venda -->
                    <div class="col-md-6 mb-3">
                        <label><strong>Preço de Venda:</strong></label>
                        <p id="view-salePrice" class="text-muted">--</p>
                    </div>

                    <!-- Data de Registo -->
                    <div class="col-md-6 mb-3">
                        <label><strong>Data de Registo:</strong></label>
                        <p id="view-registationDate" class="text-muted">--</p>
                    </div>

                    <!-- Usuário Responsável -->
                    <div class="col-md-6 mb-3">
                        <label><strong>Usuário (ID):</strong></label>
                        <p id="view-user" class="text-muted">--</p>
                    </div>

                    <!-- Descrição -->
                    <div class="col-md-12 mb-3">
                        <label><strong>Descrição:</strong></label>
                        <p id="view-description" class="text-muted">--</p>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="feather icon-x"></i> Fechar
                </button>
            </div>
        </div>
    </div>
</div>




<!-- Modal Editar Medicamento -->
<div class="modal fade" id="modalEditMedication" tabindex="-1" role="dialog" aria-labelledby="editMedicationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editMedicationModalLabel">
                    <i class="feather icon-edit"></i> Editar Medicamento
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="formEditMedication">
                    <input type="hidden" id="edit-medicationid" name="id">

                    <!-- Nome -->
                    <div class="form-group row">
                        <label for="edit-name" class="col-sm-2 col-form-label">Nome do Medicamento</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="edit-name" name="name"
                                placeholder="Ex: Amoxicilina" required>
                        </div>
                    </div>

                    <!-- Tipo -->
                    <div class="form-group row">
                        <label for="edit-type" class="col-sm-2 col-form-label">Tipo</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="edit-type" name="type"
                                placeholder="Ex: Antibiótico" required>
                        </div>
                    </div>

                    <!-- Data de Produção -->
                    <div class="form-group row">
                        <label for="edit-dateProduction" class="col-sm-2 col-form-label">Data de Produção</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="edit-dateProduction" name="dateProduction"
                                required>
                        </div>
                    </div>

                    <!-- Data de Expiração -->
                    <div class="form-group row">
                        <label for="edit-dateExpiry" class="col-sm-2 col-form-label">Data de Expiração</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="edit-dateExpiry" name="dateExpiry" required>
                        </div>
                    </div>

                    <!-- Quantidade -->
                    <div class="form-group row">
                        <label for="edit-qty" class="col-sm-2 col-form-label">Quantidade</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="edit-qty" name="qty" placeholder="Ex: 80"
                                required>
                        </div>
                    </div>

                    <!-- Número do Lote -->
                    <div class="form-group row">
                        <label for="edit-loteNumber" class="col-sm-2 col-form-label">Número do Lote</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="edit-loteNumber" name="loteNumber"
                                placeholder="Ex: 78901" required>
                        </div>
                    </div>

                    <!-- Preço de Compra -->
                    <div class="form-group row">
                        <label for="edit-purchasePrice" class="col-sm-2 col-form-label">Preço de Compra (MZN)</label>
                        <div class="col-sm-10">
                            <input type="number" step="0.01" class="form-control" id="edit-purchasePrice"
                                name="purchasePrice" placeholder="Ex: 15.75" required>
                        </div>
                    </div>

                    <!-- Preço de Venda -->
                    <div class="form-group row">
                        <label for="edit-salePrice" class="col-sm-2 col-form-label">Preço de Venda (MZN)</label>
                        <div class="col-sm-10">
                            <input type="number" step="0.01" class="form-control" id="edit-salePrice" name="salePrice"
                                placeholder="Ex: 25.00" required>
                        </div>
                    </div>

                    <!-- Data de Registo -->
                    <div class="form-group row">
                        <label for="edit-registationDate" class="col-sm-2 col-form-label">Data de Registo</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="edit-registationDate" name="registationDate"
                                required>
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div class="form-group row">
                        <label for="edit-description" class="col-sm-2 col-form-label">Descrição</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="edit-description" name="description" rows="3"
                                placeholder="Breve descrição do medicamento"></textarea>
                        </div>
                    </div>

                    <!-- Usuário -->
                    <div class="form-group row">
                        <label for="edit-user" class="col-sm-2 col-form-label">Usuário Responsável</label>
                        <div class="col-sm-10">
                            <select id="edit-user" class="form-control" name="user_id" required>
                                <option value="">Selecione o usuário</option>
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>">Usuário <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="feather icon-x"></i> Cancelar
                </button>
                <button type="submit" form="formEditMedication" class="btn btn-info text-white">
                    <i class="feather icon-save"></i> Salvar Alterações
                </button>
            </div>

        </div>
    </div>
</div>




<!-- Modal Delete Patient -->
<div class="modal fade" id="modalDeleteMedication" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="feather icon-trash-2"></i> Confirmar Exclusão</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Deseja realmente excluir o usuário <strong id="delete-username"></strong>?</p>
                <input type="hidden" id="delete-medicationid">
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="feather icon-x"></i> Cancelar
                </button>
                <button type="button" id="confirmDeleteMedication" class="btn btn-danger">
                    <i class="feather icon-trash-2"></i> Excluir
                </button>
            </div>
        </div>
    </div>
</div>