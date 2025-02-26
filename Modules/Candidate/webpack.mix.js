const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.disableNotifications();

mix.setPublicPath('../../public').mergeManifest();

mix.sass( __dirname + '/Resources/assets/sass/app.scss', 'css/candidate/candidate.css')
    .js(__dirname + '/Resources/assets/js/login/login.js', 'js/candidate/login/login.js')
    .js(__dirname + '/Resources/assets/js/candidate/candidate.js', 'js/candidate/candidate.js')
    .js(__dirname + '/Resources/assets/js/candidate/record.js', 'js/candidate/record.js')
    .js(__dirname + '/Resources/assets/js/candidate/device_test.js', 'js/candidate/device_test.js')
    .js(__dirname + '/Resources/assets/js/candidate/uploadWorker.js', 'js/candidate/uploadWorker.js')
    .js(__dirname + '/Resources/assets/js/login/otp.js', 'js/candidate/login/otp.js');

if (mix.inProduction()) {
    mix.version();
}
