let path = require('path');
let VueLoaderPlugin = require("vue-loader/lib/plugin");
require('dotenv-safe').config({
    allowEmptyValues: true,
    sample: '.env.example',
    path: '.env'
});

module.exports = {
    entry: {
        vendor: './resources/themes/' + process.env.APP_THEME + '/js/vendor.js',
        'groups-list-': './resources/themes/' + process.env.APP_THEME + '/js/groups-list.js',
        'groups-form': './resources/themes/' + process.env.APP_THEME + '/js/groups-form.js',
        'events-list': './resources/themes/' + process.env.APP_THEME + '/js/events-list.js',
        'student-view': './resources/themes/' + process.env.APP_THEME + '/js/student-view.js'
    },
    output: {
        path: path.resolve(__dirname, 'public/assets/js'),
        filename: '[name].js'
    },
    module: {
        rules: [
            // ... other rules
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /\.js$/,
                loader: 'babel-loader'
            },
            {
                test: /\.css$/,
                use: [
                    'vue-style-loader',
                    {
                        loader: 'css-loader'
                    }
                ]
            }
        ]
    },
    plugins: [
        // make sure to include the plugin!
        new VueLoaderPlugin()
    ],
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js'
        },
        extensions: ['*', '.js', '.vue', '.json']
    }
};
