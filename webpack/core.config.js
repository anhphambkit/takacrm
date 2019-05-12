const path = require('path');
module.exports = {
    resolve: {
        alias: {
            // handlebars: 'handlebars/dist/handlebars.min.js',
            // "@theme": path.resolve(__dirname, '../Packages/Theme/Resources/assets/js'),
            // "@frontend": path.resolve(__dirname, '../Packages/Frontend/Resources/assets/js'),
            // "@helper": path.resolve(__dirname, '../helper/js'),
            // "@resources": path.resolve(__dirname, '../resources/assets/js'),
            "@coreComponents": path.resolve('public/components/core'),
        }
    }
}
