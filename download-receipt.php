<?php
require_once 'database.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user']['id'])) {
  header('Location: login.php');
  exit();
}

$user_id = $_SESSION['user']['id'];
$reservation_id = intval($_GET['reservation_id'] ?? 0);

if (!$reservation_id) {
  header('Location: bookings.php');
  exit();
}

// Get reservation details with payment info
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
    car.car_type,
    car.plate_number,
    car.rental_rate,
    p.id as payment_id,
    p.amount,
    p.payment_method,
    p.status as payment_status,
    p.created_at as payment_date
  FROM reservations r
  JOIN customers c ON r.id = c.id
  JOIN cars car ON r.car_id = car.car_id
  LEFT JOIN payments p ON r.reservation_id = p.reservation_id
  WHERE r.reservation_id = ? AND r.id = ?
');
$stmt->execute([$reservation_id, $user_id]);
$receipt = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$receipt || !$receipt['payment_id']) {
  header('Location: bookings.php');
  exit();
}

// Calculate days and total
$rentalDate = new DateTime($receipt['rental_date']);
$returnDate = new DateTime($receipt['return_date']);
$days = $returnDate->diff($rentalDate)->days;
if ($days < 1) $days = 1;

$rate = floatval($receipt['rental_rate']);
$total = $days * $rate;

$receiptNum = str_pad($receipt['reservation_id'], 6, '0', STR_PAD_LEFT);
$paymentDate = date('F d, Y h:i A', strtotime($receipt['payment_date']));
$rentalStartDate = date('F d, Y', strtotime($receipt['rental_date']));
$returnDateFormatted = date('F d, Y', strtotime($receipt['return_date']));
$paymentDateFormatted = date('F d, Y h:i A', strtotime($receipt['payment_date']));

// Generate PDF directly with proper formatting
generatePDF($receipt, $days, $rate, $total, $receiptNum, $rentalStartDate, $returnDateFormatted, $paymentDateFormatted);

function generatePDF($receipt, $days, $rate, $total, $receiptNum, $rentalStartDate, $returnDateFormatted, $paymentDateFormatted) {
  header('Content-Type: application/pdf');
  header('Content-Disposition: attachment; filename="Receipt_' . $receiptNum . '.pdf"');
  header('Cache-Control: no-cache, no-store, must-revalidate');
  
  // Build receipt text
  $text = "DRIVEEASY CAR RENTAL RECEIPT\n";
  $text .= "================================================\n\n";
  $text .= "Receipt #: " . $receiptNum . "\n";
  $text .= "Date: " . $paymentDateFormatted . "\n";
  $text .= "Status: PAYMENT RECEIVED\n\n";
  
  $text .= "CUSTOMER INFORMATION\n";
  $text .= "Name: " . $receipt['full_name'] . "\n";
  $text .= "Email: " . $receipt['email'] . "\n";
  $text .= "Phone: " . $receipt['contact_number'] . "\n\n";
  
  $text .= "VEHICLE DETAILS\n";
  $text .= "Model: " . $receipt['car_model'] . " (" . $receipt['car_type'] . ")\n";
  $text .= "Plate: " . $receipt['plate_number'] . "\n\n";
  
  $text .= "RENTAL DETAILS\n";
  $text .= "From: " . $rentalStartDate . "\n";
  $text .= "To: " . $returnDateFormatted . "\n";
  $text .= "Duration: " . $days . " day" . ($days > 1 ? 's' : '') . "\n";
  $text .= "Daily Rate: PHP " . number_format($rate, 2) . "\n\n";
  
  $text .= "PAYMENT SUMMARY\n";
  $text .= "Subtotal: PHP " . number_format($total, 2) . "\n";
  $text .= "Taxes & Fees: PHP 0.00\n";
  $text .= "================================================\n";
  $text .= "TOTAL PAID: PHP " . number_format($receipt['amount'], 2) . "\n";
  $text .= "================================================\n\n";
  
  $text .= "PAYMENT INFORMATION\n";
  $text .= "Method: " . ucfirst($receipt['payment_method']) . "\n";
  $text .= "Status: " . ucfirst($receipt['payment_status']) . "\n";
  $text .= "Payment Date: " . $paymentDateFormatted . "\n\n";
  
  $text .= "Thank you for choosing DriveEasy!\n";
  $text .= "For inquiries: support@driveeasy.com\n";
  $text .= "Keep this receipt as proof of payment\n";
  
  echo createSimplePdf($text);
  exit();
}

function createSimplePdf($text) {
  // Create a proper PDF 1.4 file structure
  $lines = explode("\n", $text);
  
  // Build PDF content stream
  $stream = "BT\n/F1 11 Tf\n50 750 Td\n";
  $yPos = 750;
  
  foreach ($lines as $line) {
    $line = str_replace('\\', '\\\\', $line);
    $line = str_replace('(', '\\(', $line);
    $line = str_replace(')', '\\)', $line);
    $stream .= "(" . $line . ") Tj\n";
    $stream .= "0 -15 Td\n";
    $yPos -= 15;
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

