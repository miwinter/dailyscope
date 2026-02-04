<?php
// contact.php

// --- CONFIG ---
$recipient = "winter.michel@gmail.com"; // ⇦ remplace par ton adresse
$site_name = "DailyScope.ai";

// --- OUTILS ---
function e($s) { return htmlspecialchars($s ?? "", ENT_QUOTES, "UTF-8"); }
function sanitize_header($s) { return str_replace(["\r", "\n"], "", trim($s ?? "")); }

function render_page($title, $inner_html) {
  // Page complète qui reprend l’allure du site
  $includes = <<<'EOT'
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="icon" type="image/png" href="/assets/images/dailyscope-favicon.png">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/assets/css/fontawesome-5.15.4.min.css">
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="/assets/css/owl.theme.default.min.css">

<meta name="description"
      content="DailyScope.ai automatically analyzes global news to highlight the most covered countries and themes.">
<meta property="og:title" content="DailyScope.ai — Today’s global news signals">
<meta property="og:description"
      content="DailyScope.ai automatically analyzes global news to highlight the most covered countries and themes.">
<meta property="og:image" content="https://www.dailyscope.ai/assets/images/dailyscope-carte.jpg">
<meta property="og:url" content="https://www.dailyscope.ai/en/">
<meta property="og:type" content="website">
<meta property="og:site_name" content="DailyScope.ai">
<link rel="canonical" href="https://www.dailyscope.ai/en/">

<script>
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
        page_lang: 'en',
        page_type: 'contact_processing',
        
        
        
});
    (function(w,d,s,l,i){
        w[l]=w[l]||[];
        w[l].push({'gtm.start': new Date().getTime(), event:'gtm.js'});
        var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),
            dl=l!='dataLayer'?'&l='+l:'';
        j.async=true;
        j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
        f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KL7V4FQH');
</script>
EOT;

  $header = <<<'EOT'
  <header>  
  <div class="middle-section py-2" style="background-color:#244855;">
      <div class="container">
        <div class="row row-cols-1 row-cols-lg-3 align-items-center">
            <div class="col order-3 order-lg-1"><!-- vide --></div>
             <div class="col order-1 order-lg-2 d-flex justify-content-center align-items-center">
                <a href="/" class="logo d-table"><img src="/assets/images/logo-3-50.jpg" alt="logo"></a>
            </div>
            <div class="col d-flex justify-content-end align-self-start order-2 order-lg-3">
              <a id="lang-switch" href="#"><img src="/assets/images/flags/fra.svg" style="width: 24px;height: 16px;object-fit: cover;border-radius: 2px;border: 1px solid #ddd;vertical-align: middle;" alt="Français" title="Français" class="flag-icon"></a>
              <script>
                const currentUrl = window.location.href;
                const englishUrl = currentUrl.replace('/en', '/fr');
                document.getElementById('lang-switch').setAttribute('href', englishUrl);
              </script>              
            </div>
        </div>
      </div>

  </div>
</header>

<div class="main-menu">
  <nav class="navbar navbar-expand-lg navbar-light">

    <div id="menu-id">
      <div class="container">
        <a class="navbar-brand d-block d-none" href="/">Navbar</a>
        <button class="navbar-toggler float-start" type="button" data-bs-toggle="offcanvas" href="#mobilemenu" role="button" aria-controls="offcanvasExample">
          <span>
            <i class="fas fa-bars"></i>
          </span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/">News</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/en/2026-02-04/country_counts.html">Top Countries</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/en/2026-02-04/labels.html">Top Themes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/en/2026-02-04/c1.html">In Focus</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/en/about.html">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/en/contact.html">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</div>
EOT;

  $footer = <<<'EOT'
   <footer class="mt-5">
  <div class="container">
     <div class="row">
           <div class="left-footer">
              <p class="text-center"> 2025-2026 © DailyScope.ai |
                <a href="/en/privacy.html">Privacy Policy</a> |
                <a href="/en/terms.html">Terms of Use</a>
              </p>
           </div>
     </div>
  </div>
</footer>


<!-- mobile menu -->

<div class="offcanvas offcanvas-start" tabindex="-1" id="mobilemenu" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="head-contact">
      <a href="/" class="logo-side">
      <img src="/assets/images/logo-3-50.png" alt="logo">
      </a>
      
      <div class="mobile-menu-sec mt-3">
         <ul class="list-unstyled">
            <li>
               <a href="/">News </a>
            </li>
            <li>
              <a href="/en/2026-02-04/country_counts.html">Top Countries</a>
            </li>
            <li>
              <a href="/en/2026-02-04/labels.html">Top Themes</a>
            </li>
            <li>
              <a href="/en/2026-02-04/c1.html">In Focus</a>
            </li>
            <li>
              <a href="/en/about.html">About</a>
            </li>
            <li>
              <a href="/en/contact.html">Contact</a>
            </li>
         </ul>
      </div>
   </div>
  </div>
</div>

<script src="/assets/js/bootstrap.bundle.min.js"></script>
EOT;

  echo '
<!DOCTYPE html>
<html lang="en">
<head>
<title>DailyScope.ai - Contact</title>
'.$includes.'
</head>
<body>
'.$header.'
  <!-- Contenu -->
  <main class="conatct-page py-5">
    <div class="container" style="max-width: 860px;">
      '.$inner_html.'
    </div>
  </main>
'.$footer.'
</body>
</html>';
exit;
}

// --- TRAITEMENT UNIQUEMENT EN POST ---
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  render_page("Contact", '<div class="alert alert-warning" role="alert">
    Direct access to this page. Please use the contact form.
  </div>');
}

// --- ANTI-SPAM HONEYPOT ---
if (!empty($_POST['company'])) {
  render_page("Contact", '<div class="alert alert-danger" role="alert">
    Error: spam attempt detected.
  </div>');
}

// --- RÉCUPÉRATION DES CHAMPS ---
$email            = trim($_POST['email'] ?? "");
$subject          = trim($_POST['subject'] ?? "");
$message          = trim($_POST['message'] ?? "");
$captcha_answer   = trim($_POST['captcha_answer'] ?? "");
$captcha_expected = trim($_POST['captcha_expected'] ?? "");

// --- VALIDATIONS ---
$errors = [];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = "Invalid email address.";
}
if ($subject === "" || $message === "") {
  $errors[] = "Subject and message are required.";
}
if ($captcha_answer === "" || $captcha_answer !== $captcha_expected) {
  $errors[] = "Incorrect captcha.";
}

if ($errors) {
  $lis = "";
  foreach ($errors as $e) { $lis .= "<li>".e($e)."</li>"; }
  render_page("Contact — Erreur", '<div class="alert alert-danger" role="alert">
    <h4 class="alert-heading">Error sending message</h4>
    <ul class="mb-0">'.$lis.'</ul>
  </div>');
}

// --- ENVOI EMAIL ---
$clean_subject = sanitize_header($subject);
$clean_email   = sanitize_header($email);

$headers  = "From: contact@dailyscope.ai\r\n";
$headers .= "Reply-To: ".$clean_email."\r\n";
$headers .= "Content-Type: text/plain; charset=utf-8\r\n";

$body  = "Message envoyé depuis le site ".$site_name."\n";
$body .= "---------------------------------------\n";
$body .= "Email expéditeur : ".$clean_email."\n";
$body .= "Sujet : ".$clean_subject."\n";
$body .= "---------------------------------------\n";
$body .= $message."\n";

$ok = @mail($recipient, "[Contact] ".$clean_subject, $body, $headers);

if ($ok) {
  render_page("Contact — Thank you!", '<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Thank you!</h4>
    <p class="mb-0">Your message has been sent. We will get back to you shortly.</p>
  </div>');
} else {
  render_page("Contact — Technical error", '<div class="alert alert-danger" role="alert">
    <h4 class="alert-heading">Technical error</h4>
    <p class="mb-0">Your message could not be sent. Please try again later.</p>
  </div>');
}

?>