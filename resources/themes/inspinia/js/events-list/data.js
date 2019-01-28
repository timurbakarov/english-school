import columns from './table-columns';

export default {
    table: {
        search: {
            query: search
        },
        massActions: [
            {
                label: 'Удалить',
                url: massDeleteUrl,
                onAction: function(table, ids) {
                    let rows = table.rows;
                    let leftRows = [];

                    _.forIn(rows, (row) => {
                        if(_.indexOf(ids, row.id) == -1) {
                            leftRows.push(row);
                        }
                    });

                    table.rows = leftRows;
                }
            }
        ],
        columns: columns,
        data: events
    }
}
