<?php
require_once 'database.php';
session_start();

// Check admin role
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
  header('Location: login.php');
  exit();
}

// Get today's date
$today = date('Y-m-d');

// Get today's bookings (all statuses)
$stmt = $pdo->prepare('
  SELECT 
    r.reservation_id,
    r.id as customer_id,
    r.car_id,
    r.rental_date,
    r.return_date,
    r.total_amount,
    r.status,
    c.full_name,
    c.email,
    c.contact_number,
    car.car_model,
    car.plate_number,
    car.rental_rate
  FROM reservations r
  JOIN customers c ON r.id = c.id
  JOIN cars car ON r.car_id = car.car_id
  WHERE DATE(r.rental_date) = ? OR DATE(r.return_date) = ? OR r.status = "Confirmed"
  ORDER BY r.rental_date ASC
');
$stmt->execute([$today, $today]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get payments for today
$stmt = $pdo->prepare('
  SELECT 
    p.id,
    p.reservation_id,
    p.amount,
    p.payment_method,
    p.status,
    p.created_at,
    c.full_name,
    car.car_model
  FROM payments p
  JOIN reservations r ON p.reservation_id = r.reservation_id
  JOIN customers c ON r.id = c.id
  JOIN cars car ON r.car_id = car.car_id
  WHERE DATE(p.created_at) = ?
  ORDER BY p.created_at DESC
');
$stmt->execute([$today]);
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get statistics
$totalBookingsToday = count($bookings);
$activeBookings = count(array_filter($bookings, fn($b) => $b['status'] === 'Confirmed'));
$totalRevenueToday = array_sum(array_map(fn($p) => $p['amount'], $payments));

// Get statistics
$totalBookingsToday = count($bookings);
$activeBookings = count(array_filter($bookings, fn($b) => $b['status'] === 'Confirmed'));
$totalRevenueToday = array_sum(array_map(fn($p) => $p['amount'], $payments));

// Output as PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="daily-report-' . $today . '.pdf"');
header('Cache-Control: no-cache, no-store, must-revalidate');

// Build report text
$reportText = "DRIVEEASY - DAILY REPORT\n";
$reportText .= "================================================\n";
$reportText .= "Date: " . date('F d, Y', strtotime($today)) . "\n";
$reportText .= "Generated: " . date('F d, Y - h:i A') . "\n";
$reportText .= "================================================\n\n";

$reportText .= "DAILY STATISTICS\n";
$reportText .= "Total Bookings: " . $totalBookingsToday . "\n";
$reportText .= "Active (Confirmed): " . $activeBookings . "\n";
$reportText .= "Revenue from Payments: PHP " . number_format($totalRevenueToday, 2) . "\n\n";

$reportText .= "TODAY'S BOOKINGS\n";
$reportText .= "================================================\n";
if (empty($bookings)) {
  $reportText .= "No bookings for today\n\n";
} else {
  foreach ($bookings as $booking) {
    $reportText .= "Res #" . $booking['reservation_id'] . " | " . htmlspecialchars($booking['full_name']) . " | ";
    $reportText .= htmlspecialchars($booking['car_model']) . " | " . $booking['rental_date'] . " to " . $booking['return_date'];
    $reportText .= " | PHP " . number_format($booking['total_amount'], 2) . " | " . ucfirst($booking['status']) . "\n";
  }
}

$reportText .= "\nPAYMENT TRANSACTIONS\n";
$reportText .= "================================================\n";
if (empty($payments)) {
  $reportText .= "No payments recorded today\n\n";
} else {
  foreach ($payments as $payment) {
    $reportText .= date('h:i A', strtotime($payment['created_at'])) . " | ";
    $reportText .= htmlspecialchars($payment['full_name']) . " | ";
    $reportText .= "PHP " . number_format($payment['amount'], 2) . " | ";
    $reportText .= ucfirst($payment['payment_method']) . "\n";
  }
}

$reportText .= "\nACTIVE RENTALS\n";
$reportText .= "================================================\n";
$activeRentalsArray = array_filter($bookings, fn($b) => $b['status'] === 'Confirmed');
if (empty($activeRentalsArray)) {
  $reportText .= "No active rentals\n";
} else {
  foreach ($activeRentalsArray as $rental) {
    $rentalDate = new DateTime($rental['rental_date']);
    $returnDate = new DateTime($rental['return_date']);
    $days = $returnDate->diff($rentalDate)->days;
    if ($days < 1) $days = 1;
    
    $reportText .= htmlspecialchars($rental['full_name']) . " | ";
    $reportText .= htmlspecialchars($rental['car_model']) . " (" . htmlspecialchars($rental['plate_number']) . ") | ";
    $reportText .= $days . " days\n";
  }
}

$reportText .= "\n================================================\n";
$reportText .= "Report End\n";
$reportText .= "Generated: " . date('Y-m-d H:i:s') . "\n";

echo createSimplePdf($reportText);
exit();

function createSimplePdf($text) {
  // Create a proper PDF 1.4 file structure
  $lines = explode("\n", $text);
  
  // Build PDF content stream
  $stream = "BT\n/F1 10 Tf\n40 750 Td\n";
  $yPos = 750;
  
  foreach ($lines as $line) {
    $line = str_replace('\\', '\\\\', $line);
    $line = str_replace('(', '\\(', $line);
    $line = str_replace(')', '\\)', $line);
    $stream .= "(" . $line . ") Tj\n";
    $stream .= "0 -12 Td\n";
    $yPos -= 12;
    
    // New page if needed
    if ($yPos < 50) {
      $stream .= "ET\nQ\n";
      $stream .= "BT\n/F1 10 Tf\n40 750 Td\n";
      $yPos = 750;
    }
  }
  $stream .= "ET\n";
  
  // Build PDF structure
  $pdf = "%PDF-1.4\n";
  $pdf .= "%\xE2\xE3\xCF\xD3\n"; // Binary comment to mark as binary
  
  $objOffsets = [];
  $currentOffset = strlen($pdf);
  
  // Object 1: Catalog
  $objOffsets[1] = $currentOffset;
  $obj1 = "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
  $pdf .= $obj1;
  $currentOffset += strlen($obj1);
  
  // Object 2: Pages
  $objOffsets[2] = $currentOffset;
  $obj2 = "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
  $pdf .= $obj2;
  $currentOffset += strlen($obj2);
  
  // Object 3: Page
  $objOffsets[3] = $currentOffset;
  $obj3 = "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj\n";
  $pdf .= $obj3;
  $currentOffset += strlen($obj3);
  
  // Object 4: Stream (content)
  $objOffsets[4] = $currentOffset;
  $obj4 = "4 0 obj\n<< /Length " . strlen($stream) . " >>\nstream\n" . $stream . "endstream\nendobj\n";
  $pdf .= $obj4;
  $currentOffset += strlen($obj4);
  
  // Object 5: Font
  $objOffsets[5] = $currentOffset;
  $obj5 = "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";
  $pdf .= $obj5;
  $currentOffset += strlen($obj5);
  
  // Cross-reference table
  $xrefOffset = strlen($pdf);
  $pdf .= "xref\n";
  $pdf .= "0 6\n";
  $pdf .= "0000000000 65535 f \n";
  foreach (range(1, 5) as $i) {
    $pdf .= str_pad($objOffsets[$i], 10, "0", STR_PAD_LEFT) . " 00000 n \n";
  }
  
  // Trailer
  $pdf .= "trailer\n";
  $pdf .= "<< /Size 6 /Root 1 0 R >>\n";
  $pdf .= "startxref\n";
  $pdf .= $xrefOffset . "\n";
  $pdf .= "%%EOF\n";
  
  return $pdf;
}
