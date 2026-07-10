<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

$router->get('/', 'HomeController@index');

$router->get('/about', 'HomeController@about');

$router->get('/contact', 'HomeController@contact');

/*
|--------------------------------------------------------------------------
| AUTHENTIFICATION
|--------------------------------------------------------------------------
*/

$router->get('/login', 'AuthController@login');

$router->get('/login/admin', 'AuthController@loginAdmin');

$router->get('/login/medecin', 'AuthController@loginMedecin');

$router->get('/login/patient', 'AuthController@loginPatient');

$router->post('/login', 'AuthController@authenticate');

$router->get('/forgot-password', 'AuthController@forgotPassword');

$router->post('/forgot-password', 'AuthController@forgotPassword');

$router->get('/register', 'AuthController@register');

$router->get('/register/admin', 'AuthController@registerAdmin');

$router->get('/register/medecin', 'AuthController@registerMedecin');

$router->get('/register/patient', 'AuthController@registerPatient');

$router->post('/register', 'AuthController@store');

$router->get('/logout', 'AuthController@logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

$router->get('/dashboard', 'DashboardController@index');

$router->get('/dashboard/admin', 'DashboardController@admin');

$router->get('/admin', 'AdminController@index');

$router->get('/dashboard/medecin', 'DashboardController@medecin');

$router->get('/dashboard/patient', 'DashboardController@patient');

/*
|--------------------------------------------------------------------------
| ESPACE PLATEFORME
|--------------------------------------------------------------------------
*/

$router->get('/notifications', 'PlatformController@notifications');

$router->get('/profil', 'PlatformController@profil');

$router->get('/parametres', 'PlatformController@parametres');

$router->get('/statistiques', 'PlatformController@statistiques');
/*
|--------------------------------------------------------------------------
| PATIENTS
|--------------------------------------------------------------------------
*/

$router->get('/patients', 'PatientController@index');

$router->get('/patient/create', 'PatientController@create');

$router->post('/patient/store', 'PatientController@store');

$router->get('/patient/show', 'PatientController@show');

$router->get('/patient/edit', 'PatientController@edit');

$router->post('/patient/update', 'PatientController@update');

$router->get('/patient/delete', 'PatientController@delete');

$router->get('/patient/search', 'PatientController@search');

$router->get('/patient/dashboard', 'PatientController@dashboard');

/*
|--------------------------------------------------------------------------
| MEDECINS
|--------------------------------------------------------------------------
*/

$router->get('/medecins', 'MedecinController@index');

$router->get('/medecin/create', 'MedecinController@create');

$router->post('/medecin/store', 'MedecinController@store');

$router->get('/medecin/show', 'MedecinController@show');

$router->get('/medecin/edit', 'MedecinController@edit');

$router->post('/medecin/update', 'MedecinController@update');

$router->get('/medecin/delete', 'MedecinController@delete');

$router->get('/medecin/search', 'MedecinController@search');

$router->get('/medecin/disponibles', 'MedecinController@disponibles');

$router->get('/medecin/indisponibles', 'MedecinController@indisponibles');

$router->get('/medecin/dashboard', 'MedecinController@dashboard');
/*
|--------------------------------------------------------------------------
| CONSTANTES VITALES
|--------------------------------------------------------------------------
*/

$router->get('/constantes', 'ConstanteController@index');

$router->get('/constante/create', 'ConstanteController@create');

$router->post('/constante/store', 'ConstanteController@store');

$router->get('/constante/show', 'ConstanteController@show');

$router->get('/constante/edit', 'ConstanteController@edit');

$router->post('/constante/update', 'ConstanteController@update');

$router->get('/constante/delete', 'ConstanteController@delete');

$router->get('/constante/patient', 'ConstanteController@patient');

$router->get('/constante/critiques', 'ConstanteController@critiques');

$router->get('/constante/dashboard', 'ConstanteController@dashboard');

/*
|--------------------------------------------------------------------------
| DIAGNOSTICS
|--------------------------------------------------------------------------
*/

$router->get('/diagnostics', 'DiagnosticController@index');

$router->get('/diagnostic/create', 'DiagnosticController@create');

$router->post('/diagnostic/store', 'DiagnosticController@store');

$router->get('/diagnostic/show', 'DiagnosticController@show');

$router->get('/diagnostic/edit', 'DiagnosticController@edit');

$router->post('/diagnostic/update', 'DiagnosticController@update');

$router->get('/diagnostic/delete', 'DiagnosticController@delete');

$router->get('/diagnostic/validate', 'DiagnosticController@validate');

$router->get('/diagnostic/archive', 'DiagnosticController@archive');

$router->get('/diagnostic/search', 'DiagnosticController@search');

$router->get('/diagnostic/dashboard', 'DiagnosticController@dashboard');

/*
|--------------------------------------------------------------------------
| ALERTES
|--------------------------------------------------------------------------
*/

$router->get('/alertes', 'AlerteController@index');

$router->get('/alerte/create', 'AlerteController@create');

$router->post('/alerte/store', 'AlerteController@store');

$router->get('/alerte/show', 'AlerteController@show');

$router->get('/alerte/edit', 'AlerteController@edit');

$router->post('/alerte/update', 'AlerteController@update');

$router->get('/alerte/delete', 'AlerteController@delete');

$router->get('/alerte/prendre-en-charge', 'AlerteController@prendreEnCharge');

$router->get('/alerte/resoudre', 'AlerteController@resoudre');

$router->get('/alerte/dashboard', 'AlerteController@dashboard');

/*
|--------------------------------------------------------------------------
| RAPPORTS
|--------------------------------------------------------------------------
*/

$router->get('/rapports', 'RapportController@index');

$router->get('/rapport/create', 'RapportController@create');

$router->post('/rapport/store', 'RapportController@store');

$router->get('/rapport/show', 'RapportController@show');

$router->get('/rapport/pdf', 'RapportController@pdf');

$router->get('/rapport/edit', 'RapportController@edit');

$router->post('/rapport/update', 'RapportController@update');

$router->get('/rapport/delete', 'RapportController@delete');
