function getExportButtons(tableId, title = "Relatório") {
    return [
        {
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> Excel',
            titleAttr: 'Exportar para Excel',
            className: 'btn btn-success btn-sm',
            title: title,
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> PDF',
            titleAttr: 'Exportar para PDF',
            className: 'btn btn-danger btn-sm',
            orientation: 'landscape',
            pageSize: 'A4',
            title: title,
            customize: function (doc) {
                // Cabeçalho
                doc.styles.tableHeader.alignment = 'left';
                doc.styles.title.fontSize = 14;
                doc.styles.title.alignment = 'center';
                doc.content.splice(0, 0, {
                    text: title,
                    fontSize: 16,
                    alignment: 'center',
                    margin: [0, 0, 0, 20]
                });

                // Rodapé
                doc['footer'] = (page, pages) => {
                    return {
                        columns: [
                            { text: 'Sistema Clínica © 2025', alignment: 'left', margin: [10, 0] },
                            { text: `Página ${page} de ${pages}`, alignment: 'right', margin: [0, 0, 10] }
                        ]
                    };
                };
            },
            exportOptions: {
                columns: ':visible'
            }
        }
    ];
}
