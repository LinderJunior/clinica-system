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

<!-- Modal Edit User -->
<div class="modal fade" id="modalEditUser" tabindex="-1" role="dialog" aria-hidden="true">
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
</div>


<!-- Modal Delete User -->
<div class="modal fade" id="modalDeleteUser" tabindex="-1" role="dialog" aria-hidden="true">
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
                <input type="hidden" id="delete-userid">
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="feather icon-x"></i> Cancelar
                </button>
                <button type="button" id="confirmDeleteUser" class="btn btn-danger">
                    <i class="feather icon-trash-2"></i> Excluir
                </button>
            </div>
        </div>
    </div>
</div>






<!-- Modal Add User -->
<div class="modal fade" id="modalAddUser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="icofont icofont-plus"></i> Novo Usuário</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAddUser">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add-username">Username</label>
                        <input type="text" class="form-control" id="add-username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="add-password">Password</label>
                        <input type="password" class="form-control" id="add-password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="add-employee_id">Employee ID</label>
                        <input type="number" class="form-control" id="add-employee_id" name="employee_id" required>
                    </div>

                    <div class="form-group">
                        <label for="add-role_id">Role</label>
                        <select id="add-role_id" name="role_id" class="form-control" required>
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
                        <i class="feather icon-save"></i> Adicionar Usuário
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>