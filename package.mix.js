let mix      = require('laravel-mix');
const path   = require('path');
let argv     = require('yargs').argv;
let readdirp = require('readdirp');
const core   = require('./webpack/core.config');
const fs     = require('fs');
let klawSync = require('klaw-sync');
/*
 * Some config to load Handlebarsjs
 */
mix.disableNotifications();
mix.webpackConfig(core);
mix.options({ processCssUrls: false, poll: true });
/**
 * Scan all folder in parent dir
 * @param p: path to folder
 */
const dirs = p => fs.readdirSync(p).filter(f => fs.statSync(path.resolve(p, f)).isDirectory());

/**
 * Scan all js/scss files in folder
 * @param p: path to folder
 */
const files = (p) => {
    return fs.readdirSync(p).filter(f => {
        let extension = f.split('.').pop();
        return fs.statSync(path.resolve(p, f)).isFile() && (extension === 'js' || extension === 'scss');
    });
};

/**
 * Parse klaw files to array path
 * @param  {[type]} files [description]
 * @return {[type]}       [description]
 */
const parseFiles = (files) => {
    let allFiles = [];
    files.forEach(function (resultPath) {
        if(fs.lstatSync(resultPath.path).isFile()) {
            allFiles.push({
                filePath : resultPath.path,
                fileName : path.parse(resultPath.path).base
            })
        }
    });
    return allFiles;
}

/**
 * Bundle js and css for developer
 * @param configs
 * @param dir
 * @param isScript
 */
const bundleDevelopment = (configs = {}, dir = 'frontend', isScript = false) => {
    let dirscan = undefined;
    let allFiles = [];
    Object.keys(configs).forEach(function (key) {
        dirscan = configs[key];
        if(fs.existsSync(dirscan)){
            allFiles = klawSync(dirscan);
            allFiles = parseFiles(allFiles);
            allFiles.forEach(function (file) {
                let prefix   = (isScript) ? 'scripts' : (key == 'js' ? key : 'css');
                let extension   = (isScript || key == 'js') ? 'js' : 'css';
                let tempArr  = file.fileName.split('.').slice(0, -1);
                let fileName = [];
                Object.keys(tempArr).map(function(index) {
                  fileName.push(tempArr[index]);
                });
                fileName.push(extension);
                fileName = fileName.join('.');
                let fileBuild = path.resolve(`public/${dir}/${basedir}`, packageName.toLowerCase(), `assets/${prefix}`, fileName);
                (prefix == 'js' || prefix == 'scripts') ? mix.js(file.filePath, fileBuild).sourceMaps() : mix.sass(file.filePath, fileBuild).sourceMaps();
            });
        }
    });
}

let env            = argv.env;
let packageName    = env.pkg;
let basedir        = env.dir || "core";
let resourcePath   = `./${basedir}/${packageName}/resources/assets`;
let libsPath   = `./${basedir}/${packageName}/resources/libs`;
let componentsPath   = `./${basedir}/${packageName}/resources/components`;
let mediaPath   = `./${basedir}/${packageName}/resources/media`;
let configs = [
    {
        config: {
            js : `${resourcePath}/js/frontend`,
            scss : `${resourcePath}/scss/frontend`
        },
        key : 'frontend',
        is_script: false
    },
    {
        config: {
            js : `${resourcePath}/js/backend`,
            scss : `${resourcePath}/scss/backend`
        },
        key : 'backend',
        is_script: false
    },
    {
        config: {
            js : `${resourcePath}/scripts/backend`,
        },
        key : 'backend',
        is_script: true
    },
];

if (fs.existsSync(libsPath))
    mix.copyDirectory(libsPath, `public/libs/${basedir}/${packageName.toLowerCase()}/`);

if (fs.existsSync(componentsPath))
    mix.copyDirectory(componentsPath, `public/components/${basedir}/${packageName.toLowerCase()}/`);

if (fs.existsSync(mediaPath))
    mix.copyDirectory(mediaPath, `public/media/${basedir}/${packageName.toLowerCase()}/`);

configs.forEach((item) => {
    bundleDevelopment(item.config, item.key, item.is_script);
})

