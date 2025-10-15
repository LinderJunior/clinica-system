function initDataTable(tableId, apiRoute, exportTitle) {
    const table = $(tableId).DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-danger btn-sm',
                orientation: 'landscape',
                pageSize: 'A4',
                title: exportTitle
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-success btn-sm',
                title: exportTitle
            }
        ],
        columnDefs: [{
            targets: -1,
            data: null,
            orderable: false,
            className: "text-center",
            defaultContent: `
                <button class="btn btn-sm btn-info btn-icon action" data-action="view" title="Visualizar">
                    <i class="icofont icofont-eye"></i>
                </button>
                <button class="btn btn-sm btn-primary btn-icon action" data-action="edit" title="Editar">
                    <i class="icofont icofont-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-icon action" data-action="delete" title="Deletar">
                    <i class="icofont icofont-trash"></i>
                </button>
            `
        }],
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "Nenhum registro encontrado",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Sem dados disponíveis",
            infoFiltered: "(filtrado de _MAX_ registros no total)",
            search: "Pesquisar:",
            paginate: {
                first: "Primeiro",
                last: "Último",
                next: "Próximo",
                previous: "Anterior"
            }
        }
    });

    // Carrega dados via API
    function loadData() {
        fetch(apiRoute)
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    table.clear();
                    data.data.forEach(row => {
                        const rowData = Object.values(row);
                        rowData.push(null); // coluna ações
                        table.row.add(rowData);
                    });
                    table.draw();
                }
            }).catch(err => console.error(err));
    }

    loadData();
    return table;
}
