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
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/assets/css/font-awesome.min.css">
<link href="/assets/css/all.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="/assets/css/owl.theme.default.min.css">
  EOT;

  $header = <<<'EOT'
  <header>  
  <div class="middle-section py-2">
      <div class="container">
        <div class="row row-cols-1 row-cols-lg-3 align-items-center">
            <div class="col order-3 order-lg-1"><!-- vide --></div>
             <div class="col order-1 order-lg-2 d-flex justify-content-center align-items-center">
                <a href="/" class="logo d-table"><img src="/assets/images/logo-3-50.jpg" alt="logo"></a>
            </div>
            <div class="col d-flex justify-content-end align-self-start order-2 order-lg-3">
              <a id="lang-switch" href="#"><img src="/assets/images/flags/gbr.svg" style="width: 24px;height: 16px;object-fit: cover;border-radius: 2px;border: 1px solid #ddd;vertical-align: middle;" alt="English" title="English" class="flag-icon"></a>
              <script>
                const currentUrl = window.location.href;
                const englishUrl = currentUrl.replace('/fr', '/en');
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
              <a class="nav-link active" aria-current="page" href="/fr/">Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/fr/about.html">A Propos</a>
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
              <p class="text-center"> 2025-2026 © DailyScope.ai</p>
           </div>
     </div>
  </div>
</footer>


<!-- mobile menu -->

<div class="offcanvas offcanvas-start" tabindex="-1" id="mobilemenu" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <button type="button" class="close-menu text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
      Close <i class="fas fa-long-arrow-alt-left"></i>
    </button>
  </div>
  <div class="offcanvas-body">
    <div class="head-contact">
      <a href="/" class="logo-side">
      <img src="/assets/images/logo-3-50.png" alt="logo">
      </a>
      
      <div class="mobile-menu-sec mt-3">
         <ul class="list-unstyled">
            <li class="active-m">
               <a href="/">Accueil </a>
            </li>
            <li>
              <a href="/en/about.html">A Propos </a>
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
<title>DailyScope.ai - About</title>
'.$includes.'
</head>
<body>
'.$header.'
  <!-- Contenu -->
  <main class="conatct-page py-5">
    <div class="container" style="max-width: 860px;">
      '.$inner_html.'
      <div class="mt-4">
        <a href="/contact.html" class="btn btn-primary">Retour au formulaire</a>
      </div>
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
    Accès direct à cette page. Veuillez utiliser le formulaire de contact.
  </div>');
}

// --- ANTI-SPAM HONEYPOT ---
if (!empty($_POST['company'])) {
  render_page("Contact", '<div class="alert alert-danger" role="alert">
    Erreur : tentative de spam détectée.
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
  $errors[] = "Adresse email invalide.";
}
if ($subject === "" || $message === "") {
  $errors[] = "Sujet et message sont obligatoires.";
}
if ($captcha_answer === "" || $captcha_answer !== $captcha_expected) {
  $errors[] = "Captcha incorrect.";
}

if ($errors) {
  $lis = "";
  foreach ($errors as $e) { $lis .= "<li>".e($e)."</li>"; }
  render_page("Contact — Erreur", '<div class="alert alert-danger" role="alert">
    <h4 class="alert-heading">Erreur lors de l''envoi du message</h4>
    <ul class="mb-0">'.$lis.'</ul>
  </div>');
}

// --- ENVOI EMAIL ---
$clean_subject = sanitize_header($subject);
$clean_email   = sanitize_header($email);

$headers  = "From: ".$clean_email."\r\n";
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
  render_page("Contact — Merci", '<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Merci !</h4>
    <p class="mb-0">Votre message a bien été envoyé. Nous vous répondrons rapidement.</p>
  </div>');
} else {
  render_page("Contact — Erreur technique", '<div class="alert alert-danger" role="alert">
    <h4 class="alert-heading">Erreur technique</h4>
    <p class="mb-0">Le message n’a pas pu être envoyé. Veuillez réessayer plus tard.</p>
  </div>');
}

?>