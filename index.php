<?php
/**
 * AgriStack — Front Controller
 * All requests route through here.
 */

define('ROOT', __DIR__);
session_start();

require_once ROOT . '/config/database.php';
require_once ROOT . '/app/models/User.php';
require_once ROOT . '/app/models/Listing.php';
require_once ROOT . '/app/models/Booking.php';
require_once ROOT . '/app/models/AuditLog.php';
require_once ROOT . '/app/controllers/AuthController.php';
require_once ROOT . '/app/controllers/ListingController.php';
require_once ROOT . '/app/controllers/BookingController.php';
require_once ROOT . '/app/controllers/AdminController.php';
require_once ROOT . '/app/controllers/DashboardController.php';

// ── Simple router ─────────────────────────────────────────────
$page    = $_GET['page']   ?? 'home';
$action  = $_GET['action'] ?? 'index';

$auth      = new AuthController();
$listCtrl  = new ListingController();
$bookCtrl  = new BookingController();
$adminCtrl = new AdminController();
$dashCtrl  = new DashboardController();

switch ($page) {

    // ── Auth ─────────────────────────────────────────────
    case 'login':    $auth->login();    break;
    case 'register': $auth->register(); break;
    case 'logout':   $auth->logout();   break;

    // ── Listings ─────────────────────────────────────────
    case 'listings':
        match($action) {
            'create' => $listCtrl->create(),
            'store'  => $listCtrl->store(),
            'edit'   => $listCtrl->edit(),
            'update' => $listCtrl->update(),
            'delete' => $listCtrl->delete(),
            'show'   => $listCtrl->show(),
            default  => $listCtrl->index(),
        };
        break;

    // ── Bookings ─────────────────────────────────────────
    case 'bookings':
        match($action) {
            'create'   => $bookCtrl->create(),
            'store'    => $bookCtrl->store(),
            'cancel'   => $bookCtrl->cancel(),
            'collect'  => $bookCtrl->markCollected(),
            default    => $bookCtrl->index(),
        };
        break;

    // ── Admin ─────────────────────────────────────────────
    case 'admin':
        requireRole('admin');
        match($action) {
            'listings'      => $adminCtrl->listings(),
            'approve'       => $adminCtrl->approveListing(),
            'reject'        => $adminCtrl->rejectListing(),
            'orders'        => $adminCtrl->orders(),
            'approve-order' => $adminCtrl->approveOrder(),
            'users'         => $adminCtrl->users(),
            'audit'         => $adminCtrl->auditLog(),
            default         => $adminCtrl->dashboard(),
        };
        break;

    // ── Dashboard ────────────────────────────────────────
    case 'dashboard':
        requireAuth();
        $dashCtrl->index();
        break;

    // ── Home ─────────────────────────────────────────────
    default:
        if (isLoggedIn()) {
            $dashCtrl->index();
        } else {
            $auth->login();
        }
        break;
}

// ── Auth helpers ─────────────────────────────────────────────

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function requireAuth(): void {
    if (!isLoggedIn()) {
        redirect('login');
    }
}

function requireRole(string $role): void {
    requireAuth();
    if ($_SESSION['user_role'] !== $role) {
        die('<h2>Access Denied. You must be ' . htmlspecialchars($role) . ' to view this page.</h2>');
    }
}

function redirect(string $page, string $action = ''): void {
    $url = BASE_URL . '/index.php?page=' . $page;
    if ($action) $url .= '&action=' . $action;
    header('Location: ' . $url);
    exit;
}

function flash(string $key, string $msg = ''): string {
    if ($msg) {
        $_SESSION['flash'][$key] = $msg;
        return '';
    }
    $val = $_SESSION['flash'][$key] ?? '';
    unset($_SESSION['flash'][$key]);
    return $val;
}
