<!-- Modal de Visualização da Consulta -->
<div class="modal fade" id="viewConsultModal" tabindex="-1" aria-labelledby="viewConsultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewConsultModalLabel">Detalhes da Consulta</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">ID</label>
                        <input type="text" class="form-control" id="view_id" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Consulta ID</label>
                        <input type="text" class="form-control" id="view_consult_id" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Doutor</label>
                        <input type="text" class="form-control" id="view_doctor_id" readonly>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Detalhes</label>
                        <textarea class="form-control" id="view_details" rows="3" readonly></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Arquivo</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="view_file" readonly>
                            <a href="#" id="view_file_link" target="_blank" class="btn btn-outline-info">Abrir
                                Arquivo</a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>





<!-- MODAL: Editar Diagnóstico -->
<div class="modal fade" id="modalEditDiagnosis" tabindex="-1" role="dialog" aria-labelledby="modalEditDiagnosisLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalEditDiagnosisLabel">
                    <i class="icofont icofont-ui-edit"></i> Editar Diagnóstico
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="formEditDiagnosis">
                <div class="modal-body">
                    <input type="hidden" id="edit-diagnosisid">

                    <div class="form-group">
                        <label for="edit-details">Detalhes do Diagnóstico</label>
                        <textarea class="form-control" id="edit-details" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="edit-file">Arquivo (Exame/Relatório)</label>
                        <input type="text" class="form-control" id="edit-file" placeholder="exame_resultado.pdf">
                        <small class="form-text text-muted">Informe o nome do arquivo anexado.</small>
                    </div>

                    <div class="form-group">
                        <label for="edit-consult_id">Consulta Associada</label>
                        <select id="edit-consult_id" class="form-control" required>
                            <option value="">Selecione uma consulta</option>
                            <option value="1">Consulta - Linder Aeroporto</option>
                            <option value="2">Consulta - Pedro Nunes</option>
                            <option value="3">Consulta - Elsa Tavares</option>
                            <option value="4">Consulta - Nelson Lopes</option>
                            <option value="5">Consulta - Ana Silva</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit-doctor_id">Médico Responsável</label>
                        <select id="edit-doctor_id" class="form-control" required>
                            <option value="">Selecione um médico</option>
                            <option value="1">Dr. João Matos</option>
                            <option value="2">Dr. Pedro Nunes</option>
                            <option value="3">Dra. Carla Mendes</option>
                            <option value="4">Dr. Nelson Gomes</option>
                            <option value="5">Dra. Maria Tavares</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="icofont icofont-save"></i> Atualizar Diagnóstico
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>



<!-- Modal Delete Patient -->
<div class="modal fade" id="modalDeleteConsult" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="feather icon-trash-2"></i> Confirmar Exclusão</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Deseja realmente excluir a consulta <strong id="delete-username"></strong>?</p>
                <input type="hidden" id="delete-consultid">
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