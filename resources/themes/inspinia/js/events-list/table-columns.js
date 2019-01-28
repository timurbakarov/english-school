export default [
    {
        id: 'aggregate_id',
        label: 'AggregateID',
    },
    {
        id: 'name',
        label: 'Имя'
    },
    {
        id: 'date',
        label: 'Date'
    },
    {
        id: 'payload',
        label: 'Payload',
        component: {
            name: 'Payload',
            data(column, row) {
                return {
                    payload: row.payload
                };
            }
        }
    },
    {
        id: 'actions',
        label: 'Actions',
        component: {
            name: 'DeleteAction',
            data: (column, row) => {
                return {
                    url: row.delete_url
                };
            }
        }
    }
]
