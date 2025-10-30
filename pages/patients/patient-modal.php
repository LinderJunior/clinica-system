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
                        <select class="form-control" id="edit-iswhatsapp" name="iswhatsapp" required>
                            <option value="">Selecione</option>
                            <option value="1">Sim</option>
                            <option value="2">Não</option>
                        </select>
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




<script>
document.addEventListener("DOMContentLoaded", function() {
    function waitForFlatpickr(attemptsLeft = 5) {
        if (window.flatpickr) {
            initFlatpickrs();
        } else if (attemptsLeft > 0) {
            setTimeout(() => waitForFlatpickr(attemptsLeft - 1), 200);
        } else {
            loadFlatpickrDynamically().then(initFlatpickrs).catch(err => {
                console.error("Não foi possível carregar o flatpickr:", err);
            });
        }
    }

    function loadFlatpickrDynamically() {
        return new Promise((resolve, reject) => {
            const s = document.createElement('script');
            s.src = "https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js";
            s.onload = () => {
                const s2 = document.createElement('script');
                s2.src = "https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js";
                s2.onload = resolve;
                s2.onerror = reject;
                document.body.appendChild(s2);
            };
            s.onerror = reject;
            document.body.appendChild(s);
        });
    }

    function initFlatpickrs() {
        // Seleciona todos os campos de data que precisas
        const dateFields = [
            document.getElementById("txtdatanascimento"), // formulário de registo
            document.getElementById("edit-datanascimento") // modal de edição
        ];

        dateFields.forEach(el => {
            if (el) {
                flatpickr(el, {
                    dateFormat: "Y-m-d", // formato interno (para o backend)
                    altInput: true,
                    altFormat: "d/m/Y", // formato visível (mocambicano)
                    locale: "pt",
                    maxDate: "today",
                    disableMobile: true
                });
                el.placeholder = "dd/mm/yyyy";
            }
        });
    }

    waitForFlatpickr();
});
</script>