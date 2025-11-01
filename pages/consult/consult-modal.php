<!-- Modal Ver Detalhes do Medicamento -->
<!-- Modal de Visualização de Consulta -->
<div class="modal fade" id="modalViewConsult" tabindex="-1" role="dialog" aria-labelledby="viewConsultaLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewConsultaLabel">Detalhes da Consulta</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <!-- Data -->
                    <div class="col-md-6 mb-3">
                        <strong>Data da Consulta:</strong>
                        <p id="view-date" class="text-muted mb-0"></p>
                    </div>

                    <!-- Hora -->
                    <div class="col-md-6 mb-3">
                        <strong>Hora:</strong>
                        <p id="view-time" class="text-muted mb-0"></p>
                    </div>

                    <!-- Tipo -->
                    <div class="col-md-6 mb-3">
                        <strong>Tipo de Consulta:</strong>
                        <p id="view-type" class="text-muted mb-0"></p>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <strong>Status:</strong>
                        <p id="view-status" class="text-muted mb-0"></p>
                    </div>

                    <!-- Paciente -->
                    <div class="col-md-6 mb-3">
                        <strong>Paciente (ID):</strong>
                        <p id="view-patient_id" class="text-muted mb-0"></p>
                    </div>

                    <!-- Médico -->
                    <div class="col-md-6 mb-3">
                        <strong>Médico (ID):</strong>
                        <p id="view-doctor_id" class="text-muted mb-0"></p>
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



<!-- Modal Editar Consulta -->
<div class="modal fade" id="modalEditConsult" tabindex="-1" role="dialog" aria-labelledby="modalEditConsultaLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalEditConsultaLabel">
                    <i class="feather icon-edit"></i> Editar Consulta
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="formEditConsult">
                <div class="modal-body">

                    <input type="hidden" id="edit-consultid">

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="edit-date">Data da Consulta</label>
                            <input type="date" class="form-control" id="edit-date" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="edit-time">Hora</label>
                            <input type="time" class="form-control" id="edit-time" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="edit-type">Tipo de Consulta</label>
                            <input type="text" class="form-control" id="edit-type" placeholder="Ex: Consulta de Rotina"
                                required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="edit-patientid">Paciente</label>
                            <select class="form-control" id="edit-patient_id" required>

                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="edit-doctorid">Médico</label>
                            <select class="form-control" id="edit-doctor_id" required>

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit-status">Estado</label>
                        <select class="form-control" id="edit-status" required>
                            <option value="0">Pendente</option>
                            <option value="1">Concluída</option>
                            <option value="2">Cancelada</option>
                        </select>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="feather icon-x"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="feather icon-save"></i> Atualizar Consulta
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