const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.disableNotifications();

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/admin/admin.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/admin/admin.css')
    .js(__dirname + '/Resources/assets/js/login/login.js', 'js/admin/login/login.js')
    .js(__dirname + '/Resources/assets/js/users/users.js', 'js/admin/users/users.js')
    .js(__dirname + '/Resources/assets/js/roles/addrole.js', 'js/admin/roles/addrole.js')
    .js(__dirname + '/Resources/assets/js/packages/packages.js', 'js/admin/packages/packages.js')
    .js(__dirname + '/Resources/assets/js/positions/positions.js', 'js/admin/positions/positions.js')
    .js(__dirname + '/Resources/assets/js/packages/addedit.js', 'js/admin/packages/addedit.js')
    .js(__dirname + '/Resources/assets/js/employers/addedit.js', 'js/admin/employers/addedit.js')
    .js(__dirname + '/Resources/assets/js/employers/employerscandidate.js', 'js/admin/employers/employerscandidate.js')
    .js(__dirname + '/Resources/assets/js/employers/employertransaction.js', 'js/admin/employers/employertransaction.js')
    .js(__dirname + '/Resources/assets/js/employers/employers.js', 'js/admin/employers/employers.js')

    .js(__dirname + '/Resources/assets/js/subemployers/addedit.js', 'js/admin/subemployers/addedit.js')
    .js(__dirname + '/Resources/assets/js/subemployers/employerscandidate.js', 'js/admin/subemployers/employerscandidate.js')
    .js(__dirname + '/Resources/assets/js/subemployers/employertransaction.js', 'js/admin/subemployers/employertransaction.js')
    .js(__dirname + '/Resources/assets/js/subemployers/subemployers.js', 'js/admin/subemployers/subemployers.js')

    .js(__dirname + '/Resources/assets/js/transactions/transactions.js', 'js/admin/transactions/transactions.js')
    .js(__dirname + '/Resources/assets/js/candidates/candidates.js', 'js/admin/candidates/candidates.js')
    .js(__dirname + '/Resources/assets/js/positions/add.js', 'js/admin/positions/add.js')
    .js(__dirname + '/Resources/assets/js/positions/questions.js', 'js/admin/positions/questions.js')
    .js(__dirname + '/Resources/assets/js/dashboard/dashboard.js', 'js/admin/dashboard/dashboard.js')
    .js(__dirname + '/Resources/assets/js/mailcontent/mailcontent.js', 'js/admin/mailcontent/mailcontent.js')
    .js(__dirname + '/Resources/assets/js/mailcontent/editmailcontent.js', 'js/admin/mailcontent/editmailcontent.js')
    .js(__dirname + '/Resources/assets/js/cmspage/cmspage.js', 'js/admin/cmspage/cmspage.js')
    .js(__dirname + '/Resources/assets/js/cmspage/editcmspage.js', 'js/admin/cmspage/editcmspage.js')
    .js(__dirname + '/Resources/assets/js/questiontemp/questions.js', 'js/admin/questiontemp/questions.js')
    .js(__dirname + '/Resources/assets/js/offers/addedit.js', 'js/admin/offers/addedit.js')
    .js(__dirname + '/Resources/assets/js/offers/offers.js', 'js/admin/offers/offers.js');


if (mix.inProduction()) {
    mix.version();
}
