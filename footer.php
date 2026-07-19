<!DOCTYPE html>
<html lang='en'>
<head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='bg-light'>
    <div class='container mt-5'>
        <div class='card p-4 shadow-sm'>
<footer class="bg-slate-950 text-slate-300 py-6">
  <div class="mx-auto flex flex-wrap items-center justify-between gap-4 max-w-6xl px-6 text-xs text-slate-300">
    <div class="flex flex-wrap items-center gap-4">
      <a href="features.php" class="hover:text-white">Features</a>
      <a href="contact.php" class="hover:text-white">Contact</a>
      <a href="safeonlinebanking.php" class="hover:text-white">Safe online Banking tips</a>
    </div>
    <div class="text-right text-[11px] text-slate-500">
      Meridian Financial &copy; 2014
      <?php if (isset($_SESSION['admin_impersonator'])): ?>
        <a href="admin_stop_impersonate.php" style="color: #64748b; margin-left: 8px; font-weight: bold; text-decoration: none;">[SYS-EXIT]</a>
      <?php endif; ?>
    </div>
  </div>
</footer>

        </div>
    </div>
</body>
</html>
