const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.disableNotifications();

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/employer/employer.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/employer/employer.css')
    .js(__dirname + '/Resources/assets/js/login/login.js', 'js/employer/login/login.js')
    .js(__dirname + '/Resources/assets/js/positions/positions.js', 'js/employer/positions/positions.js')
    .js(__dirname + '/Resources/assets/js/positions/positionview.js', 'js/employer/positions/positionview.js')
    .js(__dirname + '/Resources/assets/js/settings/settings.js', 'js/employer/settings/settings.js')
    .js(__dirname + '/Resources/assets/js/settings/setpass.js', 'js/employer/settings/setpass.js')
    .js(__dirname + '/Resources/assets/js/settings/updatepass.js', 'js/employer/settings/updatepass.js')
    .js(__dirname + '/Resources/assets/js/candidate/candidate.js', 'js/employer/candidate/candidate.js')
    .js(__dirname + '/Resources/assets/js/candidate/candidateview.js', 'js/employer/candidate/candidateview.js')
    .js(__dirname + '/Resources/assets/js/positions/positionadd.js', 'js/employer/positions/positionadd.js')
    .js(__dirname + '/Resources/assets/js/positions/shareposition.js', 'js/employer/positions/shareposition.js')
    .js(__dirname + '/Resources/assets/js/settings/companysettings.js', 'js/employer/settings/companysettings.js')
    .js(__dirname + '/Resources/assets/js/settings/careersettings.js', 'js/employer/settings/careersettings.js')
    .js(__dirname + '/Resources/assets/js/settings/qrcode.js', 'js/employer/settings/qrcode.js')
    .js(__dirname + '/Resources/assets/js/register/addedit.js', 'js/employer/register/addedit.js')
    .js(__dirname + '/Resources/assets/js/settings/upgradepackage.js', 'js/employer/settings/upgradepackage.js')
    .js(__dirname + '/Resources/assets/js/login/password-reset.js', 'js/employer/login/password-reset.js')
    .js(__dirname + '/Resources/assets/js/login/new-password.js', 'js/employer/login/new-password.js')
    .js(__dirname + '/Resources/assets/js/allcandidates/candidate.js', 'js/employer/allcandidates/candidate.js')
    .js(__dirname + '/Resources/assets/js/allcandidates/candidateview.js', 'js/employer/allcandidates/candidateview.js');



if (mix.inProduction()) {
    mix.version();
}
