<!-- Modal View User -->
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="feather icon-eye"></i> Detalhes do Usuário</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Username:</strong> <span id="view-username"></span></p>
                <p><strong>Employee ID:</strong> <span id="view-employee_id"></span></p>
                <p><strong>Role:</strong> <span id="view-role"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="feather icon-x"></i> Fechar
                </button>
            </div>
        </div>
    </div>
</div>








<!-- Modal Editar Paciente -->
<div class="modal fade" id="modalEditPatient" tabindex="-1" role="dialog" aria-labelledby="editPatientModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editPatientModalLabel">Editar Paciente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="formEditPatient">
                    <input type="hidden" id="edit-patientid" name="id">

                    <div class="form-group">
                        <label for="edit-nome">Nome do Paciente</label>
                        <input type="text" class="form-control" id="edit-nome" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="editDataNascimento">Data de Nascimento</label>
                        <input type="date" class="form-control" id="edit-datanascimento" name="dateBirth" required>
                    </div>

                    <div class="form-group">
                        <label for="editBi">Número de B.I</label>
                        <input type="text" class="form-control" id="edit-bi" name="bi" required>
                    </div>

                    <div class="form-group">
                        <label for="editProvincia">Província</label>
                        <input type="text" class="form-control" id="edit-provincia" name="province" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-cidade">Cidade</label>
                        <input type="text" class="form-control" id="edit-cidade" name="city" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-bairro">Bairro</label>
                        <input type="text" class="form-control" id="edit-bairro" name="neighborhood" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-telefone">Número de Telefone</label>
                        <input type="text" class="form-control" id="edit-telefone" name="phoneNumber" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-iswhatsapp">Tem WhatsApp</label>
                        <input type="text" class="form-control" id="edit-iswhatsapp" name="iswhatsapp" required>
                    </div>

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




<!-- Modal Edit User
<div class="modal fade" id="modalEditUser2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="feather icon-edit"></i> Editar Usuário</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditUser">
                <div class="modal-body">
                    <input type="hidden" id="edit-userid" name="id">

                    <div class="form-group">
                        <label for="edit-username">Username</label>
                        <input type="text" class="form-control" id="edit-username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-password">Password</label>
                        <input type="password" class="form-control" id="edit-password" name="password">
                        <small class="form-text text-muted">Deixe em branco se não quiser alterar a senha.</small>
                    </div>

                    <div class="form-group">
                        <label for="edit-employee_id">Employee ID</label>
                        <input type="number" class="form-control" id="edit-employee_id" name="employee_id" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-role_id">Role</label>
                        <select id="edit-role_id" name="role_id" class="form-control" required>
                            <option value="1">Admin</option>
                            <option value="2">Caixa</option>
                            <option value="3">Cobrança</option>
                            <option value="4">User</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="feather icon-x"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-info text-white">
                        <i class="feather icon-save"></i> Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> -->









<!-- Modal Delete Patient -->
<div class="modal fade" id="modalDeletePatient" tabindex="-1" role="dialog" aria-hidden="true">
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
                <input type="hidden" id="delete-patientid">
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="feather icon-x"></i> Cancelar
                </button>
                <button type="button" id="confirmDeletePatient" class="btn btn-danger">
                    <i class="feather icon-trash-2"></i> Excluir
                </button>
            </div>
        </div>
    </div>
</div>