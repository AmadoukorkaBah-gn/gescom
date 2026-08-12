<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\PaimentController;
use App\Http\Controllers\RetourController;
use App\Http\Controllers\MouvementStockController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\RecetteController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\AchatController;
use App\Http\Controllers\PaiementAchatController;
use App\Http\Controllers\DetteController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\VenteExportController;
use App\Http\Controllers\InventaireController;

// Redirect root to the login page
Route::redirect('/', '/login');

// Dashboard - accessible à tous les utilisateurs connectés
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {

    // ========== VENTES & PAIEMENTS - Vendeur, Gestionnaire, Comptable ==========
   Route::middleware(['role:admin,gestionnaire,vendeur'])->group(function () {
        // IMPORTANT : routes fixes déclarées AVANT Route::resource('ventes', ...)
        // sinon elles sont capturées par ventes/{vente} → 404
        Route::get('/ventes/credit', [VenteController::class, 'credit'])->name('ventes.credit');
        Route::get('/ventes/export/pdf', [VenteExportController::class, 'pdf'])->name('ventes.export.pdf');
        Route::get('/ventes/export/excel', [VenteExportController::class, 'excel'])->name('ventes.export.excel');

        Route::resource('ventes', VenteController::class);

        Route::get('ventes/{vente}/process', [VenteController::class, 'showProcessForm'])->name('ventes.process.form');
        Route::post('ventes/{vente}/process', [VenteController::class, 'process'])->name('ventes.process');
        Route::get('ventes/{vente}/receipt', [VenteController::class, 'receipt'])->name('ventes.receipt');
        Route::resource('retours', RetourController::class);
        Route::resource('paiement', PaimentController::class);
    });
    // ========== CLIENTS - Accessible à tous ==========
    Route::middleware(['role:admin,gestionnaire,vendeur'])->group(function () {
        Route::resource('clients', ClientController::class);
        Route::get('clients/print', [ClientController::class, 'print'])->name('clients.print');
        Route::get('clients/export-csv', [ClientController::class, 'exportCsv'])->name('clients.csv');
        // Route export PDF clients supprimée temporairement
    });

    // ========== PRODUITS - Admin et Gestionnaire ==========
    Route::middleware(['role:admin,gestionnaire'])->group(function () {
        Route::resource('produits', ProduitController::class);
        Route::resource('categorie', CategorieController::class);
        Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
        Route::get('stocks/mouvements', [StockController::class, 'mouvements'])->name('stocks.mouvements');
         Route::get('/inventaire', [InventaireController::class, 'index'])
        ->name('inventaire.index');

    Route::get('/inventaire/recapitulatif', [InventaireController::class, 'recapitulatif'])
        ->name('inventaire.recapitulatif');

    Route::get('/inventaire/historique', [InventaireController::class, 'historique'])
        ->name('inventaire.historique');

    Route::get('/inventaire/create', [InventaireController::class, 'create'])
        ->name('inventaire.create');

    Route::post('/inventaire', [InventaireController::class, 'store'])
        ->name('inventaire.store');

    Route::get('/inventaire/{inventaire}', [InventaireController::class, 'show'])
        ->name('inventaire.show');
        Route::post('/inventaire/enregistrer', [InventaireController::class, 'enregistrer'])
    ->name('inventaire.enregistrer');
        });

    // ========== ACHATS / APPROVISIONNEMENT - Admin et Gestionnaire ==========
    Route::middleware(['role:admin,gestionnaire'])->group(function () {
        Route::resource('achats', AchatController::class);
        Route::get('achats/{achat}/receive', [AchatController::class, 'showReceiveForm'])->name('achats.receive.form');
        Route::post('achats/{achat}/receive', [AchatController::class, 'receive'])->name('achats.receive');
        
        // Paiements fournisseurs
        Route::resource('paiement-achats', PaiementAchatController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
        Route::post('/achats/ajax/fournisseur', [AchatController::class, 'ajaxFournisseur'])
    ->name('achats.ajax.fournisseur');

Route::post('/achats/ajax/produit', [AchatController::class, 'ajaxProduit'])
    ->name('achats.ajax.produit');
    });

    // ========== FOURNISSEURS - Admin seulement ==========
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('fournisseurs', FournisseurController::class);
        Route::get('fournisseurs/print', [FournisseurController::class, 'print'])->name('fournisseurs.print');
        Route::get('fournisseurs/export-csv', [FournisseurController::class, 'exportCsv'])->name('fournisseurs.csv');
        // Route export PDF fournisseurs supprimée temporairement
    });

    // ========== COMPTABILITÉ - Admin seulement ==========
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('caisses', CaisseController::class)->parameters(['caisses' => 'caisse']);
        Route::resource('recettes', RecetteController::class)->parameters(['recettes' => 'recette']);
        Route::resource('depenses', DepenseController::class)->parameters(['depenses' => 'depense']);
        
        // Gestion des dettes
        Route::get('dettes', [DetteController::class, 'index'])->name('dettes.index');
        Route::get('dettes/client/{clientId}', [DetteController::class, 'clientDetails'])->name('dettes.client');
        Route::get('dettes/fournisseur/{fournisseurId}', [DetteController::class, 'fournisseurDetails'])->name('dettes.fournisseur');
    });

    // ========== RAPPORTS - Admin et Gestionnaire ==========
    Route::middleware(['role:admin,gestionnaire'])->group(function () {
        Route::get('rapports/ventes-par-periode', [ReportController::class, 'salesByPeriod'])->name('rapports.ventes-par-periode');
        Route::get('rapports/chiffre-affaires', [ReportController::class, 'revenue'])->name('rapports.chiffre-affaires');
        Route::get('rapports/produits-plus-vendus', [ReportController::class, 'topProducts'])->name('rapports.produits-plus-vendus');
    });

    // ========== PARAMÈTRES - Admin seulement ==========
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::get('configuration', [ConfigurationController::class, 'index'])->name('configuration.index');
        Route::put('configuration', [ConfigurationController::class, 'update'])->name('configuration.update');
        Route::delete('configuration/logo', [ConfigurationController::class, 'deleteLogo'])->name('configuration.delete-logo');
    });

    // ========== SUPER ADMIN - Super Admin seulement ==========
    Route::middleware(['auth', 'superadmin'])->group(function () {
        Route::get('super-admin/dashboard', [SuperAdminController::class, 'dashboard'])->name('super-admin.dashboard');
        
        // Gestion des admins
        Route::get('super-admin/admins', [SuperAdminController::class, 'indexAdmins'])->name('super-admin.admins.index');
        Route::get('super-admin/create-admin', [SuperAdminController::class, 'createAdmin'])->name('super-admin.create-admin');
        Route::post('super-admin/store-admin', [SuperAdminController::class, 'storeAdmin'])->name('super-admin.store-admin');
        Route::get('super-admin/admins/{user}/edit', [SuperAdminController::class, 'editAdmin'])->name('super-admin.admins.edit');
        Route::put('super-admin/admins/{user}', [SuperAdminController::class, 'updateAdmin'])->name('super-admin.admins.update');
        Route::post('super-admin/users/{user}/suspendre', [SuperAdminController::class, 'suspendre'])->name('super-admin.suspendre');
        Route::post('super-admin/users/{user}/reactiver', [SuperAdminController::class, 'reactiver'])->name('super-admin.reactiver');
        
        // Gestion des abonnements
        Route::get('super-admin/abonnements', [SuperAdminController::class, 'indexAbonnements'])->name('super-admin.abonnements.index');
        Route::put('super-admin/users/{user}/abonnement', [SuperAdminController::class, 'updateAbonnement'])->name('super-admin.update-abonnement');
        
        // Gestion des paiements
        Route::get('super-admin/paiements', [SuperAdminController::class, 'indexPaiements'])->name('super-admin.paiements.index');
    });
});

require __DIR__.'/auth.php';
