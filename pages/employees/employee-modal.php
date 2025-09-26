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





<!-- Modal Editar Funcionário -->
<div class="modal fade" id="modalEditEmployee" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editEmployeeModalLabel">Editar Funcionário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="formEditEmployee">
                    <input type="hidden" id="edit-employeeid" name="id">

                    <!-- Nome -->
                    <div class="form-group">
                        <label for="edit-nome">Nome Completo</label>
                        <input type="text" class="form-control" id="edit-nome" name="name" required>
                    </div>

                    <!-- Número de BI -->
                    <div class="form-group">
                        <label for="edit-bi">Número de B.I</label>
                        <input type="text" class="form-control" id="edit-bi" name="bi" required>
                    </div>

                    <!-- Telefone -->
                    <div class="form-group">
                        <label for="edit-telefone">Número de Telefone</label>
                        <input type="text" class="form-control" id="edit-telefone" name="phoneNumber" required>
                    </div>

                    <!-- Posições -->
                    <div class="form-group">
                        <label for="edit-selectPosition">Posições</label>
                        <div class="input-group mb-2">
                            <select class="form-control" id="selectPosition">
                                <option value="">Selecione uma posição</option>
                                <option value="1">Gestor</option>
                                <option value="2">Motorista</option>
                                <option value="3">Caixa</option>
                                <option value="4">Vendedor</option>
                            </select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-success" onclick="addPosition()">Adicionar</button>
                            </div>
                        </div>
                        <!-- Lista de posições já adicionadas -->
                        <ul id="positionsList" class="list-group"></ul>
                    </div>

                    <!-- Botões -->
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


<script>
let positions = []; // vai guardar os IDs das posições escolhidas

function addPosition() {
    const select = document.getElementById("selectPosition");
    const value = select.value;
    const text = select.options[select.selectedIndex].text;

    if (value && !positions.includes(parseInt(value))) {
        positions.push(parseInt(value));

        const li = document.createElement("li");
        li.className = "list-group-item d-flex justify-content-between align-items-center";
        li.textContent = text;

        const removeBtn = document.createElement("button");
        removeBtn.className = "btn btn-danger btn-sm";
        removeBtn.textContent = "Remover";
        removeBtn.onclick = function() {
            positions = positions.filter(id => id !== parseInt(value));
            li.remove();
        };

        li.appendChild(removeBtn);
        document.getElementById("positionsList").appendChild(li);
    }
}
</script>



<!-- Modal Delete Patient -->
<div class="modal fade" id="modalDeleteEmployee" tabindex="-1" role="dialog" aria-hidden="true">
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
                <input type="hidden" id="delete-employeeid">
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="feather icon-x"></i> Cancelar
                </button>
                <button type="button" id="confirmDeleteEmployee" class="btn btn-danger">
                    <i class="feather icon-trash-2"></i> Excluir
                </button>
            </div>
        </div>
    </div>
</div>