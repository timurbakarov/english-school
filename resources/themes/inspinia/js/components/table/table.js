export default {
    // props: {
    //     table: {
    //         type: Object
    //     },
    //     showHead: {
    //         default: true,
    //         type: Boolean
    //     }
    // },
    template: '<div class="full-height-scroll">' +
    '        <div class="table-responsive">' +
    '            <table class="table table-striped table-hover">' +
                    '<slot></slot>' +
    '            </table>' +
    '        </div>' +
    '    </div>'
}
