<?php
/**
 * AgriStack — Dashboard Controller (routes by role)
 */
class DashboardController {
    private Listing  $listingModel;
    private Booking  $bookingModel;

    public function __construct() {
        $this->listingModel = new Listing();
        $this->bookingModel = new Booking();
    }

    public function index(): void {
        requireAuth();
        $role = $_SESSION['user_role'];

        if ($role === 'admin') {
            redirect('admin');
        } elseif ($role === 'farmer') {
            $listings = $this->listingModel->getByFarmer($_SESSION['user_id']);
            $stats = [
                'total_listings'  => count($listings),
                'pending'         => count(array_filter($listings, fn($l) => $l['status']==='pending')),
                'approved'        => count(array_filter($listings, fn($l) => $l['status']==='approved')),
                'rejected'        => count(array_filter($listings, fn($l) => $l['status']==='rejected')),
            ];
            require_once ROOT . '/app/views/farmer/dashboard.php';
        } else {
            $bookings = $this->bookingModel->getByBuyer($_SESSION['user_id']);
            $stats = [
                'total_bookings'   => count($bookings),
                'pending'          => count(array_filter($bookings, fn($b) => $b['status']==='pending')),
                'approved'         => count(array_filter($bookings, fn($b) => $b['status']==='approved')),
                'collected'        => count(array_filter($bookings, fn($b) => $b['status']==='collected')),
                'total_spent'      => array_sum(array_column(
                    array_filter($bookings, fn($b) => $b['status']==='collected'),
                    'total_value'
                )),
            ];
            require_once ROOT . '/app/views/buyer/dashboard.php';
        }
    }
}
