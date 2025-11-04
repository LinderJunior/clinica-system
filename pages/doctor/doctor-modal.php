<!-- Modal Editar Médico -->
<div class="modal fade" id="modalEditDoctor" tabindex="-1" role="dialog" aria-labelledby="editDoctorModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <!-- Cabeçalho -->
            <div class="modal-header">
                <h5 class="modal-title" id="editDoctorModalLabel">Editar Médico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Corpo do Modal -->
            <div class="modal-body">
                <form id="formEditDoctor">
                    <input type="hidden" id="edit-doctorid" name="id">
                    <input type="hidden" id="edit-doctor-flag" name="doctor" value="1">

                    <!-- Nome -->
                    <div class="form-group">
                        <label for="edit-doctor-nome">Nome Completo</label>
                        <input type="text" class="form-control" id="edit-doctor-nome" name="name"
                            placeholder="Ex: Pedro Nunes Linder" required>
                    </div>

                    <!-- Número de BI -->
                    <div class="form-group">
                        <label for="edit-doctor-bi">Número de B.I</label>
                        <input type="text" class="form-control" id="edit-doctor-bi" name="bi"
                            placeholder="Ex: 003456789LA064" required>
                    </div>

                    <!-- Telefone -->
                    <div class="form-group">
                        <label for="edit-doctor-telefone">Número de Telefone</label>
                        <input type="text" class="form-control" id="edit-doctor-telefone" name="phoneNumber"
                            placeholder="Ex: 845678901" required>
                    </div>


                    <!-- Rodapé -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-info text-white">
                            <i class="feather icon-save"></i> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>





<div class="modal fade" id="modalEditPositions" tabindex="-1" role="dialog" aria-labelledby="modalEditPositionsLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalEditPositionsLabel">Gerenciar Posições do Médico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="positions-employee-id">
                <div class="form-group mb-3">
                    <label for="newPositionSelect" class="form-label">Adicionar nova posição:</label>
                    <div class="input-group">
                        <select class="form-control" id="newPositionSelect"></select>
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button" id="addPositionBtn">Adicionar</button>
                        </div>
                    </div>
                </div>

                <ul class="list-group" id="positionsList"></ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="savePositionsBtn">Salvar Alterações</button>
            </div>

        </div>
    </div>
</div>