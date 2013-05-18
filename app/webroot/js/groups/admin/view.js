require(['domReady', 'helpers/DateTimeHelper', 'dataTables'], function (domReady, DateTimeHelper) {
    "use strict";

    domReady(function () {
        $('#group').dataTable({
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
            sPaginationType: "full_numbers",
            sAjaxSource:     window.location + '.json',
            aoColumns:       [
                { mData: "id" },
                {
                    sTitle: 'Titel',
                    sWidth: "10%",
                    mData:  "title"
                },
                {
                    sTitle: 'Vorname',
                    sWidth: "15%",
                    mData:  "firstname"
                },
                {
                    sTitle: 'Nachname',
                    sWidth: "15%",
                    mData:  "lastname"
                },
                {
                    sTitle: 'Email',
                    sWidth: "25%",
                    mData:  "email"
                },
                {
                    sTitle: 'Konto Aktiv?',
                    sWidth: "10%",
                    mData:  "active"
                },
                {
                    sTitle: 'Konto erstellt am',
                    sWidth: "15%",
                    mData:  "created"
                },
                {
                    sTitle: 'Bearbeiten',
                    sWidth: '5%',
                    mData:  'edit'
                }
            ],
            aoColumnDefs:    [
                { bSearchable: false, bVisible: false, aTargets: [ 0 ] },
                {
                    aTargets:    [ 5 ],
                    bSearchable: false,
                    mRender:     function (data, type, full) {
                        return parseInt(data, 10) === 1 ? 'Ja' : 'Nein';
                    }
                },
                {
                    aTargets: [6],
                    mRender:  function (data, type, full) {
                        console.log(data);
                        return DateTimeHelper.prettifySqlTimestamp(data);
                    }
                },
                {
                    aTargets:    [ 7 ],
                    bSearchable: false,
                    mData:       "Bearbeiten",
                    mRender:     function (data, type, full) {
                        return '<a class="btn-link" href="' + data + '">Bearbeiten</a>';
                    }
                }

            ]
        });
    });
});