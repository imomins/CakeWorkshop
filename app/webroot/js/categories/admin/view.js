require(['domReady', 'dataTables'], function (domReady) {
    "use strict";

    domReady(function () {
        $('#category').dataTable({
            oLanguage:       {
                sInfo:        "Anzeige von _START_ bis _END_ von insgesamt _TOTAL_ Einträgen",
                sSearch:      "Suche",
                sProcessing:  "<span class='label label-important'>Lade...</span>",
                sZeroRecords: "Nichts gefunden",
                sLengthMenu:  "Angezeigte Einträge  _MENU_",
                oPaginate:    {
                    sFirst:    'Erste Seite',
                    sNext:     'Weiter',
                    sPrevious: 'Zurück',
                    sLast:     'Letzte Seite'
                }
            },
            bProcessing:     true,
            iDisplayLength:  10,
            sPaginationType: "full_numbers"
        });
    });
});